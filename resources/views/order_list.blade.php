@extends('header')

@section('content')
<div class="container mt-3">
    <h2 class="text-center">Order List</h2>

    <table class="table table-hover table-striped mt-3">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Purchase Date</th>
                <th scope="col">Total Price (RM)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach ($purchases as $index => $purchase)
            <tr onclick="window.location='{{ route('show', $purchase['id']) }}'" style="cursor: pointer;">
                <td>{{ $index + 1 }}</td>
                <td>{{ $purchase['customer_name'] }}</td>
                <td>{{ $purchase['purchase_date'] }}</td>
                <td>{{ number_format($purchase['total_price'], 2) }}</td>
                @php $grandTotal += $purchase['total_price']; @endphp
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Grand Total:</th>
                <th>RM {{ number_format($grandTotal, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</div>
<style>
    .clickable-row {
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .clickable-row:hover {
        background-color: #f1f1f1;
    }
</style>
@endsection