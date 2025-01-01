@extends('backend.app', ['title' => 'index'])

@push('style')
@endpush


@section('content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('dashboard') }}">Jibon360</a>
        <span class="breadcrumb-item active">Moderator</span>
    </nav>

    <div class="sl-pagebody">

        <div class="card pd-20 pd-sm-40">
            <div class="sl-page-title d-flex justify-content-between">
                <div>
                    <h4 class="card-header-title">Add Moderator</h4>
                    <p class="mg-b-20 mg-sm-b-30 tx-gray-600">This is a list of all moderators. You can add, edit, delete, or update the status of moderators from here. You can also search, sort, and filter the list of moderators as needed.</p>
                </div>
                <div>
                    <a class="btn" href="{{ route('moderator.create') }}"><i class="bi bi-plus-circle tx-24"></i></a>
                </div>
            </div>

            <div class="table-wrapper">
                <table id="data-table" class="table display responsive nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th class="wd-15p">#</th>
                            <th class="wd-15p">Name</th>
                            <th class="wd-15p">Role</th>
                            <th class="wd-15p">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr class="{{ $loop->index % 2 == 0 ? 'bg-gray-100' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <button class="badge badge-success" onclick="window.location.href='{{ route('moderator.edit', $user->id) }}'">Edit</button>
                                <button class="badge badge-danger" onclick="window.location.href='{{ route('moderator.delete', $user->id) }}'">Delete</button>
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
</script>
@endpush