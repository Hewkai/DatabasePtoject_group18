<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * แสดงหน้า checkout (ดูตะกร้าก่อนจ่าย)
     */
    public function show(Request $request)
    {
        [$items, $total] = $this->loadCartWithProducts($request);

        return response()->view('checkout.show', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    /**
     * กดสั่งซื้อ -> ทำธุรกรรม (Transaction):
     * - สร้าง Order + OrderItems
     * - หักสต็อกสินค้า
     * - ล้างตะกร้า
     * ถ้าพัง -> rollback อัตโนมัติ
     */
    public function store(Request $request)
    {
        [$items, $total] = $this->loadCartWithProducts($request);

        if (empty($items)) {
            return back()->withErrors(['cart' => 'ตะกร้าว่าง ไม่สามารถชำระเงินได้']);
        }

        DB::transaction(function () use ($request, $items, $total) {
            // ล็อคแถวสินค้าเพื่อกัน race condition
            $productIds = collect($items)->pluck('product.id');
            $locked = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            // ตรวจสต็อกอีกครั้ง
            foreach ($items as $row) {
                $p = $locked[$row['product']->id];
                if ($p->stock < $row['qty']) {
                    abort(400, "สินค้า {$p->model} สต็อกไม่พอ");
                }
            }

            // สร้างออเดอร์
            $order = Order::create([
                'user_id' => $request->user()->id,
                'status'  => 'pending',
                'total'   => $total,
            ]);

            // บันทึกรายการ + หักสต็อก
            foreach ($items as $row) {
                $p = $locked[$row['product']->id];
                $qty = $row['qty'];
                $unit = $row['unit_price'];
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $p->id,
                    'qty'        => $qty,
                    'unit_price' => $unit,
                    'subtotal'   => $unit * $qty,
                ]);

                $p->decrement('stock', $qty);
            }

            // (สมมติยังไม่เชื่อม Payment) ถือว่าชำระสำเร็จ
            $order->update(['status' => 'paid']);

            // ล้างตะกร้า
            $request->session()->forget('cart');
        });

        return redirect()->route('orders.index')->with('ok', 'สั่งซื้อสำเร็จ');
    }

    /**
     * รายการคำสั่งซื้อของฉัน
     */
    public function ordersIndex(Request $request)
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', $request->user()->id)
            ->latest('id')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * อ่านตะกร้าจาก session + เติมรายละเอียดสินค้า
     * session('cart') รูปแบบ: [ product_id => qty, ... ]
     * return: [ [product, qty, unit_price], total ]
     */
    private function loadCartWithProducts(Request $request): array
    {
        $cart = $request->session()->get('cart', []); // ex: [1=>2, 5=>1]
        if (empty($cart)) return [[], 0];

        $products = Product::with('brand','primaryImage')
            ->whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        $items = [];
        $total = 0;
        foreach ($cart as $pid => $qty) {
            $p = $products->get($pid);
            if (!$p) continue;

            // ใช้ price ณ เวลาซื้อ
            $unit = (float) ($p->price ?? 0);
            $items[] = [
                'product'    => $p,
                'qty'        => (int) $qty,
                'unit_price' => $unit,
                'subtotal'   => $unit * (int) $qty,
            ];
            $total += $unit * (int) $qty;
        }
        return [$items, $total];
    }
}
