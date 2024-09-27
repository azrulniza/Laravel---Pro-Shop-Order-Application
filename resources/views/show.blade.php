@extends('header')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Purchase Details</h2>

    <!-- Customer Information -->
    <div class="card mb-4">
        <div class="card-header">Customer Information</div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $purchase->customer->name }}</p>
            <p><strong>Email:</strong> {{ $purchase->customer->email }}</p>
            <p><strong>Mobile Number:</strong> {{ $purchase->customer->mobile_number }}</p>
        </div>
    </div>

    <!-- Purchased Items -->
    <h4>Purchased Items</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Price (RM)</th>
                <th>Quantity</th>
                <th>Subtotal (RM)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchase->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ $item->pivot->quantity }}</td>
                <td>{{ number_format($item->pivot->quantity * $item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total Price (RM):</th>
                <th>{{ number_format($totalPrice, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <!-- Back to Home Button -->
    <div class="d-flex justify-content-center">
        <a href="/" class="btn btn-primary mt-3">Back to Home</a>
    </div>
</div>
@endsection