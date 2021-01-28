<?php

namespace App\Http\Controllers\Api;

use App\Models\Block;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Block::all();
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
        $block = Block::where([
            'person_id' => $request->person_id,
            'building_id' => $request->building_id
        ]);

        if($block->exists()) {
            return response()->json([
                'message' => 'Bloqueo registrado previamente',
                'block' => $block->first()
            ]);
        }

        Block::create([
            'person_id' => $request->person_id,
            'building_id' => $request->building_id
        ]);

        return response(['message' => 'Bloqueo registrado.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Block $block)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Block $block)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        Block::delete();
        return response()->json(['message' => 'Bloqueo eliminadao.']);
    }
}
