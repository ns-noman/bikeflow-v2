<?php

namespace App\Services;

use App\Models\Account;
use App\Models\AccountLedger;
use App\Models\Branch;
use App\Models\BranchLedger;
use App\Models\Investor;
use App\Models\InvestorLedger;
use App\Models\Supplier;
use App\Models\SupplierLedger;
use App\Models\Party;
use App\Models\PartyLedger;
use App\Models\PaymentMethod;
use App\Models\Customer;
use App\Models\CustomerLedger;


use Illuminate\Support\Facades\DB;
use Auth;

class SystemService
{
    public static function getUserInfo()
    {
        return Auth::guard('admin')->user();
    }
    public static function getCompanyId()
    {
        return Auth::guard('admin')->user()->company_id;
    }
    public static function getUserId()
    {
        return Auth::guard('admin')->user()->id;
    }   
    public static function generateNextEightDigitNumber($number)
    {
       return max(10000001, $number + 1);
    }

    public static function paymentMethods()
    {
        return PaymentMethod::join('accounts', 'accounts.payment_method_id', '=','payment_methods.id')
        ->where(['is_virtual'=>0, 'payment_methods.status'=>1, 'accounts.status'=>1])
        ->where('company_id', SystemService::getUserId())
        ->select([
            'accounts.id',
            'payment_methods.name',
            'accounts.account_no',
            'accounts.balance',
        ])
        ->get()->toArray();
    }

    public static function investorLedger($data)
    {
        try {
            DB::beginTransaction();
            $data['credit_amount'] = (float) ($data['credit_amount'] ?? 0);
            $data['debit_amount'] = (float) ($data['debit_amount'] ?? 0);
            $data['particular'] = $data['particular'] ?? null;
            $data['transaction_type'] = $data['transaction_type'] ?? null;
            $currentBalance = InvestorLedger::where(['investor_id'=>$data['investor_id']])->orderBy('id','desc')->pluck('current_balance')->first() ?? 0;
            $newcurrentBalance = $currentBalance + $data['credit_amount'] - $data['debit_amount'];
            $data['current_balance'] = $newcurrentBalance;
            InvestorLedger::create($data);
            Investor::find($data['investor_id'])->update(['balance'=>$newcurrentBalance]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function supplierLedgerTransaction(array $data)
    {
        DB::transaction(function () use ($data) {

            // Fetch current balance safely
            $currentBalance = SupplierLedger::where('supplier_id', $data['supplier_id'])
                ->latest('id')
                ->value('current_balance') ?? 0;

            // Prepare ledger data
            $ledgerData = [
                'supplier_id'       => $data['supplier_id'],
                'purchase_id'       => $data['purchase_id'] ?? null,
                'payment_id'        => $data['payment_id'] ?? null,
                'account_id'        => $data['account_id'] ?? null,
                'particular'        => $data['particular'] ?? null,
                'date'              => $data['date'] ?? now(),
                'debit_amount'      => $data['debit_amount'] ?? 0,
                'credit_amount'     => $data['credit_amount'] ?? 0,
                'reference_number'  => $data['reference_number'] ?? null,
                'note'              => $data['note'] ?? null,
                'created_by_id'     => $data['created_by_id'] ?? auth()->id(),
                'updated_by_id'     => $data['updated_by_id'] ?? auth()->id(),
                'current_balance'   => $currentBalance + ($data['debit_amount'] ?? 0) - ($data['credit_amount'] ?? 0),
            ];

            // Insert ledger entry
            SupplierLedger::create($ledgerData);

            // Update supplier balance atomically
            Supplier::where('id', $data['supplier_id'])
                ->update(['current_balance' => $ledgerData['current_balance']]);
        });
    }
    public static function customerLedgerTransction($data)
    {
        DB::beginTransaction();
        try {
            $currentBalance = CustomerLedger::where('customer_id', $data['customer_id'])
                                ->orderBy('id', 'desc')
                                ->first()->current_balance ?? 0;
            $data['customer_id'] = $data['customer_id'];
            $data['sale_id'] = $data['sale_id'] ?? null;
            $data['payment_id'] = $data['payment_id'] ?? null;
            $data['account_id'] = $data['account_id'] ?? null;
            $data['particular'] = $data['particular'] ?? null;
            $data['date'] = $data['date'] ?? null;
            $data['debit_amount'] = $data['debit_amount'] ?? null;
            $data['credit_amount'] = $data['credit_amount'] ?? null;
            $data['reference_number'] = $data['reference_number'] ?? null;
            $data['note'] = $data['note'] ?? null;
            $data['created_by_id'] = $data['created_by_id'] ?? null;
            $data['updated_by_id'] = $data['updated_by_id'] ?? null;
            $data['current_balance'] = $currentBalance - $data['debit_amount'] + $data['credit_amount'];
            CustomerLedger::create($data);
            Customer::find($data['customer_id'])->update(['current_balance'=> $data['current_balance']]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    
    public static function accountTransaction($data)
    {
        try {
            DB::beginTransaction(); // Start Transaction
    
            // Ensure credit and debit amounts are set
            $data['credit_amount'] = $data['credit_amount'] ?? 0;
            $data['debit_amount'] = $data['debit_amount'] ?? 0;

    
    
            // Get latest account balance (or default to 0)
            $currentAccountBalance = AccountLedger::where('account_id', $data['account_id'])
                ->latest()
                ->pluck('current_balance')
                ->first() ?? 0;
    
            // Calculate new balance
            $data['current_balance'] = $currentAccountBalance + $data['credit_amount'] - $data['debit_amount'];
            // dd($data);
            // Insert new ledger entry
            AccountLedger::create($data);
    
            // Update Account balance
            $account = Account::find($data['account_id']);
            if (!$account) {
                throw new \Exception("Account not found.");
            }
    
            $account->updateOrFail(['balance' => $data['current_balance']]);
    
            DB::commit(); // Commit Transaction (Apply Changes)
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback Transaction (Undo Changes)
            throw $e; // Re-throw the error for handling in the calling function
        }
    }
    
    public static function partyLedgerTransction($data)
    {
        DB::beginTransaction();
        try {
            $currentBalance = PartyLedger::where('party_id', $data['party_id'])->orderBy('id', 'desc')->first()->current_balance ?? 0;
            $data['party_id'] = $data['party_id'];
            $data['loan_id'] = $data['loan_id'] ?? null;
            $data['payment_id'] = $data['payment_id'] ?? null;
            $data['account_id'] = $data['account_id'] ?? null;
            $data['particular'] = $data['particular'] ?? null;
            $data['date'] = $data['date'] ?? null;
            $data['debit_amount'] = $data['debit_amount'] ?? null;
            $data['credit_amount'] = $data['credit_amount'] ?? null;
            $data['reference_number'] = $data['reference_number'] ?? null;
            $data['note'] = $data['note'] ?? null;
            $data['created_by_id'] = $data['created_by_id'] ?? null;
            $data['updated_by_id'] = $data['updated_by_id'] ?? null;
            $data['current_balance'] = $currentBalance - $data['debit_amount'] + $data['credit_amount'];
            PartyLedger::create($data);
            Party::find($data['party_id'])->update(['current_balance'=> $data['current_balance']]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public static function branchLedger(array $data): void
    {
        DB::transaction(function () use ($data) {

            // Default values
            $defaults = [
                'branch_id'            => null,
                'parcel_settlement_id' => null,
                'payment_id'           => null,
                'account_id'           => null,
                'particular'           => null,
                'date'                 => now(),
                'debit_amount'         => 0,
                'credit_amount'        => 0,
                'reference_number'     => null,
                'note'                 => null,
                'created_by_id'        => auth()->id(),
                'updated_by_id'        => null,
            ];

            $data = array_merge($defaults, $data);

            if (!$data['branch_id']) {
                throw new \Exception('Branch ID is required for ledger entry.');
            }

            // Lock last ledger row to prevent race conditions
            $lastLedger = BranchLedger::where('branch_id', $data['branch_id'])
                            ->lockForUpdate()
                            ->latest('id')
                            ->first();

            $previousBalance = $lastLedger->current_balance ?? 0;

            $debit  = (float) $data['debit_amount'];
            $credit = (float) $data['credit_amount'];

            // Calculate new balance
            $data['current_balance'] = $previousBalance + $debit - $credit;

            // Create ledger entry
            BranchLedger::create($data);

            // Update branch balance
            Branch::where('id', $data['branch_id'])
                ->update(['current_balance' => $data['current_balance']]);

        }, 3);
    }

    public static function supplierLedgerTransction($data)
    {
        DB::beginTransaction();
        try {
            $currentBalance = SupplierLedger::where('supplier_id', $data['supplier_id'])
                                ->orderBy('id', 'desc')
                                ->first()->current_balance ?? 0;
            $data['supplier_id'] = $data['supplier_id'];
            $data['purchase_id'] = $data['purchase_id'] ?? null;
            $data['payment_id'] = $data['payment_id'] ?? null;
            $data['account_id'] = $data['account_id'] ?? null;
            $data['particular'] = $data['particular'] ?? null;
            $data['date'] = $data['date'] ?? null;
            $data['debit_amount'] = $data['debit_amount'] ?? null;
            $data['credit_amount'] = $data['credit_amount'] ?? null;
            $data['reference_number'] = $data['reference_number'] ?? null;
            $data['note'] = $data['note'] ?? null;
            $data['created_by_id'] = $data['created_by_id'] ?? null;
            $data['updated_by_id'] = $data['updated_by_id'] ?? null;
            $data['current_balance'] = $currentBalance + $data['debit_amount'] - $data['credit_amount'];
            SupplierLedger::create($data);
            Supplier::find($data['supplier_id'])->update(['current_balance'=> $data['current_balance']]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


}
