<div class="d-flex flex-wrap gap-2 mb-3">
@foreach(['csv'=>'CSV','xlsx'=>'Excel','pdf'=>'PDF'] as $format => $label)
<a class="btn btn-outline-secondary btn-sm" href="{{ request()->fullUrlWithQuery(['export'=>$format]) }}">Download {{ $label }}</a>
@endforeach
</div>
