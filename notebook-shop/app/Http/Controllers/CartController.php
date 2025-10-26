<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    /** แสดงตะกร้า */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $total = collect($cart)->sum(fn($row) => $row['price'] * $row['qty']);

        return view('cart.index', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    /** เพิ่มสินค้าเข้าตะกร้า */
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty'        => ['nullable','integer','min:1'],
        ]);

        $qty = $data['qty'] ?? 1;

        $product = Product::with('brand')->findOrFail($data['product_id']);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'id'    => $product->id,
                'name'  => $product->model,
                'brand' => $product->brand?->name,
                'price' => (float) ($product->price ?? 0),
                'qty'   => $qty,
            ];
        }

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('ok', 'เพิ่มลงตะกร้าแล้ว');
    }

    /** ลบสินค้าออกจากตะกร้า */
    public function remove(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return back()->with('ok', 'ลบสินค้าแล้ว');
    }

    /** เพิ่มจำนวนสินค้าในตะกร้า */
    public function increase(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
            $request->session()->put('cart', $cart);
            return back()->with('ok', 'เพิ่มจำนวนแล้ว');
        }

        return back()->with('warn', 'ไม่พบสินค้าในตะกร้า');
    }

    /** ลดจำนวนสินค้าในตะกร้า */
    public function decrease(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);
        
        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] > 1) {
                $cart[$id]['qty']--;
                $request->session()->put('cart', $cart);
                return back()->with('ok', 'ลดจำนวนแล้ว');
            } else {
                unset($cart[$id]);
                $request->session()->put('cart', $cart);
                return back()->with('ok', 'ลบสินค้าออกจากตะกร้าแล้ว');
            }
        }

        return back()->with('warn', 'ไม่พบสินค้าในตะกร้า');
    }

    /** หน้า checkout */
    public function checkoutShow(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warn','ตะกร้าว่าง');
        }

        $total = collect($cart)->sum(fn($row) => $row['price'] * $row['qty']);
        return view('checkout.show', compact('cart','total'));
    }

    /** ยืนยันสั่งซื้อ - บันทึกลงฐานข้อมูล */
    public function checkoutProcess(Request $request)
    {
        $request->validate([
            'address' => ['required','string','max:500'],
        ]);

        $cart = $request->session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warn', 'ตะกร้าว่าง');
        }

        $total = collect($cart)->sum(fn($row) => $row['price'] * $row['qty']);

        // สร้าง Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_no' => 'OD' . now()->format('ymdHis') . rand(100, 999),
            'total' => $total,
            'address' => $request->input('address'),
            'payment_status' => 'paid', // เปลี่ยนเป็น COD
            'order_status' => 'preparing',
            'paid_at' => now(),
        ]);

        // สร้าง Order Items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'brand_name' => $item['brand'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
            ]);
        }

        // ล้างตะกร้า
        $request->session()->forget('cart');

        return redirect()->route('orders.index', $order->id)->with('ok', 'สั่งซื้อสำเร็จ');
    }

    /** แสดงคำสั่งซื้อเดี่ยว */
    public function showOrder(Request $request, $orderId)
    {
        $order = Order::with(['items.product.primaryImage', 'user'])
            ->where('id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('orders.show', ['order' => $order]);
    }

    /** รายการสั่งซื้อทั้งหมดของ User */
    public function ordersIndex(Request $request)
    {
        $orders = Order::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', ['orders' => $orders]);
    }
}