<form method="GET" class="row g-2 align-items-end mb-3 bg-white p-3 rounded shadow-sm">
<div class="col-6 col-md-2"><label class="form-label">From date *</label><input class="form-control" type="date" name="date_from" required value="{{ $filters['from'] }}"></div>
<div class="col-6 col-md-2"><label class="form-label">To date *</label><input class="form-control" type="date" name="date_to" required value="{{ $filters['to'] }}"></div>
@if(request()->routeIs('admin.report.plotmanagement'))
<div class="col-6 col-md-2"><label class="form-label">Road</label><select class="form-select" name="road_id"><option value="">All roads</option>@foreach($roads as $road)<option value="{{ $road->id }}" @selected(request('road_id')==$road->id)>Road {{ $road->number }}</option>@endforeach</select></div>
<div class="col-6 col-md-2"><label class="form-label">Plot type</label><select class="form-select" name="plot_type_id"><option value="">All types</option>@foreach($plotTypes as $type)<option value="{{ $type->id }}" @selected(request('plot_type_id')==$type->id)>{{ $type->name }}</option>@endforeach</select></div>
<div class="col-6 col-md-2"><label class="form-label">Status</label><select class="form-select" name="status"><option value="">All statuses</option>@foreach(['Active','Inactive','Hold','Archived'] as $v)<option @selected(request('status')===$v)>{{ $v }}</option>@endforeach</select></div>
@elseif(request()->routeIs('admin.report.billcollections'))
<div class="col-6 col-md-2"><label class="form-label">Road</label><select class="form-select" name="road_id"><option value="">All roads</option>@foreach($roads as $road)<option value="{{ $road->id }}" @selected(request('road_id')==$road->id)>Road {{ $road->number }}</option>@endforeach</select></div>
<div class="col-6 col-md-2"><label class="form-label">Method</label><select class="form-select" name="method"><option value="">All methods</option>@foreach(['Cash','bKash','Nagad','Bank Transfer','Cheque'] as $v)<option @selected(request('method')===$v)>{{ $v }}</option>@endforeach</select></div>
@else
<div class="col-6 col-md-2"><label class="form-label">Mobile no.</label><input class="form-control" name="mobile_no" value="{{ request('mobile_no') }}"></div>
<div class="col-6 col-md-2"><label class="form-label">Status</label><select class="form-select" name="status"><option value="">All statuses</option>@foreach(['sent','canceled'] as $v)<option @selected(request('status')===$v)>{{ $v }}</option>@endforeach</select></div>
<div class="col-6 col-md-2"><label class="form-label">Message type</label><select class="form-select" name="sms_type"><option value="">All types</option>@foreach(['custom','draft'] as $v)<option @selected(request('sms_type')===$v)>{{ ucfirst($v) }}</option>@endforeach</select></div>
@endif
<div class="col-6 col-md-2"><label class="form-label">Search</label><input class="form-control" name="search" value="{{ request('search') }}" placeholder="Search report"></div>
<div class="col-12 col-md-auto d-flex gap-2"><button class="btn btn-primary">Apply filters</button><a class="btn btn-outline-secondary" href="{{ url()->current() }}">Reset</a></div>
</form>
