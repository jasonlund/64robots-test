<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamilyStoreRequest;
use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FamilyStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FamilyStoreRequest $request)
    {
        $family = Family::create([
            'name' => $request->input('name')
        ]);

        return response()->json([
            'success' => true,
            'data' => $family,
            'message' => ''
        ]);
    }
}
