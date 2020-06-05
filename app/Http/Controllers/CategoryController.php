<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function getCategories() {
        $categories = Category::all();
        return response()->json([
            'categories' => $categories
        ]);
    }
}
