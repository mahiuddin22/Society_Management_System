@extends('admin.layouts.app')

@section('content')
<!-- Filter Form -->
<form action="" method="GET" class="d-flex align-items-center gap-2 mb-3">

    <div class="search">

        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6d7469" stroke-width="2">
            <circle cx="11" cy="11" r="7" />
            <path d="m21 21-4.3-4.3" />
        </svg>
        <input class="input" name="search" value="{{ request('search') }}" placeholder="Search by name / email ">

    </div>

    <button type="submit" class="btn btn-primary">Filter</button>
    <a href="{{ route('admin.collectors.index') }}" class="btn btn-secondary">Reset</a>

</form>

<!-- Table Card -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered nowrap" style="width: 100%">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collectors as $user)
                    <tr>
                        <td>{{ $collectors->firstItem() + $loop->index }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">

                            @if(hasPermission('collectors', 'assign'))
                            <a href="{{ route('admin.collectors.assign.road', $user->id) }}" target="_blank" class="btn btn-sm btn-outline-info me-1" title="View | Assign Road">
                                <span class="position-relative">
                                    <i class="bi bi-signpost-2"></i>
                                    <i class="bi bi-check-circle-fill position-absolute" style="font-size: 10px; right: -5px; bottom: -2px;"></i>
                                </span>
                            </a>
                            @endif

                            @if(hasPermission('collectors', 'edit'))
                            <a href="{{ route('admin.collectors.edit', $user->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endif

                            @if(hasPermission('collectors', 'delete'))
                            @if($user->name != 'admin')
                            <form action="{{ route('admin.collectors.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger " title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                            @endif

                        </td>
                    </tr>
                    @endforeach
                    <!-- Additional rows -->
                </tbody>
                {{ $collectors->links() }}
            </table>
        </div>
    </div>
</div>

@endsection