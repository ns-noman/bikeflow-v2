@extends('layouts.admin.master')

@section('content')
<div class="content-wrapper">
    @include('layouts.admin.content-header')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="invoice p-3 mb-3" id="my-invoice">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <img style="height: 50px;" src="{{ asset('public/uploads/basic-info/' . $data['basicInfo']['logo']) }}" alt="Logo" />
                                    {{ $data['basicInfo']['title'] }}
                                    <small class="float-right">Print Date: {{ date('dS M Y', strtotime(Date('Y-m-d'))) }}</small>
                                </h4>
                            </div>
                        </div>

                        <div class="row invoice-info" style="margin-top: 100px;">
                            <div class="col-sm-4 invoice-col">
                                <strong>Report Name:</strong> Sales Report<br>
                                <strong>Period:</strong>
                                {{ \Carbon\Carbon::parse($data['fromDate'])->format('d F Y') }} to
                                {{ \Carbon\Carbon::parse($data['toDate'])->format('d F Y') }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Invoice No</th>
                                            <th>Customer | Mobile</th>
                                            <th>Date</th>
                                            <th>Total Price</th>
                                            <th>Vat/Tax</th>
                                            <th>Discount</th>
                                            <th>Payable</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Payment Status</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_price = 0;
                                            $total_vat = 0;
                                            $total_discount = 0;
                                            $total_payable = 0;
                                            $total_paid = 0;
                                            $total_due = 0;
                                        @endphp

                                        @foreach($data['lists'] as $index => $sale)
                                            @php
                                                $due = $sale['total_payable'] - $sale['paid_amount'];
                                                $total_price += $sale['total_price'];
                                                $total_vat += $sale['vat_tax'];
                                                $total_discount += $sale['discount'];
                                                $total_payable += $sale['total_payable'];
                                                $total_paid += $sale['paid_amount'];
                                                $total_due += $due;
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <a href="{{ route('sales.invoice', $sale['id']) }}">
                                                        <b>{{ $sale['invoice_no'] }}</b>
                                                    </a>
                                                </td>
                                                <td>{{ $sale['customer_name'] }}<br>{{ $sale['customer_contact'] }}</td>
                                                <td>{{ $sale['date'] }}</td>
                                                <td class="text-end">{{ number_format($sale['total_price'], 2) }}</td>
                                                <td class="text-end">{{ number_format($sale['vat_tax'], 2) }}</td>
                                                <td class="text-end">{{ number_format($sale['discount'], 2) }}</td>
                                                <td class="text-end">{{ number_format($sale['total_payable'], 2) }}</td>
                                                <td class="text-center text-success fw-bold">{{ number_format($sale['paid_amount'], 2) }}</td>
                                                <td class="text-center text-danger fw-bold">{{ number_format($due, 2) }}</td>
                                                <td>
                                                    @if($sale['payment_status'] == 0)
                                                        Unpaid
                                                    @elseif($sale['payment_status'] == 1)
                                                        Paid
                                                    @else
                                                        Partial
                                                    @endif
                                                </td>
                                                <td>{{ $sale['note'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"><b>Total:</b></td>
                                            <td class="text-end"><b>{{ number_format($total_price, 2) }}</b></td>
                                            <td class="text-end"><b>{{ number_format($total_vat, 2) }}</b></td>
                                            <td class="text-end"><b>{{ number_format($total_discount, 2) }}</b></td>
                                            <td class="text-end"><b>{{ number_format($total_payable, 2) }}</b></td>
                                            <td class="text-end"><b>{{ number_format($total_paid, 2) }}</b></td>
                                            <td class="text-end"><b>{{ number_format($total_due, 2) }}</b></td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row no-print mt-3">
                            <div class="col-12">
                                <a href="javascript:void(0)" onclick="customPrint()" rel="noopener" class="btn btn-default">
                                    <i class="fas fa-print"></i> Print
                                </a>
                            </div>
                        </div>

                    </div> <!-- /.invoice -->
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
    </section>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        if (true) {
            customPrint();
        }
    });

    function customPrint() {
        var printContents = document.getElementById('my-invoice').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
@endsection
