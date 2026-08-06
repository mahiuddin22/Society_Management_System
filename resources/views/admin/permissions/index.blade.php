@extends('admin.layouts.app')

@section('content')
<form action="{{ route('admin.permissions.index') }}" method="GET" class="row g-2 mb-3 mt-2">
    <div class="col-md-3">
        <input type="text" name="name" class="form-control form-control-sm" value="{{ $name }}" placeholder="Search by name" />
    </div>
    <div class="col-md-3">
        <select class="form-select form-select-sm" name="permission_id">
            <option value="">Select Menu</option>
            @foreach ($permissionsearch as $permission)
            <option value="{{ $permission->id }}" {{ $permission->id == $permissionId ? 'selected' : '' }}>{{ $permission->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <select class="form-select form-select-sm" name="menu_type">
            <option value="">Select Menu Type</option>
            <option value="main_menu" {{ $menu_type == 'main_menu' ? 'selected' : '' }}>Main Menu</option>
            <option value="sub_menu" {{ $menu_type == 'sub_menu' ? 'selected' : '' }}>Sub Menu</option>
        </select>
    </div>

    <div class="col-md-3 d-grid">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    </div>
</form>

<!-- Create Button under filter form -->
<div class="d-flex justify-content-end mb-3">
    @if(hasPermission('permissions', 'create'))
    <button class="btn btn-success px-4 py-1 d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
        <i class="bi bi-plus-circle me-2"></i> Create
    </button>
    @endif
</div>

<!-- Table Card -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered nowrap" style="width: 100%">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Name (Menu)</th>
                        <th>Menu Type</th>
                        <th>Menu Key</th>
                        <th>Access Items</th>
                        @if(hasPermission('permissions', 'edit') || hasPermission('permissions', 'delete') || hasPermission('permissions', 'move_rows'))
                        <th class="text-center">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="sortable-permissions">
                    @foreach ($permissions as $permission)
                    @php
                    $activityIds = $permission->activity_id
                    ? explode(',', $permission->activity_id)
                    : [];

                    $activityNames = \App\Models\Activity::whereIn('id', $activityIds)->pluck('name');
                    @endphp

                    <tr data-id="{{ $permission->id }}"
                        class="{{ $permission->menu_type == 'main_menu' ? 'table-success' : '' }}">

                        <td class="align-middle">{{ $loop->iteration }}</td>

                        <td class="align-middle fw-bold">
                            {{ $permission->name }}
                        </td>

                        <td class="align-middle">
                            @if($permission->menu_type == 'main_menu')
                            <span class="badge bg-success">Main Menu</span>
                            @else
                            <span class="badge bg-secondary">Sub Menu</span>
                            @endif
                        </td>

                        <td class="align-middle">
                            {{ $permission->menu_key ?: '-' }}
                        </td>

                        <td class="align-middle">
                            @if($permission->menu_type == 'sub_menu')
                            @forelse($activityNames as $activityName)
                            <span class="badge bg-primary me-1 mb-1">
                                {{ $activityName }}
                            </span>
                            @empty
                            <span class="text-muted">-</span>
                            @endforelse
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>

                        @if(hasPermission('permissions', 'edit') || hasPermission('permissions', 'delete') || hasPermission('permissions', 'move'))
                        <td class="text-center align-middle">
                            @if(hasPermission('permissions', 'edit'))
                            <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                class="btn btn-sm btn-outline-primary"
                                title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endif

                            @if(hasPermission('permissions', 'delete'))
                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                method="POST"
                                class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif

                            @if(hasPermission('permissions', 'move'))
                            <span class="text-muted ms-2 cursor-move"
                                title="Reorder Menu"
                                style="cursor:move;">
                                <i class="bi bi-grip-vertical fs-5"></i>
                            </span>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
                {{ $permissions->links() }}
            </table>
        </div>
    </div>
</div>

<!-- Modal (same as before, just add id="createUserForm" on form) -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createModalLabel"><i class="bi bi-person-plus me-2"></i> Add New Permission</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createUserForm" action="{{ route('admin.permissions.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Permission name" required />
                            <div class="invalid-feedback">Please enter permission name.</div>
                        </div>

                        <div class="col-md-4">
                            <label for="menu_type" class="form-label">Menu Type</label>
                            <select name="menu_type" id="menu_type" class="form-select" required>
                                <option value="" disabled selected>Select Menu Type</option>
                                <option value="main_menu">Main Menu</option>
                                <option value="sub_menu">Sub Menu</option>
                            </select>
                            <div class="invalid-feedback">Please select a menu type.</div>
                        </div>

                        <div class="col-md-4" id="menuKeyWrapper">
                            <label for="menu_key" class="form-label">Menu Key</label>
                            <input type="text" id="menu_key" name="menu_key" class="form-control" placeholder="ex: user_dashboard" required>
                            <div class="invalid-feedback">Please enter a menu key.</div>
                        </div>

                        <div class="col-md-12">
                            <label for="activities" class="form-label">Activities</label>

                            <select name="activities[]" id="activities" class="form-select" multiple required>
                                @foreach($activities as $activity)
                                <option value="{{ $activity->id }}">
                                    {{ $activity->name }}
                                </option>
                                @endforeach
                            </select>

                            <div class="form-text">
                                Hold <kbd>Ctrl</kbd> (Windows) or <kbd>⌘</kbd> (Mac) to select multiple.
                            </div>

                            <div class="invalid-feedback">
                                Please select at least one activity.
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Add Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuType = document.getElementById('menu_type');
        const menuKeyWrapper = document.getElementById('menuKeyWrapper');
        const menuKey = document.getElementById('menu_key');

        function toggleMenuKey() {
            if (menuType.value === 'main_menu') {
                menuKey.required = false;
                menuKey.value = '';
                menuKey.readOnly = true;
                menuKey.placeholder = 'Not required for Main Menu';
            } else {
                menuKey.readOnly = false;
                menuKey.required = true;
                menuKey.placeholder = 'ex: user_dashboard';
            }
        }

        // Run on page load
        toggleMenuKey();

        // Run when selection changes
        menuType.addEventListener('change', toggleMenuKey);
    });
</script>

<!-- Activities select2 initialization -->
<script>
    $(document).ready(function() {
        $('#activities').select2({
            placeholder: 'Select Activities',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#createModal') // because it's inside a Bootstrap modal
        });
    });
</script>
@endpush