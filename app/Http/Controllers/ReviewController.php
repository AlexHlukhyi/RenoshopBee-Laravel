<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {
    public function add() {
        $review = new Review();
        $review->user_id = request('user');
        $review->product_id = request('product');
        $review->text = request('text');
        $review->mark = request('mark');
        $review->save();

        return response()->json(['message' => 'Successfully added!']);
    }
}
