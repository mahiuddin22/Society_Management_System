@extends('admin.layouts.app')

@section('content')

<form action="{{ route('admin.draft.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-3">

  <input type="text" name="type" class="form-control" value="{{ request('type') }}" placeholder="Type">

  <input type="text" name="message" class="form-control" value="{{ request('message') }}" placeholder="Message">

  <select name="language" class="form-select">
    <option value="">All Languages</option>
    <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English</option>
    <option value="Bangla" {{ request('language') == 'Bangla' ? 'selected' : '' }}>Bangla</option>
  </select>

  <input type="number" name="length" class="form-control" value="{{ request('length') }}" placeholder="Length">

  <button type="submit" class="btn btn-primary">Filter</button>
  @if(request()->hasAny(['type', 'message', 'language']))
  <a href="{{ route('admin.draft.index') }}" class="btn btn-secondary">Reset</a>
  @endif
</form>


<div class="card">

  <div class="card-head">
    <h3>Saved Drafts</h3>

    <a href="{{ route('admin.draft.create') }}" class="btn btn-primary btn-sm">
      + New Draft
    </a>
  </div>

  <div class="table-wrap">

    <table class="ledger text-nowrap">

      <thead>
        <tr>
          <th>Type</th>
          <th>Message</th>
          <th>Language</th>
          <th>Length</th>
          <th>SMS/Recipient</th>
          <th>Saved</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>

        @forelse($drafts as $draft)

        <tr>

          <td>{{ $draft->type }}</td>

          <td>{{ $draft->message }}</td>

          <td>{{ $draft->language }}</td>

          <td>{{ $draft->length }}</td>

          <td>
            {{ $draft->length > 0 ? ceil($draft->length / ($draft->language == 'Bangla' ? 67 : 160)) : 0 }}
          </td>

          <td>
            {{ $draft->created_at->format('d-M-Y') }}
          </td>

          <td>
            <div class="d-flex justify-content-center gap-2">

              <a href="{{ route('admin.draft.edit', $draft->id) }}"
                class="btn btn-secondary btn-sm">
                Edit
              </a>

              <form action="{{ route('admin.draft.destroy', $draft->id) }}"
                method="POST"
                id="delete-form-{{ $draft->id }}">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-primary btn-sm">
                  Delete
                </button>
              </form>

            </div>
          </td>

        </tr>

        @empty

        <tr>
          <td colspan="7" class="text-center">
            No drafts found.
          </td>
        </tr>

        @endforelse

      </tbody>

    </table>

  </div>

  @if($drafts->hasPages())

  <div class="p-3 d-flex justify-content-center">
    {{ $drafts->links('pagination::bootstrap-5') }}
  </div>

  @endif

</div>

@endsection