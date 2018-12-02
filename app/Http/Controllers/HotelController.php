<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Http\Requests\CreateHotelRequest;
use App\Responses\Responder;
use App\Transformers\HotelTransformer;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * @var Responder
     */
    private $responder;

    public function __construct(Responder $responder)
    {
        $this->middleware(['auth']);
        $this->responder = $responder;
    }

    /**
     * @param CreateHotelRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateHotelRequest $request)
    {
        $hotel  = \Auth::user()->hotels()->create($request->all());

        $transformed = \Fractal::item($hotel, new HotelTransformer())->toArray();

        return $this->responder->setStatus(201)->respond($transformed);
    }
}
