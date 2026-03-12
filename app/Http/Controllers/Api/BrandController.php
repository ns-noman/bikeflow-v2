<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::where('status',1)
                    ->select('id','name','logo')
                    ->orderBy('name')
                    ->get();

        return response()->json([
            'status' => true,
            'data' => $brands
        ]);
    }
}
