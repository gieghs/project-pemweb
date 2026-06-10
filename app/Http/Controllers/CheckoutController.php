<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    // === SHIPPING (RAJAONGKIR/KOMERCE V2) ===

    public function getProvinces()
    {
        $response = Http::withHeaders(['key' => env('KOMERCE_SHIPPING_KEY')])
            ->get('https://rajaongkir.komerce.id/api/v1/destination/province');
        return response()->json($response->json());
    }

    public function getCities($province_id)
    {
        $response = Http::withHeaders(['key' => env('KOMERCE_SHIPPING_KEY')])
            ->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$province_id}");
        return response()->json($response->json());
    }

    public function getDistricts($city_id)
    {
        $response = Http::withHeaders(['key' => env('KOMERCE_SHIPPING_KEY')])
            ->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$city_id}");
        return response()->json($response->json());
    }

    public function getShippingCost(Request $request)
    {
        \Log::info('Cek Komerce Payload:', [
            'destination_id_yang_dikirim' => $request->destination_id,
            'courier' => $request->courier
        ]);

        $response = Http::withHeaders(['key' => env('KOMERCE_SHIPPING_KEY')])
            ->asForm()
            ->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'origin' => 55,
                'originType' => 'city',
                'destination' => (int) $request->destination_id,
                'destinationType' => 'subdistrict',
                'weight' => 500,
                'courier' => $request->courier ?? 'jne'
            ]);
            
        return response()->json($response->json());
    }

    // === PAYMENT (MANUAL TRANSFER) ===

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'postal_code' => 'required',
            'shipping_cost' => 'required|numeric',
            'payment_method' => 'required|in:bca,qris'
        ]);

        $cartItems = \App\Models\CartItem::with('product')->where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop')->with('info', 'Keranjang belanja kosong.');
        }

        foreach ($cartItems as $item) {
            if (!$item->product || $item->product->isSold()) {
                $item->delete();
                return redirect()->route('cart.index')->with('error', 'Produk ini sudah terjual.');
            }
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = $item->product->price ?? $item->product->harga ?? 0;
            $qty = $item->quantity ?? $item->qty ?? 1;
            $subtotal += ($price * $qty);
        }
        $grandTotal = $subtotal + $request->shipping_cost;

        $createdOrders = [];
        foreach ($cartItems as $item) {
            $order = auth()->user()->orders()->create([
                'product_id' => $item->product_id,
                'product_name' => $item->product->name ?? $item->product->nama_produk ?? 'Produk',
                'username' => $request->name,
                'price' => ($item->product->price ?? $item->product->harga ?? 0) * ($item->quantity ?? $item->qty ?? 1),
                'payment_method' => $request->payment_method,
                'shipping_cost' => $request->shipping_cost,
                'status' => 'Pending Payment',
                'phone' => $request->phone,
                'address' => $request->address,
                'district' => $request->subdistrict_name,
                'city' => $request->city_name,
                'province' => $request->province_name,
                'postal_code' => $request->postal_code,
            ]);

            \App\Models\CartItem::where('id', $item->id)->delete();
            $createdOrders[] = $order;
        }

        return redirect()->route('checkout.success', ['id' => $createdOrders[0]->id])
            ->with('order_ids', collect($createdOrders)->pluck('id')->toArray());
    }

    public function showSuccess($id)
    {
        $order = \App\Models\Order::with('product')->find($id);

        if (!$order) {
            return redirect()->route('home');
        }

        $orderIds = session('order_ids', []);
        $allOrders = \App\Models\Order::whereIn('id', $orderIds)->with('product')->get();
        $subtotal = $allOrders->sum('price');
        $shippingCost = $allOrders->first()->shipping_cost ?? 0;
        $grandTotal = $subtotal + $shippingCost;

        if (strtolower($order->payment_method) === 'qris') {
            $qrisImage = \App\Models\Setting::where('key', 'qris_image')->first()->value ?? null;
            return view('user.checkout-qris', compact('order', 'subtotal', 'shippingCost', 'grandTotal', 'qrisImage'));
        }

        return view('user.checkout-success', compact('order', 'subtotal', 'shippingCost', 'grandTotal'));
    }
}