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

        <form action="{{ route('admin.plot-and-units.store') }}" method="POST" autocomplete="off">
            @csrf

            <div class="row g-3">
                <div class="row g-3">
                    <!-- {{-- Road --}} -->
                    <div class="col-md-4">
                        <label for="road" class="form-label">Road <span class="text-danger">*</span></label>
                        <select class="form-select" id="road" name="road" required>
                            <option value="" selected disabled>Select Road</option>
                            @foreach($roads as $road)
                            <option value="{{$road->id}}">Road {{$road->number}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- {{-- Holding No --}} -->
                    <div class="col-md-4">
                        <label for="holding_no" class="form-label">Holding No. <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="holding_no" name="holding_no" placeholder="e.g. 2" required>
                    </div>

                    <!-- {{-- Plot Type --}} -->
                    <div class="col-md-4">
                        <label for="building_type" class="form-label">Plot Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="building_type" name="building_type" required>
                            <option value="" selected disabled>Select Plot Type</option>
                            @foreach($plot_types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Total Flat -->
                    <div class="col-md-4" id="totalFlatGroup">
                        <label for="total_flat" class="form-label">Total Flat <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="total_flat" name="total_flat" min="0" placeholder="e.g. 12" required>
                    </div>

                    <!-- Occupied Flat -->
                    <div class="col-md-4" id="occupiedFlatGroup">
                        <label for="occupied_flat" class="form-label">Occupied Flat <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="occupied_flat" name="occupied_flat" min="0" placeholder="e.g. 10" required>
                    </div>

                    <!-- Occupied Flat -->
                    <div class="col-md-4" id="BuildingNameGroup">
                        <label for="occupied_flat" class="form-label">Building Name</label>
                        <input type="text" class="form-control" id="building_name" name="building_name" placeholder="Enter building name" required>
                    </div>

                    <!-- {{-- Collection Type --}} -->
                    <div class="col-md-4" id="collectionTypeGroup">
                        <label for="collection_type" class="form-label">Collection Type <span class="text-danger">*</span></label>
                        <select class="form-select" id="collection_type" name="collection_type" required>
                            <option value="">Select Collection Type</option>
                            <option value="Group" {{ old('collection_type') == 'Group' ? 'selected' : '' }}>Group</option>
                            <option value="Individual" {{ old('collection_type') == 'Individual' ? 'selected' : '' }}>Individual</option>
                        </select>
                    </div>

                    <div class="col-md-4" id="personName">
                        <label class="form-label">Contact Person Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control flat-no" name="name" id="person_name" placeholder="Name">
                    </div>

                    <div class="col-md-4" id="personFlatNo">
                        <label class="form-label">Flat no <span class="text-danger">*</span></label>
                        <input type="text" class="form-control flat-no" name="flat_no" id="person_flat_no" placeholder="Flat number">
                    </div>

                    <div class="col-md-4" id="personNumber">
                        <label class="form-label">Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control member-number" name="number" id="person_number" placeholder="Number">
                    </div>

                    <div class="col-md-4" id="personEmail">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control member-email" name="email" id="person_email" placeholder="Email">
                    </div>

                    <!-- {{-- Collection Rate --}} -->
                    <div class="col-md-4" id="collectionRateGroup">
                        <label for="collection_rate" class="form-label">Collection Rate <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" class="form-control" id="collection_rate" name="collection_rate" min="0" step="0.01" placeholder="Enter collection rate" required>
                        </div>
                    </div>

                    <!-- {{-- Discount --}} -->
                    <div class="col-md-4" id="discountGroup">
                        <label for="discount" class="form-label">Discount</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" class="form-control" id="discount" name="discount" min="0" step="0.01" placeholder="Enter discount amount">
                        </div>
                    </div>

                    <!-- {{-- Collection Amount --}} -->
                    <div class="col-md-4" id="collectionAmountGroup">
                        <label for="collection_amount" class="form-label">Collection Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" class="form-control" id="collection_amount" name="collection_amount" min="0" step="0.01" placeholder="Enter collection amount" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="datepicker" class="form-label">Issue Date <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="text" class="form-control" id="datepicker" name="date" placeholder="Select date" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Expired</option>
                        </select>
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
<!-- Calculate Collection Amount Script -->
<script>
    const rates = @json($rates);

    const buildingType = document.getElementById('building_type');
    const collectionType = document.getElementById('collection_type');
    const collectionRate = document.getElementById('collection_rate');
    const occupiedFlat = document.getElementById('occupied_flat');
    const discount = document.getElementById('discount');
    const collectionAmount = document.getElementById('collection_amount');

    function calculateCollectionAmount() {
        if (buildingType.value == '9') {
            const discountValue = parseFloat(discount.value) || 0;
            collectionAmount.value = Math.max(1500 - discountValue, 0);
            return;
        }

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

    collectionType.addEventListener('change', calculateCollectionAmount);

    occupiedFlat.addEventListener('input', calculateCollectionAmount);
    discount.addEventListener('input', calculateCollectionAmount);
</script>

<!-- Field visibility toggle based on building type -->
<script>
    $(document).ready(function() {

        function toggleBuildingFields() {
            let buildingType = $('#building_type').val();

            if (buildingType == '8') {
                $('#totalFlatGroup, #occupiedFlatGroup, #collectionTypeGroup, #collectionRateGroup, #discountGroup, #collectionAmountGroup, #personName, #personFlatNo, #personNumber, #personEmail').hide();

                $('#total_flat, #occupied_flat, #collection_type, #collection_rate, #discount, #collection_amount, #person_name, #person_flat_no, #person_number, #person_email')
                    .prop('required', false)
                    .val('');
            } else if (buildingType == '9') {
                $('#totalFlatGroup, #occupiedFlatGroup, #collectionTypeGroup, #personName, #personFlatNo, #personNumber, #personEmail').hide();

                $('#total_flat, #occupied_flat, #collection_type, #person_name, #person_flat_no, #person_number, #person_email')
                    .prop('required', false)
                    .val('');

                $('#collectionRateGroup, #discountGroup, #collectionAmountGroup, #personName, #personFlatNo, #personNumber, #personEmail').show();

                $('#collection_rate, #collection_amount')
                    .prop('required', true);
            } else {
                $('#totalFlatGroup, #occupiedFlatGroup, #collectionTypeGroup, #collectionRateGroup, #discountGroup, #collectionAmountGroup, #personName, #personFlatNo, #personNumber, #personEmail').show();

                $('#total_flat, #occupied_flat, #collection_type, #collection_rate, #collection_amount, #person_name, #person_flat_no, #person_number, #person_email')
                    .prop('required', true);
            }
        }

        toggleBuildingFields();

        $('#building_type').on('change', function() {
            toggleBuildingFields();
        });

    });
</script>
@endpush