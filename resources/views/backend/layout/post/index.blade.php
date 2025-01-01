@extends('backend.app', ['title' => 'index'])

@push('style')
@endpush


@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <span class="breadcrumb-item">All Post</span>
        <span class="breadcrumb-item active">index</span>
    </nav>

    <div class="sl-pagebody">
        <!-- <div class="sl-page-title">
            <h5>Data Table</h5>
            <p>DataTables is a plug-in for the jQuery Javascript library.</p>
        </div> -->

        <div class="card pd-20 pd-sm-40">
            <h4 class="card-header-title">Post</h4>
            <p class="tx-13 mg-b-40 mg-sm-b-60">This is a list of all posts. You can see all the posts from here.</p>
            <div class="table-wrapper">
                <table id="data-table" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p">SN:</th>
                            <th class="wd-15p">Name</th>
                            <th class="wd-15p">Category</th>
                            <th class="wd-15p">location</th>
                            <th class="wd-15p">Status</th>
                            <th class="wd-15p">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div><!-- table-wrapper -->
        </div>

    </div><!-- sl-pagebody -->
    @include('backend.partials.footer')
</div>
@endsection

@push('datatable')
<script>
    $(document).ready(function() {
        var searchable = [];
        var selectable = [];
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            }
        });
        if (!$.fn.DataTable.isDataTable('#data-table')) {
            let dTable = $('#data-table').DataTable({
                order: [],
                lengthMenu: [
                    [25, 50, 100, 200, 500, -1],
                    [25, 50, 100, 200, 500, "All"]
                ],
                processing: true,
                responsive: true,
                serverSide: true,

                language: {
                    processing: `<div class="text-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                            </div>`
                },

                scroller: {
                    loadingIndicator: false
                },
                pagingType: "full_numbers",
                dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-3'l><'col-md-2 col-sm-4 px-3'f>>tipr",
                ajax: {
                    url: "{{ $status != null ? route('post.all', $status) : route('post.all') }}",
                    type: "get",
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'user.name',
                        name: 'user_id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'post_categtory.name',
                        name: 'post_category_id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'location',
                        name: 'location',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data.substring(0, 20) + (data.length > 30 ? '...' : '');
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            dTable.buttons().container().appendTo('#file_exports');
        }
    });

    // Status Change Confirm Alert
    function showStatusChangeAlert(id, status) {
        event.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "You want to update the status?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update status'
        }).then((result) => {
            if (result.isConfirmed) {
                NProgress.start();
                statusChange(id, status);
                NProgress.done();
            }
        });
    };

    // Status Change
    function statusChange(id, status) {
        var url = "{{ route('post.status',':id') }}";
        $.ajax({
            type: "GET",
            url: url.replace(':id', id),
            data: {status: status},
            success: function(resp) {
                // Reloade DataTable
                $('#data-table').DataTable().ajax.reload();
                laravelAjax();
                if (resp.success === true) {
                    // show toast message
                    toastr.success(resp.message);
                } else if (resp.errors) {
                    toastr.error(resp.errors[0]);
                } else {
                    toastr.error(resp.message);
                }
            }, // success end
            error: function(error) {
                console.log(error)
            } // Error
        })
    }

    function openModel(data) {
        $('#postModal').modal('show');
        $('#postModal .modal-title').text(data.user.name);
        $('#postModal .modal-body').html(data.description);
        $('#postModal .modal-footer').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>');
    }
</script>
@endpush