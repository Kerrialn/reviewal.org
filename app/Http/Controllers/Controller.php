<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\General;
use App\Models\Rating;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $address = Address::firstOrNew([
                'premise'  => $request->address['premise'],
                'floor'  => $request->address['floor'],
                'line_one'  => strtolower($request->address['line_one']),
                'city'  => strtolower($request->address['city']),
                'postal_code'  => strtolower($request->address['postal_code']),
                'country_code' => strtolower($request->address['country_code']),
            ]);
            $address->save();

            $isReviewed = Review::where([
                'user_id' => $user->id,
                'address_id' => $address->id
            ])->exists();

            if ($isReviewed) {
                abort(400, 'already done');
            }

            $review = Review::create([
                'title' => $request->review['title'],
                'summary' => $request->review["summary"],
                'address_id' => $address->id,
                'user_id' => $user->id
            ]);
            $review->save();

            $rating = Rating::create([
                "landlord" =>  $request->rating["landlord"],
                "premise" =>  $request->rating["premise"],
                "area" =>  $request->rating["area"],
                "transport" =>  $request->rating["transport"],
                "noise" =>  $request->rating["noise"],
                "overall" => ($request->rating["landlord"] + $request->rating["premise"] + $request->rating["area"] + $request->rating["transport"] + $request->rating["noise"]) / 5,
                'review_id' => $review->id
            ]);
            $rating->save();
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms(Request $request)
    {
        $terms = General::where('locale', '=', 'en')->get();
        return response($terms);
    }
}
