<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Transformers\HotelTransformer;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $hotel  = \Auth::user()->hotels()->create($request->all());

        $transformed = \Fractal::item($hotel, new HotelTransformer())->toArray();

        return response()->json($transformed, 201);
    }
}
