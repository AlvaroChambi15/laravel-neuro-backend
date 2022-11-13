<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\GroupImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            "orden" => "required",
            "tipo" => "required",
            "objeto" => "required"
        ]);

        $content = new Content;

        $content->orden = $request->orden;
        $content->tipo = $request->tipo;
        $content->objeto = $request->objeto;
        $content->tipo_doc = $request->tipo_doc;
        $content->altura = $request->altura;
        $content->anchura = $request->anchura;
        $content->post_id = $request->post_id;
        $content->user_id = $request->user_id;

        $content->save();

        return response()->json(["mensaje" => "Contenido Creado!"], 200);
    }

    public function storePhotoGroup(Request $request)
    {
        // return $request;

        $request->validate([
            // TODO: La descripcion tiene un limite de caracteres
            "orden" => "required",
            "tipo" => "required",
            "objeto1" => "required"
        ]);

        DB::begintransaction();
        try {

            $content = new Content;
            $content->orden = $request->orden;
            $content->tipo = $request->tipo;
            // $content->objeto = null;
            $content->post_id = $request->post_id;
            $content->user_id = $request->user_id;
            $content->save();

            $idContentUlt = $content->id;

            $img1 = new GroupImage;
            $img1->orden = 1;
            $img1->image = $request->objeto1;
            $img1->content_id = $idContentUlt;
            $img1->save();


            $img2 = new GroupImage;
            $img2->orden = 2;
            $img2->image = $request->objeto2;
            $img2->content_id = $idContentUlt;
            $img2->save();



            $img3 = new GroupImage;
            $img3->orden = 3;
            $img3->image = $request->objeto3;
            $img3->content_id = $idContentUlt;
            $img3->save();



            $img4 = new GroupImage;
            $img4->orden = 4;
            $img4->image = $request->objeto4;
            $img4->content_id = $idContentUlt;
            $img4->save();



            $img5 = new GroupImage;
            $img5->orden = 5;
            $img5->image = $request->objeto5;
            $img5->content_id = $idContentUlt;
            $img5->save();



            $img6 = new GroupImage;
            $img6->orden = 6;
            $img6->image = $request->objeto6;
            $img6->content_id = $idContentUlt;
            $img6->save();



            DB::commit();
            return response()->json(["mensaje" => "Grupo de imagenes Creada!"], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["mensaje" => "Ocurrio un problema al registrar el grupo de imagenes!", "error" => $e], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show($post)
    {
        $contents = Content::where("post_id", "=", $post)->with('user')->with('groupImages')->orderBy('orden')->get();
        return response()->json($contents, 200);
    }

    public function showGroupImages($contentId)
    {
        $images = GroupImage::where("content_id", "=", $contentId)->where("image", "!=", null)->orderBy('orden')->get();
        return response()->json($images, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;

        $request->validate([
            "orden" => "required",
        ]);
        // MODIFICAR
        $content = Content::find($request->content_id);

        $content->orden = $request->orden;
        $content->objeto = $request->objeto;
        $content->tipo_doc = $request->tipo_doc;
        $content->altura = $request->altura;
        $content->anchura = $request->anchura;
        $content->save();

        return response()->json(["mensaje" => "ContenidoModificado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $id;
        $content = Content::find($id);

        $eliminacion = $content->delete();

        if ($eliminacion) {
            return response()->json(["mensaje" => "ContenidoEliminado"], 200);
        } else {
            return response()->json(["mensaje" => "AlgoSalioMal!"], 204);
        }
    }
}