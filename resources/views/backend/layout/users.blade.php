@extends('backend.app', ['title' => 'index'])

@push('style')
@endpush


@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <span class="breadcrumb-item active">Users</span>
    </nav>

    <div class="sl-pagebody">
        <!-- <div class="sl-page-title">
            <h5>Data Table</h5>
            <p>DataTables is a plug-in for the jQuery Javascript library.</p>
        </div> -->

        <div class="card pd-20 pd-sm-40">
            <h4 class="mg-b-10">App User Logs ({{ $usersCount }})</h4>
            <p class="mg-b-20 mg-sm-b-30">This is a list of App users. You can add, edit or delete users from here.</p>
            <div class="table-wrapper">
                <table id="data-table" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p">#</th>
                            <th class="wd-15p">Name</th>
                            <th class="wd-15p">Created</th>
                            <th class="wd-15p">Email</th>
                            <th class="wd-15p">Email Verified</th>
                            <th class="wd-15p">Phone</th>
                            <th class="wd-15p">Circles</th>
                            <th class="wd-15p">Posts</th>
                            <th class="wd-15p">SOS</th>
                            <th class="wd-15p">Warran</th>
                            <th class="wd-15p">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr class="{{ $loop->index % 2 == 0 ? 'bg-gray-100' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y h:i A') }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->email_verified_at != null ? 'Yes' : 'No' }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->circles->count() }}</td>
                            <td>{{ $user->posts->count() }}</td>
                            <td>{{ $user->sos->count() }}</td>
                            <td>
                                <button class="badge badge-danger" onclick="openModel({{ $user }})">{{ $user->warraning }}</button>
                            </td>
                            <td class="text-center">
                                <button class="badge badge-{{ $user->status == 'active' ? 'success' : 'danger' }}" onclick="window.location.href='{{ route('user.status', $user->id) }}'" style="cursor: pointer">{{ $user->status == 'active' ? 'Active' : 'Inactive' }}</button>
                            </td>
                        </tr>
                        @endforeach
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
        $('#data-table').DataTable({
            "pageLength": 100
        });
    });

    function openModel(data) {
        $('#postModal').modal('show');
        $('#postModal .modal-title').text("Add Warraning");
        $('#postModal .modal-body').html(`
        <div>
            <form action="users/warraning/${data.id}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title: *</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description: *</label>
                    <textarea class="form-control" rows="5" cols="50" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        `);
    }
</script>
@endpush