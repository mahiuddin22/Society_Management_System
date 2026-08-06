@extends('admin.layouts.app')

@section('content')

<form action="{{ route('admin.role-permissions.update') }}" method="POST" class="row g-2 mb-3 mt-2">
    @csrf
    <div class="card shadow-sm">
        <div class="card-body">

            <!-- Role Selection -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="role_id" class="form-label">Role User</label>
                    <select name="role" id="role_id" class="form-select" required>
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a role.</div>
                </div>
            </div>

            <!-- AJAX Loaded Table -->
            <div id="permissions-container"></div>

        </div>
    </div>
</form>

<!-- jQuery for AJAX -->
<script>
    $(document).ready(function() {
        $('#role_id').on('change', function() {
            var role = $(this).val();

            if (role) {
                $.ajax({
                    url: "{{ route('admin.role-permissions.get') }}",
                    type: "GET",
                    data: {
                        role: role
                    },
                    success: function(response) {
                        $('#permissions-container').html(response);
                    }
                });
            } else {
                $('#permissions-container').html('');
            }
        });
    });
</script>

@endsection