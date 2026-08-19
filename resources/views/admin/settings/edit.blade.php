@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">Settings</h5>
        </div>

        <div class="card-body">
            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-4" id="settingsTab" role="tablist">

                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic-settings" type="button" role="tab" aria-controls="basic-settings" aria-selected="true">Basic Settings</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email-settings" type="button" role="tab" aria-controls="email-settings" aria-selected="false">Email Settings</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#change-password" type="button" role="tab" aria-controls="change-password" aria-selected="false">Change Password</button>
                </li>

            </ul>

            <!-- {{-- Tab Content --}} -->
            <div class="tab-content" id="settingsTabContent">

                <!-- {{-- BASIC SETTINGS --}} -->
                <div class="tab-pane fade show active" id="basic-settings" role="tabpanel" aria-labelledby="basic-tab">
                    <form action="{{ route('admin.settings.basic.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4 align-items-start">

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Logo Preview</label>

                                <div id="logo-upload-area" class="border rounded p-3 d-flex align-items-center justify-content-center" style="height: 180px; cursor: pointer;">
                                    <img id="logo-preview" src="{{ !empty($settings->logo) ? asset('uploads/settings/'.$settings->logo) : asset('uploads/settings/default.png') }}" alt="Logo Preview" style="max-height: 140px; max-width: 100%; object-fit: contain;">
                                </div>

                                <input type="file" name="logo" id="logo" class="d-none @error('logo') is-invalid @enderror" accept="image/*">

                                @error('logo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <small class="text-muted d-block mt-2">Click the preview to upload a new logo.</small>
                            </div>

                            <div class="col-md-9">
                                <div class="row g-3">

                                    <div class="col-md-12">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $settings->name ?? '') }}" placeholder="Enter name">

                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="contact" class="form-label">Contact <span class="text-danger">*</span></label>
                                        <input type="text" name="contact" id="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact', $settings->contact ?? '') }}" placeholder="Enter contact info">

                                        @error('contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $settings->email ?? '') }}" placeholder="Enter email info">

                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea name="address" id="address" rows="4" class="form-control @error('address') is-invalid @enderror" placeholder="Enter address">{{ old('address', $settings->address ?? '') }}</textarea>

                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Basic Settings</button>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- {{-- EMAIL SETTINGS --}} -->
                <div class="tab-pane fade" id="email-settings" role="tabpanel" aria-labelledby="email-tab">

                    <form action="{{ route('admin.settings.email.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="mail_mailer" class="form-label">Mail Mailer</label>
                                <select name="mail_mailer" id="mail_mailer" class="form-select @error('mail_mailer') is-invalid @enderror">
                                    <option value="smtp" {{ old('mail_mailer', $settings->mail_mailer ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                    <option value="sendmail" {{ old('mail_mailer', $settings->mail_mailer ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                </select>

                                @error('mail_mailer')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="mail_host" class="form-label">Mail Host</label>
                                <input type="text" name="mail_host" id="mail_host" class="form-control" value="{{ old('mail_host', $settings->mail_host ?? '') }}" placeholder="smtp.example.com">
                            </div>

                            <div class="col-md-4">
                                <label for="mail_port" class="form-label">Mail Port</label>
                                <input type="number" name="mail_port" id="mail_port" class="form-control" value="{{ old('mail_port', $settings->mail_port ?? '') }}" placeholder="587">
                            </div>

                            <div class="col-md-4">
                                <label for="mail_username" class="form-label">Mail Username</label>
                                <input type="text" name="mail_username" id="mail_username" class="form-control" value="{{ old('mail_username', $settings->mail_username ?? '') }}" placeholder="username@example.com">
                            </div>

                            <div class="col-md-4">
                                <label for="mail_password" class="form-label">Mail Password</label>
                                <input type="password" name="mail_password" id="mail_password" class="form-control" placeholder="Enter new password">
                            </div>

                            <div class="col-md-6">
                                <label for="mail_encryption" class="form-label">Encryption</label>
                                <select name="mail_encryption" id="mail_encryption" class="form-select">
                                    <option value="">None</option>
                                    <option value="tls" {{ old('mail_encryption', $settings->mail_encryption ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ old('mail_encryption', $settings->mail_encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="mail_from_address" class="form-label">From Email</label>
                                <input type="email" name="mail_from_address" id="mail_from_address" class="form-control" value="{{ old('mail_from_address', $settings->mail_from_address ?? '') }}" placeholder="noreply@example.com">
                            </div>

                            <div class="col-md-6">
                                <label for="mail_from_name" class="form-label">From Name</label>
                                <input type="text" name="mail_from_name" id="mail_from_name" class="form-control" value="{{ old('mail_from_name', $settings->mail_from_name ?? '') }}" placeholder="Your Company Name">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Email Settings</button>
                            </div>

                        </div>
                    </form>

                </div>

                <!-- {{-- CHANGE PASSWORD --}} -->
                <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="password-tab">

                    <form action="{{ route('admin.settings.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                                <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Enter current password">

                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12"></div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password">

                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-key"></i> Change Password</button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    document.getElementById('logo-upload-area').addEventListener('click', function() {
        document.getElementById('logo').click();
    });

    document.getElementById('logo').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('logo-preview').src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    });
</script>
@endpush