@extends('backend.app', ['title' => 'index'])

@push('style')
@endpush


@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <a class="breadcrumb-item" href="{{ route('post-category.index') }}">Post Category</a>
        <span class="breadcrumb-item @if (Route::is('post-category.index')) active @endif">index</span>
    </nav>
    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">
            <div class="sl-page-title d-flex justify-content-between">
                <div>
                    <h4 class="card-header-title">Social Link</h4>
                    <p class="mg-b-20 mg-sm-b-30 tx-gray-600">This is a list of all social links. You can add, edit, delete, or update the status of social links from here. You can also search, sort, and filter the list of social links as needed.</p>
                </div>
                <div>
                    <a class="btn" href="{{ route('social-link.create') }}"><i class="bi bi-plus-circle tx-24"></i></a>
                </div>
            </div>

            <div class="table-wrapper">
                <table id="data-table" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p">#</th>
                            <th class="wd-15p">Name</th>
                            <th class="wd-15p">Url</th>
                            <!-- <th class="wd-15p">Image</th> -->
                            <th class="wd-20p">Status</th>
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
                    url: "{{ route('social-link.index') }}",
                    type: "get",
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'url',
                        name: 'url',
                        orderable: true,
                        searchable: true
                    },
                    // {
                    //     data: 'icon',
                    //     name: 'icon',
                    //     orderable: true,
                    //     searchable: true
                    // },
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

            new DataTable('#example', {
                responsive: true
            });
        }
    });

    // Status Change Confirm Alert
    function showStatusChangeAlert(id) {
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
                statusChange(id);
                NProgress.done();
            }
        });
    };

    // Status Change
    function statusChange(id) {
        var url = "{{ route('social-link.status',':id') }}";
        $.ajax({
            type: "GET",
            url: url.replace(':id', id),
            success: function(resp) {
                // Reloade DataTable
                $('#data-table').DataTable().ajax.reload();
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

    // delete Confirm
    function showDeleteConfirm(id) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure you want to delete this record?',
            text: "If you delete this, it will be gone forever.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                NProgress.start();
                deleteItem(id);
                NProgress.done();
            }
        });
    };

    // Delete Button
    function deleteItem(id) {
        var url = "{{ route('social-link.destroy',':id') }}";
        $.ajax({
            type: "DELETE",
            url: url.replace(':id', id),
            success: function(resp) {
                // Reloade DataTable
                $('#data-table').DataTable().ajax.reload();
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
</script>
@endpush