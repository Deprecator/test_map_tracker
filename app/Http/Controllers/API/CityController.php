<?php

namespace App\Http\Controllers\API;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, string $countryID = '')
    {
        return response()->json([
            'data' => City::getAll((int)$countryID)
        ], 200);
    }
}
