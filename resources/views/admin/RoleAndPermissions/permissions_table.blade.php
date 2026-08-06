<div class="table-responsive mt-3">
    <table class="table table-striped table-bordered nowrap align-middle">
        <thead>
            <tr>
                <th>SL</th>
                <th>Permission (Menu)</th>
                <th class="text-center">All</th>
                @foreach($activities as $activity)
                <th class="text-center accesscolor">{{ ucfirst($activity->name) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="{{ $permission->menu_type == 'main_menu' ? 'fw-bold text-success' : 'text-muted small' }}">
                    {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                </td>

                <td class="text-center">
                    @if($permission->menu_type != 'main_menu')
                    <?php
                    $allChecked = true;
                    foreach ($activities as $activity) {
                        $key = $permission->id . '_' . $activity->id;
                        if (!in_array($key, $rolePermissions)) {
                            $allChecked = false;
                            break;
                        }
                    }
                    ?>
                    <input type="checkbox" class="check-all-row" {{ $allChecked ? 'checked' : '' }}>
                    @endif
                </td>


                @php
                $permissionActivities = $permission->activity_id ? array_map('trim', explode(',', $permission->activity_id)) : [];
                @endphp

                @foreach($activities as $activity)
                @if($permission->menu_type == 'main_menu')
                <td class="text-center"></td>
                @elseif(in_array($activity->id, $permissionActivities))
                <td class="text-center {{ $activity->activity_key == 'access' ? 'accesstdcolor' : '' }}">
                    <input type="checkbox" name="permissions[{{ $permission->id }}][{{ $activity->id }}]" value="1"
                        {{ in_array($permission->id . '_' . $activity->id, $rolePermissions) ? 'checked' : '' }}>
                </td>
                @else
                <td class="text-center"></td>
                @endif
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.addEventListener('change', function(e) {
            if (e.target.type !== 'checkbox') return;

            const row = e.target.closest('tr');
            const isCheckAll = e.target.classList.contains('check-all-row');

            // when "Check All" clicked
            if (isCheckAll) {
                row.querySelectorAll('input[type="checkbox"]:not(.check-all-row)')
                    .forEach(cb => cb.checked = e.target.checked);
            }
            // when any other checkbox clicked
            else {
                const checkAll = row.querySelector('.check-all-row');
                if (checkAll) {
                    const allChecked = [...row.querySelectorAll('input[type="checkbox"]:not(.check-all-row)')].every(cb => cb.checked);
                    checkAll.checked = allChecked;
                }
            }
        });
    </script>

</div>

<div class="row mt-3 align-items-start">
    <!-- Left side: Apply for all users -->
    <div class="col-md-6 d-flex align-items-start">
        <input type="checkbox" name="apply_for_all" id="apply_for_all" value="1" class="me-2 mt-1">
        <div class="d-flex flex-column">
            <label for="apply_for_all" class="mb-0 fw-semibold">Reset permissions of all users</label>
            <small class="text-danger">
                This will reset all user specific permissions of all users in this role
            </small>
        </div>
    </div>

    <!-- Right side: Buttons -->
    <div class="col-md-6 text-end">
        <div class="btn-group" role="group">
            <a href="{{ url()->previous() }}" class="btn btn-outline-danger rounded-start px-4 py-2">Cancel</a>
            <button type="submit" class="btn btn-success rounded-end px-4 py-2">Submit</button>
        </div>
    </div>
</div>