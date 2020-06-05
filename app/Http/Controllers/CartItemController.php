<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function getProductsInCart() {
        $products = DB::table('cart_items')
            ->join('products', 'cart-items.id', '=', 'reviews.product_id')
            ->select('products.id', 'products.name', 'products.price', DB::raw('round(AVG(reviews.mark), 0) as mark'))
            ->groupBy('products.id', 'products.name', 'products.price')
            ->where('products.category_id', $id)
            ->get();

        return response()->json([
            'products' => $products
        ]);
    }
}
