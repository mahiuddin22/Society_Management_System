@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-profile">
    <div class="row justify-content-center py-2">
        <div class="col-12 col-xl-10">
            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <div class="p-4 p-lg-5 border-bottom" style="background: var(--paper-50); border-top: 3px solid var(--forest-700);">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-white fw-bold" style="width: 58px; height: 58px; background: var(--forest-700); font-family: var(--font-display); font-size: 22px;">
                                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <span class="hint small text-uppercase fw-semibold">Account Profile</span>
                                <h2 class="m-0 mt-1" style="font-family: var(--font-display); font-size: 25px; color: var(--ink-900);">{{ $user->name }}</h2>
                                <span class="hint">View and manage your account information</span>
                            </div>
                        </div>
                        <span class="badge green px-3 py-2"><span class="dot"></span>{{ ucfirst($user->role) }}</span>
                    </div>
                </div>

                    <!-- Tabs -->
                    <div class="px-3 px-lg-5 pt-2 border-bottom">
                    <ul class="nav nav-tabs border-0" id="profileTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                data-bs-target="#overview" type="button" role="tab">
                                <i class="bi bi-person-vcard me-1"></i> Overview
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab"
                                data-bs-target="#settings" type="button" role="tab">
                                <i class="bi bi-pencil-square me-1"></i> Edit Info
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="changePassword-tab" data-bs-toggle="tab"
                                data-bs-target="#changePassword" type="button" role="tab">
                                <i class="bi bi-shield-lock me-1"></i> Change Password
                            </button>
                        </li>
                    </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content flex-grow-1 p-3 p-lg-5" id="profileTabsContent">

                        <!-- Overview -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="card p-4 mb-4">
                                <div class="card-head pb-2 mb-3 border-bottom">
                                    <div>
                                        <h4 class="m-0 fw-bold" style="font-size: 15px; color: var(--ink-900);">Profile Overview</h4>
                                        <span class="hint small">Your account and contact information</span>
                                    </div>
                                </div>
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

                            @if ($user->role === 'member')
                            <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                    <div>
                                        <h4 class="m-0 fw-bold" style="font-size: 15px; color: var(--ink-900);">Plot / Unit Information</h4>
                                        <p class="text-muted small mb-0">Properties linked to your member account</p>
                                    </div>
                                    <span class="badge rounded-pill text-bg-light border">{{ $plots->count() }} {{ \Illuminate\Support\Str::plural('property', $plots->count()) }}</span>
                            </div>

                                @forelse ($plots as $plot)
                                @php
                                    $totalFlats = (int) $plot->total_flat;
                                    $occupiedFlats = (int) $plot->occupied_flat;
                                    $occupancyPercent = $totalFlats > 0 ? min(round(($occupiedFlats / $totalFlats) * 100), 100) : 0;
                                @endphp
                                <div class="card p-4 mb-4">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                        <div>
                                            <h6 class="mb-1 fw-bold text-success">{{ $plot->building_name ?: 'Holding ' . $plot->holding_no }}</h6>
                                            <span class="hint small">UID: <code>{{ $plot->unique_id }}</code> &bull; Registered: {{ $plot->created_at?->format('d M, Y') ?: 'N/A' }}</span>
                                        </div>
                                        <span class="badge {{ $plot->status === 'Active' ? 'green' : 'neutral' }}"><span class="dot"></span>{{ $plot->status }}</span>
                                    </div>

                                    <h6 class="small fw-bold text-uppercase mb-3" style="color: var(--ink-700);">Property Identity &amp; Location</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-6 col-md-3"><span class="d-block hint small mb-1">Plot Type</span><span class="fw-semibold">{{ $plot->plotType?->name ?? 'N/A' }}</span></div>
                                        <div class="col-6 col-md-3"><span class="d-block hint small mb-1">Road No.</span><span class="fw-semibold">Road {{ $plot->road?->number ?? 'N/A' }}</span></div>
                                        <div class="col-6 col-md-3"><span class="d-block hint small mb-1">Holding Number</span><span class="fw-bold" style="font-family: var(--font-ledger);">{{ $plot->holding_no }}</span></div>
                                        <div class="col-6 col-md-3"><span class="d-block hint small mb-1">Building Name</span><span class="fw-semibold">{{ $plot->building_name ?: '—' }}</span></div>
                                    </div>

                                    <h6 class="small fw-bold text-uppercase mb-3" style="color: var(--ink-700);">Flats &amp; Occupancy Configuration</h6>
                                    <div class="row g-3 align-items-center mb-3">
                                        <div class="col-6 col-md-3"><span class="d-block hint small mb-1">Total Flats</span><span class="fw-bold" style="font-family: var(--font-ledger);">{{ $totalFlats }}</span></div>
                                        <div class="col-6 col-md-3"><span class="d-block hint small mb-1">Occupied Flats</span><span class="fw-bold text-success" style="font-family: var(--font-ledger);">{{ $occupiedFlats }}</span></div>
                                        <div class="col-12 col-md-3"><span class="d-block hint small mb-1">Collection Mode</span><span class="badge neutral">{{ $plot->collection_type ?? 'N/A' }}</span></div>
                                        <div class="col-12 col-md-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1"><span class="hint small">Occupancy Ratio</span><span class="fw-bold small text-success">{{ $occupancyPercent }}%</span></div>
                                            <div class="progress" style="height: 7px; background: var(--line);"><div class="progress-bar" style="width: {{ $occupancyPercent }}%; background: var(--forest-700);"></div></div>
                                            <span class="hint small">{{ $occupiedFlats }} occupied of {{ $totalFlats }}</span>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <span class="d-block hint small mb-2">Registered Flat Units</span>
                                        @if ($plot->flat_numbers)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach (explode(',', $plot->flat_numbers) as $flat)
                                                    <span class="badge green">{{ trim($flat) }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted small fst-italic">No individual flat tags registered.</span>
                                        @endif
                                    </div>

                                    <h6 class="small fw-bold text-uppercase mb-3" style="color: var(--ink-700);">Contact Representative</h6>
                                    <div class="row g-3">
                                        <div class="col-6 col-md-3"><span class="d-block hint small mb-1">Full Name</span><span class="fw-semibold">{{ $plot->name ?: '—' }}</span></div>
                                        <div class="col-6 col-md-3"><span class="d-block hint small mb-1">Flat No.</span><span class="fw-semibold">{{ $plot->flat_no ?: '—' }}</span></div>
                                        <div class="col-6 col-md-3"><span class="d-block hint small mb-1">Phone</span><a href="tel:{{ $plot->phone }}" class="fw-semibold text-success text-decoration-none">{{ $plot->phone ?: '—' }}</a></div>
                                        <div class="col-6 col-md-3"><span class="d-block hint small mb-1">Email Address</span><span class="fw-semibold">{{ $plot->email ?: '—' }}</span></div>
                                    </div>
                                </div>
                                @empty
                                <div class="border rounded-3 bg-light px-3 py-4 text-center text-muted">No plot or unit is linked to this member account.</div>
                                @endforelse
                            </div>
                            @endif
                        </div>

                        <!-- Settings -->
                        <div class="tab-pane fade" id="settings" role="tabpanel">
                            <div class="card p-4">
                            <div class="card-head pb-2 mb-3 border-bottom">
                                <div>
                                    <h4 class="m-0 fw-bold" style="font-size: 15px; color: var(--ink-900);">Edit Profile Information</h4>
                                    <span class="hint small">Update your account details</span>
                                </div>
                            </div>
                            <form action="{{ route('admin.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ auth()->user()->name }}">
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control" id="email" value="{{ auth()->user()->email }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" name="phone" class="form-control" id="phone" value="{{ auth()->user()->phone }}">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i> Save Changes
                                </button>
                            </form>
                            </div>
                        </div>

                        <!-- Change Password -->
                        <div class="tab-pane fade" id="changePassword" role="tabpanel">
                            <div class="card p-4">
                            <div class="card-head pb-2 mb-3 border-bottom">
                                <div>
                                    <h4 class="m-0 fw-bold" style="font-size: 15px; color: var(--ink-900);">Change Password</h4>
                                    <span class="hint small">Choose a strong password for your account</span>
                                </div>
                            </div>
                            <form action="{{ route('admin.password.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="password" class="form-label">Enter Old Password</label>
                                    <input type="password" name="password" class="form-control" id="password">
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
                                            <input type="password" name="new_password" class="form-control" id="new_password">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                                            <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i> Save Changes
                                </button>
                            </form>
                            </div>
                        </div>

                    </div> <!-- tab-content -->
            </div> <!-- profile card -->
        </div>
    </div>
</section>
@endsection
