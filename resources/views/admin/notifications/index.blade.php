@extends('admin.layouts.app')

@section('content')
@php
    $notificationStyles = [
        'bill_month' => ['icon' => 'bi-receipt', 'class' => 'text-success bg-success-subtle', 'label' => 'Bill'],
        'collection' => ['icon' => 'bi-cash-coin', 'class' => 'text-primary bg-primary-subtle', 'label' => 'Payment'],
        'plot' => ['icon' => 'bi-building', 'class' => 'text-warning-emphasis bg-warning-subtle', 'label' => 'Plot'],
        'bulk_plot' => ['icon' => 'bi-cloud-arrow-up', 'class' => 'text-warning-emphasis bg-warning-subtle', 'label' => 'Import'],
    ];
@endphp

<section class="panel active" id="panel-notifications">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">Notifications</h2>
            <p class="text-body-secondary mb-0">Your recent bills, payments, and account activity.</p>
        </div>
        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
            <i class="bi bi-check2-all me-1"></i> All caught up
        </span>
    </div>

    <div class="card border-0 shadow-sm">
        @if ($notifications->count())
            <div class="list-group list-group-flush">
                @foreach ($notifications as $notification)
                    @php($style = $notificationStyles[$notification['type']] ?? $notificationStyles['bill_month'])
                    <div class="list-group-item px-3 px-md-4 py-3">
                        <div class="d-flex align-items-start gap-3">
                            <span class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 {{ $style['class'] }}" style="width: 44px; height: 44px;">
                                <i class="bi {{ $style['icon'] }} fs-5" aria-hidden="true"></i>
                            </span>
                            <div class="flex-grow-1 min-width-0">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                    <div>
                                        <span class="badge rounded-pill bg-light text-body-secondary border mb-2">{{ $style['label'] }}</span>
                                        <h3 class="h6 mb-1">{{ $notification['title'] }}</h3>
                                        @if (filled($notification['details']))
                                            <p class="text-body-secondary small mb-0">{{ $notification['details'] }}</p>
                                        @endif
                                    </div>
                                    <span class="text-body-secondary small text-nowrap">{{ $notification['time'] }}</span>
                                </div>
                                <a href="{{ $notification['url'] }}" class="small fw-semibold text-decoration-none d-inline-flex align-items-center gap-1 mt-2">
                                    View details <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($notifications->hasPages())
                <div class="card-footer bg-white px-3 px-md-4 py-3">
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="text-center px-4 py-5">
                <span class="rounded-circle bg-light text-body-secondary d-inline-flex align-items-center justify-content-center mb-3" style="width: 58px; height: 58px;">
                    <i class="bi bi-bell fs-4" aria-hidden="true"></i>
                </span>
                <h3 class="h5 mb-2">You’re all caught up</h3>
                <p class="text-body-secondary mb-0">There are no notifications to show right now.</p>
            </div>
        @endif
    </div>
</section>
@endsection
