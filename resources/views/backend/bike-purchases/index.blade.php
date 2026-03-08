@extends('layouts.admin.master')
@section('content')
<div class="content-wrapper">
    @include('layouts.admin.content-header')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-primary p-1">
                            <h3 class="card-title">
                                <a href="{{ route('bike-purchases.create') }}"class="btn btn-light shadow rounded m-0"><i
                                        class="fas fa-plus"></i>
                                    <span>Add New</span></i></a>
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
                                                <th>Bike Info</th>
                                                <th>Condition</th>
                                                <th>Seller</th>
                                                <th>Investor</th>
                                                <th>Price</th>
                                                <th>Servicing Cost</th>
                                                <th>Total Cost</th>
                                                <th>Payment Method</th>
                                                <th>Reference No</th>
                                                <th>Creator</th>
                                                <th>NID</th>
                                                <th>Reg Card</th>
                                                <th>Photo</th>
                                                <th>Deed</th>
                                                <th>Tax Token</th>
                                                <th>Note</th>
                                                <th>Selling Status</th>
                                                <th>Purchase Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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
            var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("bike-purchases.list") }}',
                type: 'GET',
            },
            columns: [
                        { data: null, orderable: false, searchable: false },
                        { data: 'purchase_date', name: 'bike_purchases.purchase_date'},
                        {
                            data: null, 
                            name: 'bike_models.name', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                return `${row.model_name} <span class="badge" style="background-color: ${row.hex_code};color: black; text-shadow: 2px 0px 8px white;">${row.color_name}</span>
                                <br>Ch#${row.chassis_no}
                                <br>Reg#${row.registration_no}`;
                            }
                        },
                        {
                            data: 'bikes.bike_type',
                            name: 'bikes.bike_type', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                return `<span class="badge badge-${row.bike_type == '0' ? 'danger' : 'success'}">${row.bike_type == '0' ? 'Used' : 'New'}</span>`;
                            }
                        },
                        { data: 'seller_name', name: 'sellers.name'},
                        { data: 'investor_name', name: 'investors.name'},
                        { data: 'purchase_price', name: 'bike_purchases.purchase_price'},
                        { data: 'servicing_cost', name: 'bike_purchases.servicing_cost'},
                        { data: 'total_cost', name: 'bike_purchases.total_cost'},
                        { data: 'payment_method', name: 'payment_methods.name'},
                        { data: 'reference_number', name: 'bike_purchases.reference_number'},
                  
                     
                        { data: 'creator_name', name: 'admins.name'},

                        {
                            data: null,
                            name: 'bike_purchases.doc_nid',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return generateTag(row.doc_nid);
                            }
                        },

                        {
                            data: null, 
                            name: 'bike_purchases.doc_reg_card', 
                            orderable: false, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                return generateTag(row.doc_reg_card);
                            }
                        },
                        {
                            data: null, 
                            name: 'bike_purchases.doc_image', 
                            orderable: false, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                return generateTag(row.doc_image);
                            }
                        },
                        {
                            data: null, 
                            name: 'bike_purchases.doc_deed', 
                            orderable: false, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                return generateTag(row.doc_deed);
                            }
                        },
                        {
                            data: null, 
                            name: 'bike_purchases.doc_tax_token', 
                            orderable: false, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                return generateTag(row.doc_tax_token);
                            }
                        },

                        { data: 'note', name: 'bike_purchases.note'},
                        {
                            data: null, 
                            name: 'bike_purchases.selling_status', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                let color;
                                let text;
                                if(row.selling_status == '0'){
                                    color = 'warning';
                                    text = 'Unsold';
                                }else if(row.selling_status == '1'){
                                    color = 'info';
                                    text = 'Sold';
                                }
                                return `<span class="badge badge-${color}">${text}</span>`;
                            }
                        },
                        {
                            data: null, 
                            name: 'bike_purchases.purchase_status', 
                            orderable: true, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                let color;
                                let text;
                                let eventClass = '';
                                if(row.purchase_status == '0'){
                                    color = 'danger';
                                    text = 'Pending';
                                    eventClass = 'event';
                                }else if(row.purchase_status == '1'){
                                    color = 'success';
                                    text = 'Approved';
                                }
                                return `<button transaction_id=${row.id} type="button" class="btn btn-sm btn-${color} ${eventClass}">${text}</button>`;
                            }
                        },
                        { 
                            data: null,
                            orderable: false, 
                            searchable: false, 
                            render: function(data, type, row, meta) {
                                let view = `{{ route('bike-purchases.invoice', ":id") }}`.replace(':id', row.id);
                                let print = `{{ route('bike-purchases.invoice.print', [":id","print"]) }}`.replace(':id', row.id);
                                let edit = `{{ route('bike-purchases.edit', ":id") }}`.replace(':id', row.id);
                                let destroy = `{{ route('bike-purchases.destroy', ":id") }}`.replace(':id', row.id);
                                return (` <div class="d-flex justify-content-center">
                                                 <a href="${print}" class="btn btn-sm btn-dark">
                                                    <i class="fa-solid fa-print"></i>
                                                </a>
                                                <a href="${view}" class="btn btn-sm btn-warning">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="${edit}" class="btn btn-sm btn-info ${row.purchase_status == '1' ? 'disabled' : null}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form class="delete" action="${destroy}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" ${row.purchase_status == '1' ? "disabled" : null}>
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        `);
                            }
                        }
                    ],
                rowCallback: function(row, data, index) {
                    var pageInfo = table.page.info();
                    var serialNumber = pageInfo.start + index + 1;
                    $('td:eq(0)', row).html(serialNumber);
                },
                order: [],
                search: {return: false}
            });

            $(document).on('click', '.delete button', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                let tr = $(this).closest('tr');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(async (result) => {
                    if (result.isConfirmed){
                        nsAjaxPost(form.attr('action'), form.serialize())
                        .then(res => {
                            table.draw();
                            message(res);
                        })
                        .catch(err => {
                            message(err);
                        });
                    }
                });
            });

        

            $(document).on('click', '.event', function(e) {
                e.preventDefault();
                let transaction_id = $(this).attr('transaction_id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#198754",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Approve",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        const url = `{{ route('bike-purchases.approve', ":id") }}`.replace(':id', transaction_id);
                        $.ajax({
                            url: url,
                            method: 'GET',
                            dataType: 'JSON',
                            success: function(res) {
                                message(res);
                                table.draw();
                            },
                            error: function(xhr, status, error) {
                                message(xhr.responseJSON);
                            }
                        });
                    }
                });

            });
        });
        function downloadImage(url){
            const link = document.createElement('a');
            link.href = url;
            link.download = url.split('/').pop();
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        function generateTag(fileName = null) {
           const classList = 'd-flex justify-content-center align-items-center';
           const styleList = `height: 75px!important;width: 75px!important;border-radius:6px;border:1px solid #ccc;font-size:12px;text-align:center;font-weight: bold;cursor: pointer;`;
           let fileTag = `<div class="${classList}" style="height: 75px!important;width: 75px!important;border-radius:6px;border:1px solid #ccc;font-size:12px;text-align:center;cursor: not-allowed;background-color: #e0e0e0;">Empty</div>`;
            if (fileName){
                const orginalExt = fileName.split('.').pop().toLowerCase();
                const src = `{{ asset('public/uploads/bike-purchases/:file') }}`.replace(':file', fileName);
                const extList = {
                    image: { tag: 'img', attrs: {}, extn: ['jpg','jpeg','png','gif','bmp','webp','svg'], useFReader: true },
                    pdf: { tag: 'embed', attrs: { type:'application/pdf' }, extn:['pdf'], useFReader: true },
                    document: { tag:'div', attrs:{}, extn:['doc','docx','odt','rtf','txt'], useFReader:false },
                    excel: { tag:'div', attrs:{}, extn:['xls','xlsx','csv','ods'], useFReader:false },
                    powerpoint: { tag:'div', attrs:{}, extn:['ppt','pptx','odp'], useFReader:false },
                    archive: { tag:'div', attrs:{}, extn:['zip','rar','7z','tar','gz'], useFReader:false },
                    video: { tag:'video', attrs:{ controls:true }, extn:['mp4','avi','mkv','mov','webm'], useFReader:true },
                    audio: { tag:'audio', attrs:{ controls:true }, extn:['mp3','wav','ogg','aac'], useFReader:true }
                };
                for (const [cat, con] of Object.entries(extList)) {
                    if (!con.extn.includes(orginalExt)) continue;
                    const attrs = { src: src, onclick: `downloadImage('${src}')`, class: classList, style: styleList };
                    if (!con.useFReader) {
                        fileTag = $(`<${con.tag}>`, attrs).html(orginalExt.toUpperCase()).prop('outerHTML');
                    } else {
                        fileTag = $(`<${con.tag}>`, attrs).prop('outerHTML');
                    }
                    break;
                }
            }
            return fileTag;
        }
    </script>
@endsection