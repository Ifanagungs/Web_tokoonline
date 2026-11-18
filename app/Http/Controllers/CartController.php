<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product.category')
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingCost = $cartItems->count() > 0 ? 10000 : 0; // Flat rate Rp 10.000
        $total = $subtotal + $shippingCost;

        return view('cart.index', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < ($request->quantity ?? 1)) {
            return response()->json(['message' => 'Stok tidak mencukupi'], 422);
        }

        $cart = Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
            ],
            []
        );

        // If item already existed, increment quantity
        if (!$cart->wasRecentlyCreated) {
            $newQty = $cart->quantity + ($request->quantity ?? 1);
            if ($newQty > $product->stock) {
                return response()->json(['message' => 'Stok tidak mencukupi'], 422);
            }
            $cart->update(['quantity' => $newQty]);
        } else {
            $cart->update(['quantity' => $request->quantity ?? 1]);
        }

        $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');

        return response()->json([
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cartCount' => $cartCount,
        ]);
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = $cart->product;
        if ($request->quantity > $product->stock) {
            return response()->json(['message' => 'Stok tidak mencukupi'], 422);
        }

        $cart->update(['quantity' => $request->quantity]);

        $subtotal = $cart->product->price * $cart->quantity;
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $cartSubtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingCost = 10000;
        $cartTotal = $cartSubtotal + $shippingCost;
        $cartCount = $cartItems->sum('quantity');

        return response()->json([
            'message' => 'Jumlah berhasil diperbarui',
            'itemSubtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
            'cartSubtotal' => 'Rp ' . number_format($cartSubtotal, 0, ',', '.'),
            'cartTotal' => 'Rp ' . number_format($cartTotal, 0, ',', '.'),
            'cartCount' => $cartCount,
        ]);
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        $cartSubtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingCost = $cartItems->count() > 0 ? 10000 : 0;
        $cartTotal = $cartSubtotal + $shippingCost;
        $cartCount = $cartItems->sum('quantity');

        return response()->json([
            'message' => 'Produk dihapus dari keranjang',
            'cartSubtotal' => 'Rp ' . number_format($cartSubtotal, 0, ',', '.'),
            'cartTotal' => 'Rp ' . number_format($cartTotal, 0, ',', '.'),
            'cartCount' => $cartCount,
            'isEmpty' => $cartItems->count() === 0,
        ]);
    }
}
