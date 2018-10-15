<?php

namespace App\Http\Controllers\API;

use App\Models\Country;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => Country::getAll()
        ], 200);
    }
}
