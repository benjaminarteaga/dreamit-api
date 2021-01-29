<?php

namespace App\Http\Controllers\Api;

use App\Models\Access;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Block;

class AccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Access::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $person = Person::firstOrCreate(
            [
                'rut' => $request->rut,
                'person_role_id' => $request->person_role_id
            ],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name
            ]
        );

        $block = Block::where([
            'person_id' => $person->id,
            'building_id' => $request->building_id
        ]);

        if($block->exists()) {
            $access = Access::create([
                'person_id' => $person->id,
                'building_id' => $request->building_id,
                'access_type_id' => $request->access_type_id,
                'blocked' => 1,
            ]);

            return response()->json([
                'message' => 'Esta persona tiene un bloqueo activo.',
                'block' => $block->first(),
                'access' => $access,
            ], 422);
        }

        $access = Access::create([
            'person_id' => $person->id,
            'building_id' => $request->building_id,
            'access_type_id' => $request->access_type_id
        ]);

        return response()->json([
                'message' => 'Acceso registrado.',
                'access' => $access
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Access  $access
     * @return \Illuminate\Http\Response
     */
    public function show(Access $access)
    {
        return response()->json($access);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Access  $access
     * @return \Illuminate\Http\Response
     */
    public function edit(Access $access)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Access  $access
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Access $access)
    {
        $access->update([
            'person_id' => $request->person_id,
            'building_id' => $request->building_id,
            'access_type_id' => $request->access_type_id
        ]);
        return response()->json([
            'message' => 'Registro de acceso actualizado exitosamente.',
            'access' => $access
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Access  $access
     * @return \Illuminate\Http\Response
     */
    public function destroy(Access $access)
    {
        $access->delete();
        return response()->json(['message' => 'Registro de acceso eliminadao.']);
    }
}
