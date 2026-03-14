<?php

namespace App\Http\Controllers\Api;

use App\Models\Bike;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    public function index(Request $request)
    {
        $bikes = Bike::select('*')
                    ->get();

        return response()->json([
            'status' => true,
            'data' => $request->all(),
        ]);
    }
}
