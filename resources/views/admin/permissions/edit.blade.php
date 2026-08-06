@extends('admin.layouts.app')

@section('content')
<!-- Edit Form Card -->
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="name" class="form-label">Permission Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $permission->name) }}" required>
                    <div class="invalid-feedback">Please enter permission name.</div>
                </div>

                <div class="col-md-4">
                    <label for="menu_type" class="form-label">Menu Type</label>
                    <select name="menu_type" id="menu_type" class="form-select" required>
                        <option value="" disabled>Select Menu Type</option>
                        <option value="main_menu" {{ old('menu_type', $permission->menu_type) == 'main_menu' ? 'selected' : '' }}>Main Menu</option>
                        <option value="sub_menu" {{ old('menu_type', $permission->menu_type) == 'sub_menu' ? 'selected' : '' }}>Sub Menu</option>
                    </select>
                    <div class="invalid-feedback">Please enter a menu type.</div>
                </div>

                <div class="col-md-4" id="menuKeyWrapper">
                    <label for="menu_key" class="form-label">Menu Key</label>
                    <input type="text" name="menu_key" id="menu_key" class="form-control" value="{{ old('menu_key', $permission->menu_key) }}" required>
                    <div class="invalid-feedback">Please enter menu key.</div>
                </div>

                <div class="col-md-12">
                    <label for="activities" class="form-label">Activities</label>

                    <select name="activities[]" id="activities" class="form-select" multiple required>
                        @foreach($activities as $activity)
                        <option value="{{ $activity->id }}" {{ in_array($activity->id, explode(',', $permission->activity_id)) ? 'selected' : '' }}>
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

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Update Permission
                </button>
            </div>
        </form>
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

        toggleMenuKey();
        menuType.addEventListener('change', toggleMenuKey);
    });
</script>

<!-- Activities select2 initialization -->
<script>
    $(document).ready(function() {
        $('#activities').select2({
            placeholder: 'Select Activities',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush