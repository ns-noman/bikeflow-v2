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
                                    <img style="height: 50px;width: px;" src="{{ asset('public/uploads/basic-info/' . $data['basicInfo']['logo']) }}" alt="Logo" />
                                      {{ $data['basicInfo']['title'] }}
                                      <small class="float-right">Print Date: {{ date('dS M Y', strtotime(Date('Y-m-d'))) }}</small>
                                  </h4>
                              </div>
                          </div>
                          <div class="row invoice-info" style="margin-top: 100px;">
                              <div class="col-sm-4 invoice-col">
                                  <strong>Report Name: </strong>Purchse Report<br>
                                  <strong>Period: </strong>{{ \Carbon\Carbon::parse($data['fromDate'])->format('d F Y') }} to {{ \Carbon\Carbon::parse($data['toDate'])->format('d F Y') }}
                              </div>
                              <div class="col-sm-4 invoice-col">
                              </div>
                              <div class="col-sm-4 invoice-col">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-12 table-responsive">
                                  <table class="table table-striped">
                                      <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>VoucharNo</th>
                                                <th>Supplier|Mobile</th>
                                                <th>Date</th>
                                                <th @style('width: 40px')>TotalPrice</th>
                                                <th @style('width: 40px')>Vat/Tax</th>
                                                <th @style('width: 40px')>Discount</th>
                                                <th @style('width: 70px')>Payable</th>
                                                <th @style('width: 100px')>Paid</th>
                                                <th @style('width: 40px')>Due</th>
                                                <th>PaymentStatus</th>
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

                                        @foreach($data['lists'] as $index => $purchase)
                                            @php
                                                $due = $purchase['total_payable'] - $purchase['paid_amount'];
                                                $total_price += $purchase['total_price'];
                                                $total_vat += $purchase['vat_tax'];
                                                $total_discount += $purchase['discount'];
                                                $total_payable += $purchase['total_payable'];
                                                $total_paid += $purchase['paid_amount'];
                                                $total_due += $due;
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><a href="{{ route('purchases.vouchar', $purchase['id']) }}"><b>{{ $purchase['vouchar_no'] }}</b></a></td>
                                                <td>{{ $purchase['supplier_name'] }}<br>{{ $purchase['supplier_contact'] }}</td>
                                                <td>{{ $purchase['date'] }}</td>
                                                <td class="text-end">{{ number_format($purchase['total_price'], 2) }}</td>
                                                <td class="text-end">{{ number_format($purchase['vat_tax'], 2) }}</td>
                                                <td class="text-end">{{ number_format($purchase['discount'], 2) }}</td>
                                                <td class="text-end">{{ number_format($purchase['total_payable'], 2) }}</td>
                                                <td class="text-center text-success fw-bold">{{ number_format($purchase['paid_amount'], 2) }}</td>
                                                <td class="text-center text-danger fw-bold">{{ number_format($due, 2) }}</td>
                                                <td>
                                                    @if($purchase['payment_status'] == 0)
                                                        Unpaid
                                                    @elseif($purchase['payment_status'] == 1)
                                                        Paid
                                                    @else
                                                        Partial
                                                    @endif
                                                </td>
                                                <td>{{ $purchase['note'] }}</td>
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
                          <div class="row">
                              <div class="col-6">
                              </div>
                              <div class="col-6">
                              </div>
                          </div>
                          <div class="row no-print">
                              <div class="col-12">
                                  <a href="javascript:void(0)" onclick="customPrint()" rel="noopener" class="btn btn-default">
                                    <i class="fas fa-print"></i> Print</a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            if (true) {
              customPrint();
            }
        });
        function customPrint(){
          var printContents = document.getElementById('my-invoice').innerHTML;
          var originalContents = document.body.innerHTML;
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
        }
    </script>
@endsection
