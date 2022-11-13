<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user')->get();
        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            // TODO: La descripcion tiene un limite de caracteres
            "numero" => "required",
            "titulo" => "required|unique:posts,titulo"
            // "descripcion" => "max"
        ]);


        $p = Post::where('numero', $request->numero)->where('unit_Id', $request->numId)->first();

        if (!$p) {

            $post = new Post;

            $post->numero = $request->numero;
            $post->titulo = $request->titulo;
            $post->portada = $request->portada;
            $post->unit_id = $request->unitId;
            $post->user_id = $request->userId;

            $post->save();

            return response()->json(["mensaje" => "Unidad Tematica Creada!"], 200);

            // return response()->json(["mensaje" => "Unidad Tematica Creada! ", "datos" => $request], 200);
        } else {
            return response()->json(["mensaje" => "La unidad tematica " . $request->numero .  " ya existe!"], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($num)
    {
        // $unit = Unit::where("numero", "=", $num)->first();  //POR NUM

        $posts = Post::where("unit_id", "=", $num)->with('user')->with('contents')->get();
        return response()->json($posts, 200);
    }

    public function showPost($num, $ut)
    {
        $idUt = Unit::select('id')->where('numero', $ut)->first();

        $post = Post::where("unit_id", $idUt->id)->where('numero', $num)->with('user')->first();

        return response()->json($post, 200);

        // $posts = Post::where("unit_id", "=", $num)->with('user')->get();

        // return response()->json(["mensaje" => "HOLIS COMO ESTAS 2"], 200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        // return $request;
        $request->validate([
            // "titulo" => "required|unique:posts,titulo", $id,
            // "titulo" => "required|unique:posts,titulo, $id",
            'titulo' => [
                'required',
                Rule::unique('posts', 'titulo')->ignore($id)
            ],
            "showPortada" => "required",
            "portada" => "required"
        ]);
        // MODIFICAR
        $post = Post::find($id);

        $post->titulo = $request->titulo;
        $post->portada = $request->portada;
        $post->showPortada = $request->showPortada;
        $post->save();

        return response()->json(["mensaje" => "Post Modificado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}