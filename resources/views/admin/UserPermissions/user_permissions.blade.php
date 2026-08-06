@extends('admin.layouts.app')

@section('content')
<form action="{{ route('admin.user-permissions.update') }}" method="POST" class="row g-2 mb-3 mt-2">
    @csrf
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="user_id" class="form-label">Select User</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a user.</div>
                </div>
            </div>

            <div id="permissions-container"></div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#user_id').on('change', function() {
            var userId = $(this).val();
            if (userId) {
                $.get("{{ route('admin.user-permissions.get') }}", {
                    user_id: userId
                }, function(response) {
                    $('#permissions-container').html(response);
                });
            } else {
                $('#permissions-container').html('');
            }
        });
    });
</script>
@endsection