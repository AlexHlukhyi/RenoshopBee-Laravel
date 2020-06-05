<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {
    public function getPopularProducts() {
        $products = DB::table('products')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->select('products.id', 'products.name', 'products.price', DB::raw('round(AVG(reviews.mark), 0) as mark'))
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderBy('mark', 'desc')
            ->limit(12)
            ->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function getProductsByName() {
        $products = DB::table('products')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->select('products.id', 'products.name', 'products.price', DB::raw('round(AVG(reviews.mark), 0) as mark'))
            ->groupBy('products.id', 'products.name', 'products.price')
            ->where('products.name','like', '%' . $_GET['q'] . '%')
            ->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function getProductsByCategoryId($id) {
        $products = DB::table('products')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->select('products.id', 'products.name', 'products.price', DB::raw('round(AVG(reviews.mark), 0) as mark'))
            ->groupBy('products.id', 'products.name', 'products.price')
            ->where('products.category_id', $id)
            ->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function getProductById($product_id) {
        $product = Product::with('sizes', 'colors')->find($product_id);
        $reviews = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->where('product_id', $product_id)
            ->select('reviews.id', 'users.name', 'reviews.date', 'reviews.text', 'reviews.mark')
            ->get();
        $relatedProducts = DB::table('products')
            ->select('id', 'name', 'price')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product_id)
            ->limit(4)
            ->get();

        return response()->json([
            'product' => $product,
            'reviews' => $reviews,
            'relatedProducts' => $relatedProducts
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        Product::create($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return Response
     */
    public function edit(Product $product) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
