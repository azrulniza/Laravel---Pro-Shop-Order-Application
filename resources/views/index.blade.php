@extends('header')

@section('content')
<div class="container mt-3">

    <h2 class="text-center">Purchase Items</h2>

    <form id="purchaseForm" action="/purchase" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
            <label for="mobile_number" class="form-label">Mobile:</label>
            <input type="number" name="mobile_number" class="form-control" id="mobile_number" required>
        </div>

        <h3>Items</h3>
        @foreach($items as $item)
        <div class="mb-3 d-flex align-items-center">
            <label for="item-{{ $item->id }}" class="flex-grow-1">{{ $item->name }} (RM{{ number_format($item->price, 2) }})</label>
            <div class="input-group" style="width: 150px;">
                <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity('minus', '{{ $item->id }}')">-</button>
                <input type="number" name="quantities[{{ $item->id }}]" value="0" min="0" class="form-control text-center quantity-input" id="quantity-{{ $item->id }}" readonly>
                <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity('plus', '{{ $item->id }}')">+</button>
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-block btn-primary mt-1">Purchase</button>
        </div>

    </form>
</div>

<script>
    function changeQuantity(action, itemId) {
        const quantityInput = document.getElementById(`quantity-${itemId}`);
        let quantity = parseInt(quantityInput.value);

        if (action === 'plus') {
            quantity++;
        } else if (action === 'minus' && quantity > 0) {
            quantity--;
        }

        quantityInput.value = quantity;
    }

    // Validate that at least one item has a quantity greater than 0
    document.getElementById('purchaseForm').addEventListener('submit', function(event) {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        let hasValidQuantity = false;

        quantityInputs.forEach(input => {
            if (parseInt(input.value) > 0) {
                hasValidQuantity = true;
            }
        });

        if (!hasValidQuantity) {
            event.preventDefault(); // Prevent form submission
            alert('Please select at least one item with a quantity of 1 or more.');
        }
    });
</script>
@endsection