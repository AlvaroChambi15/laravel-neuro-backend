<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $request->validate([
            "orden" => "required",
            "palabra" => "required"
        ]);

        $keyWord = new Keyword;

        $keyWord->orden = $request->orden;
        $keyWord->palabra = $request->palabra;
        $keyWord->post_id = $request->post_id;
        $keyWord->user_id = $request->user_id;

        $keyWord->save();

        return response()->json(["mensaje" => "Palabra Clave Agragada!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function show($postId)
    {
        $KeyWords = Keyword::where("post_id", $postId)->with('user')->orderBy('orden')->get();
        return response()->json($KeyWords, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Keyword $keyword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function destroy(Keyword $keyword)
    {
        //
    }
}