@extends('layouts.admin.master')
@section('content')
    <style>
        td:nth-child(5),
        td:nth-child(6),
        td:nth-child(7) {
            text-align: right !important;
        }
    </style>
    <div class="content-wrapper">
        @include('layouts.admin.content-header')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info p-1 d-flex justify-content-end justify-align-center">
                                <h3 class="card-title">
                                    <a href="javascript:void(0)"class="btn btn-dark shadow rounded" onclick="print()"><i
                                            class="fas fa-print"></i>
                                        <span>Print</span></i></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-6">
                                                <div class="form-group d-flex align-items-center">
                                                    <label for="date-range" class="mr-2 mb-0"
                                                        style="white-space: nowrap;">Filter:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="far fa-calendar-alt"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control float-right" id="date-range">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="bootstrap-data-table-panel">
                                            <div class="table-responsive">
                                                <table id="dataTable" class="table table-sm table-striped table-bordered table-centre">
                                                    <thead>
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>InvoiceNo</th>
                                                            <th>Customer|Mobile</th>
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
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                    <td colspan="4"><b>Total:</b></td>
                                                    <td @style('text-align: right;')><b id="total_price"></b></td>
                                                    <td @style('text-align: right;')><b id="total_vat"></b></td>
                                                    <td @style('text-align: right;')><b id="total_discount"></b></td>
                                                    <td @style('text-align: right;')><b id="total_payable"></b></td>
                                                    <td @style('text-align: right;')><b id="totatl_paid"></b></td>
                                                    <td @style('text-align: right;')><b id="total_due"></b></td>
                                                    <td colspan="2"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#date-range').daterangepicker();
        loadAssetData();
        $(document).on('change', '#date-range', function () {
        if (!$.fn.DataTable.isDataTable('#dataTable')) {
            loadAssetData();
        } else {
            $('#dataTable').DataTable().draw();
        }
    });
    });
    function loadAssetData() {

        
        var table = $('#dataTable').DataTable({
        processing: false,
        serverSide: true,
        ajax: {
            url: '{{ route("reports.sales-report") }}',
            type: 'post',
            data: function(d) {
                d.daterange = $('#date-range').val().replace(/\//g, '_').replace(/ /g, '');
                d._token = $('meta[name="csrf-token"]').attr('content');
            },
            dataSrc: function(json) {
                let total_price = parseFloat(json.purchaseSummery.total_price || 0);
                let total_vat = parseFloat(json.purchaseSummery.total_vat || 0);
                let total_discount = parseFloat(json.purchaseSummery.total_discount || 0);
                let total_payable = parseFloat(json.purchaseSummery.total_payable || 0);
                let totatl_paid = parseFloat(json.purchaseSummery.totatl_paid || 0);
                let total_due = parseFloat(json.purchaseSummery.total_due || 0);

                $('#total_price').html(formatNumber(total_price));
                $('#total_vat').html(formatNumber(total_vat));
                $('#total_discount').html(formatNumber(total_discount));
                $('#total_payable').html(formatNumber(total_payable));
                $('#totatl_paid').html(formatNumber(totatl_paid));
                $('#total_due').html(formatNumber(total_due));
                return json.data;
            }
        },
        columns: [

                    { data: null, orderable: false, searchable: false },
                    {
                        data: null, 
                        name: 'sales.invoice_no', 
                        orderable: true, 
                        searchable: true, 
                        render: function(data, type, row, meta) {
                            let view = `{{ route('sales.invoice', ":id") }}`.replace(':id', row.id);
                            return `<a href="${view}" class=""><b>${row.invoice_no}</b></a>`;
                        }
                    },
                    {
                        data: null, 
                        name: 'customers.name', 
                        orderable: true, 
                        searchable: false, 
                        render: function(data, type, row, meta) {
                            return `${row.customer_name}<br>${row.customer_contact ?? ''}`;
                        }
                    },
                    { data: 'date', name: 'sales.date'},
                    { data: 'total_price', name: 'sales.total_price'},
                    { data: 'vat_tax', name: 'sales.vat_tax'},
                    { data: 'discount', name: 'sales.discount'},
                    { data: 'total_payable', name: 'sales.total_payable'},
                    {
                        data: null, 
                        name: 'sales.paid_amount', 
                        orderable: false, 
                        searchable: false, 
                        render: function(data, type, row, meta) {
                            return `<div class="text-center"><span class="text-success fw-bold"><b>${row.paid_amount}</b></span></div>`;
                        }
                    },
                    {
                        data: null, 
                        name: 'sales.paid_amount', 
                        orderable: false, 
                        searchable: false, 
                        render: function(data, type, row, meta) {
                            return `<div class="text-center"><span class="text-danger fw-bold"><b>${row.total_payable - row.paid_amount}</b></span></div>`;
                        }
                    },
                    {
                        data: null, 
                        name: 'sales.payment_status', 
                        orderable: true, 
                        searchable: false, 
                        render: function(data, type, row, meta) {
                            let color;
                            let text;
                            if(row.payment_status == '0'){
                                color = 'warning';
                                text = 'Unpaid';
                            }else if(row.payment_status == '1'){
                                color = 'info';
                                text = 'Paid';
                            }
                            return `<span class="badge badge-${color}">${text}</span>`;
                        }
                    },
                    { data: 'note', name: 'sales.note'},
                ],
            rowCallback: function(row, data, index) {
                var pageInfo = table.page.info();
                var serialNumber = pageInfo.start + index + 1;
                $('td:eq(0)', row).html(serialNumber);
            },
            order: [],
            search: {return: false}
        });
        $(document).on('change','.filter',function() {
            table.draw();
        });
    }
    function print() {
        let daterange = $('#date-range').val().replace(/\//g, '_').replace(/ /g, '');
        window.open(`?&print=true&daterange=${daterange}`, '_blank');
    }
</script>
@endsection