<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class SupplierPayment extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'supplier_id',
        'account_id',
        'purchase_id',
        'date',
        'amount',
        'reference_number',
        'note',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function created_by()
    {
        return $this->belongsTo(Admin::class, 'created_by_id');
    }
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
