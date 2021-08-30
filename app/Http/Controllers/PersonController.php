<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonStoreRequest;
use App\Http\Requests\PersonUpdateRequest;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PersonStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonStoreRequest $request)
    {
        $person = Person::create([
            'name' => $request->input('name')
        ]);

        return response()->json([
            'success' => true,
            'data' => $person,
            'message' => ''
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'person' => $person,
                'family_tree' => $person->relatives->groupBy('relationship')
            ],
            'message' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PersonUpdateRequest  $request
     * @param  Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(PersonUpdateRequest $request, Person $person)
    {
        $person->update([
            'name' => $request->input('name'),
            'family_id' => $request->input('family_id'),
            'relationship' => $request->input('relationship')
        ]);

        return response()->json([
            'success' => true,
            'data' => $person,
            'message' => ''
        ]);
    }
}
