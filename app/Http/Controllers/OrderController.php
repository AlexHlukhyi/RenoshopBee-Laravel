<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {
    public function add() {
        $order = new Order();
        $order->user_id = request('user_id');
        $order->country = request('country');
        $order->city = request('city');
        $order->postcode = request('postcode');
        $order->address = request('address');
        $order->save();

        $products = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->join('colors', 'cart_items.color_id', '=', 'colors.id')
            ->join('sizes', 'cart_items.size_id', '=', 'sizes.id')
            ->select('products.name as name', 'products.price as price', 'sizes.name as size', 'colors.name as color', 'cart_items.quantity as quantity')
            ->where('cart_items.user_id', request('user_id'))
            ->get();

        foreach ($products as $product) {
            DB::table('order_items')
                ->insert([
                    'order_id' => $order->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'product_size' => $product->size,
                    'product_color' => $product->color,
                    'quantity' => $product->quantity
                ]);
        }

        DB::table('cart_items')
            ->where('cart_items.user_id', request('user_id'))
            ->delete();
    }
}
