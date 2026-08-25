@extends('admin.layouts.app')

@push('styles')
<style>
    .contact-person-group {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')

<section class="panel active" id="panel-units">

    <div class="card">

        <div class="card-head">
            <h3>Edit Building / Unit</h3>
        </div>

        <form action="{{ route('admin.plot-and-units.update', $data->id) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <!-- {{-- Road --}} -->
                <div class="col-md-4">
                    <label for="road" class="form-label">Road <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="road" name="road" value="{{ old('road', $data->road) }}" placeholder="e.g. 1/A" required>
                </div>

                <!-- {{-- Holding No --}} -->
                <div class="col-md-4">
                    <label for="holding_no" class="form-label">Holding No. <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="holding_no" name="holding_no" value="{{ old('holding_no', $data->holding_no) }}" placeholder="e.g. 2" required>
                </div>

                <!-- {{-- Building Type --}} -->
                <div class="col-md-4">
                    <label for="building_type" class="form-label">Building Type <span class="text-danger">*</span></label>
                    <select class="form-select" id="building_type" name="building_type" required>
                        <option value="" disabled>Select Building Type</option>
                        @foreach($plot_types as $type)
                        <option value="{{ $type->id }}" {{ old('building_type', $data->building_type) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- {{-- Total Flat --}} -->
                <div class="col-md-4" id="totalFlatGroup">
                    <label for="total_flat" class="form-label">Total Flat <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="total_flat" name="total_flat" value="{{ old('total_flat', $data->total_flat) }}" min="0" placeholder="e.g. 12" required>
                </div>

                <!-- {{-- Occupied Flat --}} -->
                <div class="col-md-4" id="occupiedFlatGroup">
                    <label for="occupied_flat" class="form-label">Occupied Flat <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="occupied_flat" name="occupied_flat" value="{{ old('occupied_flat', $data->occupied_flat) }}" min="0" placeholder="e.g. 10" required>
                </div>

                <!-- {{-- Collection Type --}} -->
                <div class="col-md-4">
                    <label for="collection_type" class="form-label">Collection Type <span class="text-danger">*</span></label>
                    <select class="form-select" id="collection_type" name="collection_type" required>
                        <option value="">Select Collection Type</option>
                        <option value="Group" {{ old('collection_type', $data->collection_type) == 'Group' ? 'selected' : '' }}>Group</option>
                        <option value="Individual" {{ old('collection_type', $data->collection_type) == 'Individual' ? 'selected' : '' }}>Individual</option>
                    </select>
                </div>

                <!-- {{-- Contact Person --}} -->
                <div class="col-md-4" id="contactPersonGroup">
                    <label for="contact_person" class="form-label">Contact Person <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="contact_person" name="contact_person" value="{{ old('contact_person', $data->contact_person) }}" min="0" placeholder="Number of contact persons">
                </div>

                <!-- {{-- Collection Rate --}} -->
                <div class="col-md-4">
                    <label for="collection_rate" class="form-label">Collection Rate <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">৳</span>
                        <input type="number" class="form-control" id="collection_rate" name="collection_rate" value="{{ old('collection_rate', $data->collection_rate) }}" min="0" step="0.01" placeholder="250" required>
                    </div>
                </div>

                <!-- {{-- Discount --}} -->
                <div class="col-md-4">
                    <label for="discount" class="form-label">Discount</label>
                    <div class="input-group">
                        <span class="input-group-text">৳</span>
                        <input type="number" class="form-control" id="discount" name="discount" value="{{ old('discount', $data->discount ?? 0) }}" min="0" step="0.01" placeholder="500">
                    </div>
                </div>

                <!-- {{-- Collection Amount --}} -->
                <div class="col-md-4">
                    <label for="collection_amount" class="form-label">Collection Amount <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">৳</span>
                        <input type="number" class="form-control" id="collection_amount" name="collection_amount" value="{{ old('collection_amount', $data->collection_amount) }}" min="0" step="0.01" placeholder="2500" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="datepicker" class="form-label">Issue Date <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">৳</span>
                        <input type="text" class="form-control" id="datepicker" name="date" value="{{ old('date', \Carbon\Carbon::parse($data->date)->format('d-m-Y')) }}" placeholder="Select date" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="">Select Status</option>
                        <option value="1" {{$data->status == 1 ? 'selected':''}}>Active</option>
                        <option value="0" {{$data->status == 0 ? 'selected':''}}>Expired</option>
                    </select>
                </div>

                <!-- {{-- Dynamic Contact Persons --}} -->
                <div class="col-12">
                    <div id="contactPersonsContainer"></div>
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Building</button>
            </div>

        </form>

    </div>

</section>

@endsection

@push('scripts')

<script>
    const rates = @json($rates);

    const buildingType = document.getElementById('building_type');
    const collectionRate = document.getElementById('collection_rate');
    const occupiedFlat = document.getElementById('occupied_flat');
    const discount = document.getElementById('discount');
    const collectionAmount = document.getElementById('collection_amount');

    function calculateCollectionAmount() {

        const rate = parseFloat(collectionRate.value) || 0;
        const occupied = parseInt(occupiedFlat.value) || 0;
        const discountValue = parseFloat(discount.value) || 0;

        const amount = (rate * occupied) - discountValue;

        collectionAmount.value = Math.max(amount, 0);
    }

    buildingType.addEventListener('change', function() {

        collectionRate.value = rates[this.value] || 0;

        calculateCollectionAmount();
    });

    occupiedFlat.addEventListener('input', calculateCollectionAmount);

    discount.addEventListener('input', calculateCollectionAmount);
</script>


<script>
    const existingContactPersons = @json($members);

    const contactPersonInput = document.getElementById('contact_person');
    const contactPersonsContainer = document.getElementById('contactPersonsContainer');

    function generateContactPersons(count, existingPersons = []) {
        contactPersonsContainer.innerHTML = '';

        for (let i = 0; i < count; i++) {
            const person = existingPersons[i] || {};
            const memberId = person.id ?? '';
            contactPersonsContainer.insertAdjacentHTML('beforeend', `
                <div class="contact-person-group border rounded p-3 mb-3">
                <input type="hidden" name="contact_persons[${i}][id]" value="${memberId}">
                    <h6 class="mb-3">Contact Person ${i + 1}</h6>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="contact_persons[${i}][name]" value="${person.name ?? ''}" placeholder="Name">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label"> Flat no </label>
                            <input type="text" class="form-control" name="contact_persons[${i}][flat_no]" value="${person.flat_no ?? ''}" placeholder="Flat number">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Number</label>
                            <input type="text" class="form-control" name="contact_persons[${i}][number]" value="${person.number ?? ''}" placeholder="Number">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="contact_persons[${i}][email]" value="${person.email ?? ''}" placeholder="Email">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Amount</label>
                            <div class="input-group"><span class="input-group-text">৳</span>
                                <input type="number" class="form-control" name="contact_persons[${i}][amount]" value="${person.amount ?? ''}" placeholder="Amount" min="0" step="0.01">
                            </div>
                        </div>

                    </div>
                </div>
            `);
        }
    }

    contactPersonInput.addEventListener('input', function() {
        const count = parseInt(this.value) || 0;

        generateContactPersons(count, existingContactPersons);
    });

    document.addEventListener('DOMContentLoaded', function() {
        const count = parseInt(contactPersonInput.value) || 0;

        if (count > 0) {
            generateContactPersons(
                count,
                existingContactPersons
            );
        }
    });
</script>

<script>
    $(document).ready(function() {

        function toggleBuildingFields() {
            if ($('#building_type').val() == '8') {
                $('#totalFlatGroup, #occupiedFlatGroup, #contactPersonGroup').hide();

                $('#total_flat, #occupied_flat, #contact_person')
                    .prop('required', false)
                    .val('');
            } else {
                $('#totalFlatGroup, #occupiedFlatGroup, #contactPersonGroup').show();

                $('#total_flat, #occupied_flat, #contact_person')
                    .prop('required', true);
            }
        }

        // On page load
        toggleBuildingFields();

        // When building type changes
        $('#building_type').on('change', function() {
            toggleBuildingFields();
        });

    });
</script>

@endpush