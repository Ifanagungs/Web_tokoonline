<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingCost = 10000;
        $total = $subtotal + $shippingCost;

        $user = auth()->user();

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingCost', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:transfer_bank,cod',
            'notes' => 'nullable|string|max:500',
        ]);

        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Validate stock availability
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return back()->with('error', "Stok {$item->product->name} tidak mencukupi. Tersisa {$item->product->stock} item.");
            }
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingCost = 10000;
        $total = $subtotal + $shippingCost;

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'shipping_address' => $request->shipping_address,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'status' => $request->payment_method === 'cod' ? 'processing' : 'pending_payment',
                'notes' => $request->notes,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items');

        return view('checkout.success', compact('order'));
    }
}
