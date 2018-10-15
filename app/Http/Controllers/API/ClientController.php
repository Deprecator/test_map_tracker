<?php

namespace App\Http\Controllers\API;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string $cityID
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, string $cityID = '') {
        return response()->json([
            'data' => Client::getAll((int)$cityID, true)
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return response()->json([
            'data' => Client::find($id)
        ], 200);
    }
}
