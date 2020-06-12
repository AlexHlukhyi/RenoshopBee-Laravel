<?php

namespace App\Http\Controllers;

use App\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param $userId
     * @return JsonResponse
     */
    public function getProductsByUserId($userId) {
        $products = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->join('colors', 'cart_items.color_id', '=', 'colors.id')
            ->join('sizes', 'cart_items.size_id', '=', 'sizes.id')
            ->select('cart_items.id as id', 'products.name as name', 'products.price as price', 'sizes.name as size', 'colors.name as color', 'cart_items.quantity')
            ->where('cart_items.user_id', $userId)
            ->get();

        return response()->json([
            'products' => $products
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @param $userId
     * @return JsonResponse
     */
    public function add() {
        $item = new CartItem();
        $item->user_id = request('user');
        $item->product_id = request('product');
        $item->quantity = request('quantity');
        $item->size_id = request('size');
        $item->color_id = request('color');
        $item->save();

        return response()->json(['message' => 'Successfully added!']);
    }

    public function remove() {
        $item = CartItem::find(request('id'));
        $item->delete();
        return response()->json(['message' => 'Deleted!']);
    }
}
