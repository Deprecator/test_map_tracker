<?php

namespace App\Http\Controllers\API;

use App\Models\City;
use App\Models\ClientTracking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string $clientID
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, string $clientID = '')
    {
        $coordinateList = [];
        $statusCode = 400;

        if($clientID !== '') {
            $coordinateList = ClientTracking::getClientPathChain((int)$clientID, $request->get('dateFrom', date('Y-m-d')), $request->get('dateTo', date('Y-m-d')));
            $statusCode = 200;
        }
        
        return response()->json([
            'data' => $coordinateList
        ], $statusCode);
    }
}
