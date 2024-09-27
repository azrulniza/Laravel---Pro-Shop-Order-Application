<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ShopController extends Controller
{
    // Show items to purchase
    public function index()
    {
        $items = Item::all();
        return view('index', compact('items'));
    }

    // Store purchase details
    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'mobile_number' => 'required',
                'quantities' => 'required|array',
                'quantities.*' => 'required|integer|min:0',
            ]);


            // Check if the customer already exists based on the email
            $customer = Customer::where('email', $validated['email'])->first();

            if (!$customer) {
                // Create a new user if they don't exist
                $customer = Customer::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'mobile_number' => $validated['mobile_number'],
                ]);
            } else {
                // If the user exists, update their details (if needed)
                $customer->update([
                    'name' => $validated['name'],
                    'mobile_number' => $validated['mobile_number'],
                ]);
            }

            // Create purchase
            $purchase = Purchase::create([
                'customer_id' => $customer->id,
            ]);

            // Attach items to purchase only if quantity is greater than 0
            foreach ($validated['quantities'] as $itemId => $quantity) {

                if ($quantity > 0) {
                    $purchase->items()->attach($itemId, ['quantity' => $quantity]);
                }
            }

            return redirect()->route('show', ['id' => $purchase->id]);
        } catch (Exception $e) {

            Log::error($e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong.']);
        }
    }


    // Show purchase details
    public function show($id)
    {
        // Find the purchase by ID, with customer and items relationship
        $purchase = Purchase::with(['customer', 'items'])->findOrFail($id);

        // Calculate the total price of the purchase
        $totalPrice = $purchase->items->reduce(function ($total, $item) {
            return $total + ($item->pivot->quantity * $item->price);
        }, 0);

        return view('show', compact('purchase', 'totalPrice'));
    }

    // Order List
    public function order()
    {
        // Fetch all purchases with customer and total price calculation
        $purchases = Purchase::with('customer', 'items')
            ->get()
            ->map(function ($purchase) {
                $totalPrice = $purchase->items->sum(function ($item) {
                    return $item->pivot->quantity * $item->price;
                });

                return [
                    'id' => $purchase->id,
                    'customer_name' => $purchase->customer->name,
                    'purchase_date' => $purchase->created_at->format('Y-m-d H:i:s'),
                    'total_price' => $totalPrice,
                ];
            });

        return view('order_list', compact('purchases'));
    }
}
