@extends('admin.layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5">

    <!-- Profile Card -->
    <div class="card shadow-lg border-0 rounded-3" style="max-width: 900px; width: 100%;">
        <div class="row g-0">

            <!-- Profile Picture Section (fixed height) -->
            <div class="col-md-4">
                <div class="bg-light rounded-start"
                    style="width: 100%; height: 450px; display: flex; justify-content: center; align-items: center;">
                    <img src="{{ asset('assets/images/noyon.jpg') }}" alt="Profile Picture" class="rounded-start"
                        style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>

            <!-- Tab Section (flexible height) -->
            <div class="col-md-8 d-flex flex-column">
                <div class="card-body p-4 d-flex flex-column">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded text-white"
                        style="background: linear-gradient(135deg, #0d6efd, #6610f2);">
                        <div>
                            <h4 class="fw-bold mb-0">{{ auth()->user()->name }}</h4>
                            <small class="text-light">{{ auth()->user()->role }}</small>
                        </div>
                        <a href="#" class="btn btn-sm btn-light">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3" id="profileTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                data-bs-target="#overview" type="button" role="tab">
                                Overview
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab"
                                data-bs-target="#settings" type="button" role="tab">
                                Settings
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="changePassword-tab" data-bs-toggle="tab"
                                data-bs-target="#changePassword" type="button" role="tab">
                                Change Password
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content flex-grow-1" id="profileTabsContent">

                        <!-- Overview -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Email:</strong>
                                    <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Phone:</strong>
                                    <p class="text-muted mb-0">{{ auth()->user()->phone }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Role:</strong>
                                    <p class="text-muted mb-0">{{ auth()->user()->role }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Joined:</strong>
                                    <p class="text-muted mb-0">{{ auth()->user()->created_at->format('d M, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="tab-pane fade" id="settings" role="tabpanel">
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" value="{{ auth()->user()->name }}">
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" value="{{ auth()->user()->email }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="phone" value="{{ auth()->user()->phone }}">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i> Save Changes
                                </button>
                            </form>
                        </div>

                        <!-- Change Password -->
                        <div class="tab-pane fade" id="changePassword" role="tabpanel">
                            <form>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Enter Old Password</label>
                                    <input type="password" class="form-control" id="password">
                                    @if (Route::has('password.request'))
                                    <div class="forgot-password">
                                        <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot your password?</a>
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="new_password" class="form-label">Enter New Password</label>
                                            <input type="password" class="form-control" id="new_password">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="confirm_password">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i> Save Changes
                                </button>
                            </form>
                        </div>

                    </div> <!-- tab-content -->

                </div> <!-- card-body -->
            </div> <!-- col-md-8 -->

        </div> <!-- row -->
    </div> <!-- card -->

</div> <!-- container -->
@endsection