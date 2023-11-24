<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Tms\GpsRecord as TmsGpsRecord;

class ApiTmsGpsController extends Controller
{
    public function __construct() {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'no_plat' => 'required',
                'merek_mobil' => 'required',
                'latitude' => 'required',
                'longtitude' => 'required',
                'imei' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return response()->json([
                'message' => $messages->first(),
            ], 400);
        }

        return TmsGpsRecord::create($request->all());
    }

    public function show(string $id)
    {
        return TmsGpsRecord::findOrFail($id);
    }
}
