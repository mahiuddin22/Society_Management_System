@extends('admin.layouts.app')

@section('content')
<section class="panel active">
  <div class="row justify-content-center py-2"><div class="col-12 col-xl-9">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
      <div><h3 class="mb-1" style="font-family:var(--font-display);color:var(--ink-900)">{{ !empty($editing) ? 'Edit Missing Units and Note' : 'Add Missing Units and Note' }}</h3><span class="hint">Enter missing unit numbers and an important note for this plot.</span></div>
      <a href="{{ route('admin.missing-flats.index') }}" class="btn btn-ghost">Back to Missing Flats</a>
    </div>

    <form action="{{ !empty($editing) ? route('admin.missing-flats.update', $plots->first()) : route('admin.missing-flats.store') }}" method="POST" autocomplete="off">
      @csrf
      @if(!empty($editing)) @method('PUT') @endif
      <div class="card p-4 mb-4">
        <div class="mb-3">
          <label class="form-label fw-semibold" for="plot_and_unit_id">Plot / Building <span class="text-danger">*</span></label>
          <select class="select w-100" id="plot_and_unit_id" name="plot_and_unit_id" {{ !empty($editing) ? 'disabled' : '' }} {{ !empty($editing) ? '' : 'required' }}>
            <option value="">Select a plot</option>
            @foreach($plots as $plot)
              @php
                $missingCount = max(0, (int)$plot->total_flat - (int)$plot->occupied_flat);
                $remaining = max(0, $missingCount - $plot->missingFlats->count());
              @endphp
              <option value="{{ $plot->id }}" data-remaining="{{ $remaining }}" {{ old('plot_and_unit_id', $selectedPlotId) == $plot->id ? 'selected' : '' }}>
                Road {{ $plot->road?->number ?? '—' }} · Holding {{ $plot->holding_no }}{{ $plot->building_name ? ' · '.$plot->building_name : '' }} ({{ $remaining }} to list)
              </option>
            @endforeach
          </select>
          @if(!empty($editing))<input type="hidden" name="plot_and_unit_id" value="{{ $plots->first()->id }}">@endif
          @error('plot_and_unit_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          <div id="capacityHint" class="hint small mt-2"></div>
        </div>

        <div>
          <label class="form-label fw-semibold" for="flatInput">Missing unit numbers</label>
          <div id="flatBadgeContainer" class="input w-100 d-flex flex-wrap align-items-center gap-1" style="min-height:46px;cursor:text">
            <input id="flatInput" type="text" class="border-0 flex-grow-1" style="outline:0;min-width:150px;background:transparent" placeholder="Type a flat number and press Enter">
          </div>
          <div class="form-text">Add multiple unit numbers, such as 1A, 1B, 2A. The missing count remains calculated from total minus occupied.</div>
          <div id="flatNumberInputs"></div>
          @error('flat_numbers')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          @error('flat_numbers.*')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mt-4">
          <label class="form-label fw-semibold" for="missing_flat_note">Important note</label>
          <textarea id="missing_flat_note" name="missing_flat_note" class="input w-100" rows="4" maxlength="5000" placeholder="Write an important note about the missing flats">{{ old('missing_flat_note', !empty($editing) ? $plots->first()->missing_flat_note : '') }}</textarea>
          @error('missing_flat_note')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="d-flex justify-content-end gap-2"><a href="{{ route('admin.missing-flats.index') }}" class="btn btn-ghost">Cancel</a><button type="submit" class="btn btn-primary px-4">{{ !empty($editing) ? 'Update' : 'Save' }}</button></div>
    </form>
  </div></div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('flatBadgeContainer');
  const input = document.getElementById('flatInput');
  const hidden = document.getElementById('flatNumberInputs');
  const select = document.getElementById('plot_and_unit_id');
  const hint = document.getElementById('capacityHint');
  let flats = @json(old('flat_numbers', !empty($editing) ? $plots->first()->missingFlats->pluck('flat_number')->all() : []));

  function render() {
    container.querySelectorAll('.flat-tag').forEach(el => el.remove());
    hidden.replaceChildren();
    flats.forEach((flat, index) => {
      const tag = document.createElement('span');
      tag.className = 'flat-tag badge green d-inline-flex align-items-center gap-1';
      tag.textContent = flat + ' ';
      const remove = document.createElement('button');
      remove.type = 'button'; remove.className = 'btn btn-ghost p-0 border-0 text-danger'; remove.textContent = '×';
      remove.addEventListener('click', () => { flats.splice(index, 1); render(); });
      tag.append(remove); container.insertBefore(tag, input);
      const field = document.createElement('input'); field.type = 'hidden'; field.name = 'flat_numbers[]'; field.value = flat; hidden.append(field);
    });
  }
  function add(value) {
    value.split(',').map(v => v.trim().toUpperCase()).filter(Boolean).forEach(v => { if (!flats.includes(v)) flats.push(v); });
    input.value = ''; render();
  }
  input.addEventListener('keydown', event => {
    if (event.key === 'Enter' || event.key === ',') { event.preventDefault(); add(input.value); }
    if (event.key === 'Backspace' && !input.value && flats.length) { flats.pop(); render(); }
  });
  input.addEventListener('blur', () => { if (input.value.trim()) add(input.value); });
  container.addEventListener('click', () => input.focus());
  select.addEventListener('change', () => {
    const remaining = select.selectedOptions[0]?.dataset.remaining;
    hint.textContent = remaining === undefined ? '' : `${remaining} missing flat number(s) can still be listed for this plot.`;
  });
  select.dispatchEvent(new Event('change'));
  render();
});
</script>
@endpush
