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
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-sm table-striped table-bordered table-centre">
                                            <thead>
                                                <tr>
                                                   <th>SN</th>
                                                   <th>Date</th>
                                                   <th>Particular</th>
                                                   <th>Reference No</th>
                                                   <th>Debit</th>
                                                   <th>Credit</th>
                                                   <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4"><b>Total:</b></td>
                                                    <td @style('text-align: right;')><b id="debit_amount"></b></td>
                                                    <td @style('text-align: right;')><b id="credit_amount"></b></td>
                                                    <td @style('text-align: right;')><b id="current_balance"></b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
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
        loadAssetData();
        $(document).on('change', '#supplier_id', function () {
        if (!$.fn.DataTable.isDataTable('#dataTable')) {
            loadAssetData();
        } else {
            $('#dataTable').DataTable().draw();
        }
    });
    });
    function loadAssetData() {
        var table = $('#dataTable').DataTable({initComplete: function () {
            const filterContainer = $('.dataTables_filter').parent();
            const colmd = 3;
            $('#dataTable_length').parent().removeClass('col-md-6').addClass(`col-md-${colmd}`);
            $('#dataTable_filter').parent().removeClass('col-md-6').addClass(`col-md-${colmd}`);
            filterContainer.before(`
                <div class="col-sm-12 col-md-${colmd}">
                    <div class="dataTables_filter" style="display: flex; align-items: center; justify-content: center;">
                        <label style="font-weight: normal; white-space: nowrap; display: flex; align-items: center;margin-bottom: .5rem;">
                            <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                                <option value="" selected disabled>Select Supplier</option>
                                @foreach ($data['suppliers'] as $key => $supplier)
                                    <option
                                         
                                        value="{{ $supplier['id'] }}">
                                        {{ $supplier['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
            `);
            filterContainer.before(`
                <div class="col-sm-12 col-md-${colmd}">
                    <div id="dataTable_filter" class="dataTables_filter" style="text-align: center;">
                        <label>
                            Date: <input id="date" value="{{ date('Y-m') }}" type="month" class="form-control form-control-sm filter">
                        </label>
                    </div>
                </div>
            `);
        },
        processing: false,
        serverSide: true,
        ajax: {
            url: '{{ route("reports.supplier-ledger") }}',
            type: 'post',
            data: function(d) {
                const supplier_id = $('#supplier_id').val();
                const date = $('#date').val();
                d.date = date || "{{ date('Y-m') }}";
                d.supplier_id = supplier_id || "{{ isset($data['suppliers'][0]) ? $data['suppliers'][0]['id'] : '' }}";
                d._token = $('meta[name="csrf-token"]').attr('content');
            },
            dataSrc: function(json) {
                if (json.data.length) {
                    let current_balance = parseFloat(json.data[0].current_balance || 0);
                    let debit_amount = parseFloat(json.data[0].debit_amount || 0);
                    let credit_amount = parseFloat(json.data[0].credit_amount || 0);
                    let brought_forword = current_balance + credit_amount - debit_amount;
                    const bfRow = {
                        date: '',
                        particular: 'B/F',
                        reference_number: '',
                        credit_amount: '',
                        debit_amount: '',
                        current_balance: brought_forword,
                    };
                    json.data.unshift(bfRow);
                }
                let debit_amount = parseFloat(json.supplierLedgerSummery.debit_amount || 0);
                let credit_amount = parseFloat(json.supplierLedgerSummery.credit_amount || 0);

                $('#debit_amount').html(formatNumber(debit_amount));
                $('#credit_amount').html(formatNumber(credit_amount));
                $('#current_balance').html(formatNumber(debit_amount - credit_amount));
                return json.data;
            }
        },
        columns: [
                    { data: null, orderable: false, searchable: false },
                    { data: 'date', name: 'supplier_ledgers.date', orderable: false},
                    { data: 'particular', name: 'supplier_ledgers.particular', orderable: false},
                    { data: 'reference_number', name: 'supplier_ledgers.reference_number', orderable: false},
                    {
                        data: null, 
                        name: 'supplier_ledgers.debit_amount', 
                        orderable: false, 
                        searchable: false, 
                        render: function(data, type, row, meta) {
                            return row.debit_amount > 0 ? formatNumber(row.debit_amount) : '';
                        }
                    },
                    {
                        data: null, 
                        name: 'supplier_ledgers.credit_amount', 
                        orderable: false, 
                        searchable: false, 
                        render: function(data, type, row, meta) {
                            return row.credit_amount > 0 ? formatNumber(row.credit_amount) : '';
                        }
                    },
                    {
                        data: null, 
                        name: 'supplier_ledgers.current_balance', 
                        orderable: false, 
                        searchable: false, 
                        render: function(data, type, row, meta) {
                            return formatNumber(row.current_balance);
                        }
                    },
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
        let date = $('#date').val() || '';
        let supplier_id = $('#supplier_id option:selected').val() || '';
        window.open(`?&print=true&date=${date}&supplier_id=${supplier_id}`, '_blank');
    }
</script>
@endsection