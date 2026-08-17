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
            <h3>Add Building / Unit</h3>
        </div>

        <form action="{{ route('admin.plot-and-units.store') }}" method="POST">
            @csrf

            <div class="row g-3">

                <!-- {{-- Road --}} -->
                <div class="col-md-4">
                    <label for="road" class="form-label">Road <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="road" name="road" placeholder="e.g. 1/A" required>
                </div>

                <!-- {{-- Holding No --}} -->
                <div class="col-md-4">
                    <label for="holding_no" class="form-label">Holding No. <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="holding_no" name="holding_no" placeholder="e.g. 2" required>
                </div>

                <!-- {{-- Building Type --}} -->
                <div class="col-md-4">
                    <label for="building_type" class="form-label">Building Type <span class="text-danger">*</span></label>
                    <select class="form-select" id="building_type" name="building_type" required>
                        <option value="" selected disabled>Select Building Type</option>
                        @foreach($plot_types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- {{-- Total Flat --}} -->
                <div class="col-md-4">
                    <label for="total_flat" class="form-label">Total Flat <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="total_flat" name="total_flat" min="0" placeholder="e.g. 12" required>
                </div>

                <!-- {{-- Occupied Flat --}} -->
                <div class="col-md-4">
                    <label for="occupied_flat" class="form-label">Occupied Flat <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="occupied_flat" name="occupied_flat" min="0" placeholder="e.g. 10" required>
                </div>

                <!-- {{-- Collection Type --}} -->
                <div class="col-md-4">
                    <label for="collection_type" class="form-label">Collection Type <span class="text-danger">*</span></label>
                    <select class="form-select" id="collection_type" name="collection_type" required>
                        <option value="">Select Collection Type</option>
                        <option value="Group" {{ old('collection_type') == 'Group' ? 'selected' : '' }}>Group</option>
                        <option value="Individual" {{ old('collection_type') == 'Individual' ? 'selected' : '' }}>Individual</option>
                    </select>
                </div>

                <!-- {{-- Contact Person --}} -->
                <div class="col-md-4">
                    <label for="contact_person" class="form-label">Contact Person<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="contact_person" name="contact_person" min="0" placeholder="Number of contact persons">
                </div>

                <!-- {{-- Collection Rate --}} -->
                <div class="col-md-4">
                    <label for="collection_rate" class="form-label">Collection Rate <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">৳</span>
                        <input type="number" class="form-control" id="collection_rate" name="collection_rate" min="0" step="0.01" placeholder="250" required>
                    </div>
                </div>

                <!-- {{-- Discount --}} -->
                <div class="col-md-4">
                    <label for="discount" class="form-label">Discount</label>
                    <div class="input-group">
                        <span class="input-group-text">৳</span>
                        <input type="number" class="form-control" id="discount" name="discount" min="0" step="0.01" placeholder="500">
                    </div>
                </div>

                <!-- {{-- Collection Amount --}} -->
                <div class="col-md-4">
                    <label for="collection_amount" class="form-label">Collection Amount <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">৳</span>
                        <input type="number" class="form-control" id="collection_amount" name="collection_amount" min="0" step="0.01" placeholder="2500" required>
                    </div>
                </div>

                <!-- {{-- Dynamic Contact Persons --}} -->
                <div class="col-12">
                    <div id="contactPersonsContainer"></div>
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Building</button>
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

    buildingType.addEventListener('change', function () {
        collectionRate.value = rates[this.value] || 0;

        calculateCollectionAmount();
    });

    occupiedFlat.addEventListener('input', calculateCollectionAmount);

    discount.addEventListener('input', calculateCollectionAmount);
</script>

<script>
    document.getElementById('contact_person').addEventListener('input', function() {

        const count = parseInt(this.value) || 0;
        const container = document.getElementById('contactPersonsContainer');

        container.innerHTML = '';

        for (let i = 0; i < count; i++) {

            container.insertAdjacentHTML('beforeend', `
                <div class="contact-person-group border rounded p-3 mb-3">

                    <h6 class="mb-3"> Contact Person ${i + 1} </h6>

                    <div class="row g-3">

                        <div class="col-md-3">
                            <label class="form-label"> Name </label>
                            <input type="text" class="form-control" name="contact_persons[${i}][name]" placeholder="Name">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"> Number </label>
                            <input type="text" class="form-control" name="contact_persons[${i}][number]" placeholder="Number">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"> Email </label>
                            <input type="email" class="form-control" name="contact_persons[${i}][email]" placeholder="Email">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"> Amount </label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="number" class="form-control" name="contact_persons[${i}][amount]" placeholder="Amount" min="0" step="0.01">
                            </div>
                        </div>

                    </div>

                </div>
            `);
        }
    });

    // Re-create contact fields after validation error
    document.addEventListener('DOMContentLoaded', function() {

        const contactPerson = document.getElementById('contact_person');

        if (contactPerson && contactPerson.value) {
            contactPerson.dispatchEvent(new Event('input'));
        }

    });
</script>

@endpush