<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::get();
        return response()->json($units, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            // TODO: La descripcion tiene un limite de caracteres
            "numero" => "required|unique:units",
            "titulo" => "required|unique:units"
            // "descripcion" => "max"
        ]);

        $ut = new Unit;

        $ut->numero = $request->numero;
        $ut->titulo = $request->titulo;
        $ut->descripcion = $request->descripcion;
        $ut->portada = $request->portada;
        $ut->user_id = $request->userId;

        $ut->save();

        return response()->json(["mensaje" => "Unidad Tematica Creada!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show($num)
    {
        // return $num;
        // $unit = Unit::find($num); //POR ID
        $unit = Unit::where("numero", "=", $num)->first();  //POR NUM
        return response()->json($unit, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        $request->validate([
            // "titulo" => "required|unique:posts,titulo", $id,
            // "titulo" => "required|unique:posts,titulo, $id",
            "numero" => "required",
            'titulo' => [
                'required',
                Rule::unique('posts', 'titulo')->ignore($id)
            ],
            "portada" => "required"
        ]);
        // MODIFICAR
        $unit = Unit::find($id);

        $unit->numero = $request->numero;
        $unit->titulo = $request->titulo;
        $unit->portada = $request->portada;
        $unit->save();

        return response()->json(["mensaje" => "UnitModificado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        //
    }
}