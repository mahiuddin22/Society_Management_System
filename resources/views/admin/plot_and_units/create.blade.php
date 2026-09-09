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
                            <option value="{{$road->id}}">{{$road->name}}</option>
                            @endforeach
                        </select>
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
                </div>
                <!-- Total Flat -->
                <div id="inputGroup" class="row g-3">
                    <div class="col-md-4" id="totalFlatGroup">
                        <label for="total_flat" class="form-label">Total Flat <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="total_flat" name="total_flat" min="0" placeholder="e.g. 12" required>
                    </div>

                    <!-- Occupied Flat -->
                    <div class="col-md-4" id="occupiedFlatGroup">
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

                    <!-- Contact Person -->
                    <div class="col-md-4" id="contactPersonGroup">
                        <label for="contact_person" class="form-label">Contact Person<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="contact_person" name="contact_person" min="0" placeholder="Number of contact persons">
                    </div>

                    <!-- {{-- Collection Rate --}} -->
                    <div class="col-md-4">
                        <label for="collection_rate" class="form-label">Collection Rate <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" class="form-control" id="collection_rate" name="collection_rate" min="0" step="0.01" placeholder="Enter collection rate" required>
                        </div>
                    </div>

                    <!-- {{-- Discount --}} -->
                    <div class="col-md-4">
                        <label for="discount" class="form-label">Discount</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" class="form-control" id="discount" name="discount" min="0" step="0.01" placeholder="Enter discount amount">
                        </div>
                    </div>

                    <!-- {{-- Collection Amount --}} -->
                    <div class="col-md-4">
                        <label for="collection_amount" class="form-label">Collection Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" class="form-control" id="collection_amount" name="collection_amount" min="0" step="0.01" placeholder="Enter collection amount" required>
                        </div>
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

    buildingType.addEventListener('change', function() {
        collectionRate.value = rates[this.value] || 0;
        calculateCollectionAmount();
    });

    occupiedFlat.addEventListener('input', calculateCollectionAmount);
    discount.addEventListener('input', calculateCollectionAmount);
</script>

<script>
    // ==========================================================
    // Generate Contact Person Fields
    // ==========================================================

    document.getElementById('contact_person').addEventListener('input', function() {

        const count = parseInt(this.value) || 0;
        const container = document.getElementById('contactPersonsContainer');

        container.innerHTML = '';

        for (let i = 0; i < count; i++) {

            container.insertAdjacentHTML('beforeend', `
                <div class="contact-person-group border rounded p-3 mb-3">

                    <h6 class="mb-3">Contact Person ${i + 1}</h6>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Name</label>

                            <select
                                class="form-select member-select"
                                name="contact_persons[${i}][member_id]"
                            >
                                <option value="" disabled selected>
                                    Select Member
                                </option>

                                @foreach($members as $member)
                                    <option value="{{ $member->id }}">
                                        {{ $member->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Flat no</label>

                            <input
                                type="text"
                                class="form-control flat-no"
                                name="contact_persons[${i}][flat_no]"
                                placeholder="Flat number"
                            >
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Number</label>

                            <input
                                type="text"
                                class="form-control member-number"
                                name="contact_persons[${i}][number]"
                                placeholder="Number"
                            >
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Email</label>

                            <input
                                type="email"
                                class="form-control member-email"
                                name="contact_persons[${i}][email]"
                                placeholder="Email"
                            >
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Amount</label>

                            <div class="input-group">
                                <span class="input-group-text">৳</span>

                                <input
                                    type="number"
                                    class="form-control"
                                    name="contact_persons[${i}][amount]"
                                    placeholder="Amount"
                                    min="0"
                                    step="0.01"
                                >
                            </div>
                        </div>

                    </div>

                </div>
            `);
        }
    });


    // ==========================================================
    // Load Member Details using AJAX
    // ==========================================================

    document.addEventListener('change', function(e) {

        if (!e.target.classList.contains('member-select')) {
            return;
        }

        const select = e.target;
        const memberId = select.value;

        console.log('Selected Member ID:', memberId);

        const group = select.closest('.contact-person-group');

        if (!group) {
            console.error('Contact person group not found.');
            return;
        }

        const flatNo = group.querySelector('.flat-no');
        const number = group.querySelector('.member-number');
        const email = group.querySelector('.member-email');

        console.log('Fields found:', {
            flatNo: flatNo,
            number: number,
            email: email
        });

        if (!memberId) {
            flatNo.value = '';
            number.value = '';
            email.value = '';
            return;
        }

        // Generate Laravel URL
        const url = `{{ route('admin.ajax.memberdetails', ['id' => '__ID__']) }}`
            .replace('__ID__', memberId);

        console.log('AJAX URL:', url);

        fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {

                console.log('Response status:', response.status);

                if (!response.ok) {
                    throw new Error(
                        `HTTP ${response.status}: Failed to load member details.`
                    );
                }

                return response.json();
            })
            .then(data => {

                console.log('AJAX response:', data);

                if (data.success) {

                    flatNo.value = data.flat_no ?? '';
                    number.value = data.number ?? '';
                    email.value = data.email ?? '';

                } else {

                    flatNo.value = '';
                    number.value = '';
                    email.value = '';

                    console.error(data.message ?? 'Member not found.');
                }
            })
            .catch(error => {

                console.error('AJAX Error:', error);

                flatNo.value = '';
                number.value = '';
                email.value = '';

            });

    });


    // ==========================================================
    // Re-create Contact Fields after Validation Error
    // ==========================================================

    document.addEventListener('DOMContentLoaded', function() {

        const contactPerson = document.getElementById('contact_person');

        if (contactPerson && contactPerson.value) {

            contactPerson.dispatchEvent(new Event('input'));

        }

    });
</script>

<script>
    $(document).ready(function() {

        function toggleBuildingFields() {
            if ($('#building_type').val() == '8') {
                $('#inputGroup').hide();

                $('#total_flat, #occupied_flat, #collection_type, #collection_rate, #collection_amount, #contact_person')
                    .prop('required', false)
                    .val('');
            } else {
                $('#inputGroup').show();

                $('#total_flat, #occupied_flat, #collection_type, #collection_rate, #collection_amount, #contact_person')
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