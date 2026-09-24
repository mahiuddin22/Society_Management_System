@extends('admin.layouts.app')

@section('content')

<!-- Edit Form Card -->
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.draft.update', $draft->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">

                <div class="col-md-6">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" id="type" name="type" class="form-control" value="{{$draft->type}}" placeholder="SMS Type" required>
                    <div class="invalid-feedback">Please enter SMS type.</div>
                </div>

                <div class="col-md-6">
                    <label for="language" class="form-label">Language</label>
                    <select name="language" id="language" class="form-select" required>
                        <option value="" disabled selected>Select</option>
                        <option value="English" {{ $draft->language == 'English' ? 'selected': ''}}>English</option>
                        <option value="Bangla" {{ $draft->language == 'Bangla' ? 'selected': ''}}>Bangla</option>
                    </select>
                    <div class="invalid-feedback">Please select language.</div>
                </div>

                <div class="col-12">
                    <label for="message" class="form-label">Message</label>

                    <textarea id="message" name="message" class="form-control" rows="5" placeholder="Write message..." required>{{$draft->message}}</textarea>

                    <div class="invalid-feedback">Message field is required.</div>

                    <div class="d-flex justify-content-between mt-2">
                        <small class="text-muted">
                            <span id="characterCount">0</span> characters
                        </small>

                        <small class="text-muted">
                            <span id="smsCount">0</span> SMS / Recipinent
                        </small>
                    </div>
                </div>

            </div>

            <div class="mt-4">

                <a href="{{ route('admin.draft.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>

                <button type="submit" class="btn btn-primary g-3">
                    <i class="bi bi-save me-1"></i> Save
                </button>

            </div>

        </form>
    </div>
</div>

@endsection
@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const message = document.getElementById('message');
        const language = document.getElementById('language');
        const characterCount = document.getElementById('characterCount');
        const smsCount = document.getElementById('smsCount');

        function updateCount() {

            const characters = message.value.length;
            const limit = language.value === 'Bangla' ? 67 : 160;

            const sms = characters === 0 ? 0 : Math.ceil(characters / limit);

            characterCount.textContent = characters;
            smsCount.textContent = sms;

        }

        message.addEventListener('input', updateCount);

        language.addEventListener('change', updateCount);

        updateCount();

    });
</script>

@endpush