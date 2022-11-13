<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
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
            "titulo" => "required",
            "link" => "required"
        ]);

        $feedback = new Feedback;

        $feedback->orden = $request->orden;
        $feedback->titulo = $request->titulo;
        $feedback->link = $request->link;
        $feedback->post_id = $request->post_id;
        $feedback->user_id = $request->user_id;

        $feedback->save();

        return response()->json(["mensaje" => "Feedback Agragado!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show($postId)
    {
        $feedbacks = Feedback::where("post_id", $postId)->with('user')->orderBy('orden')->get();
        return response()->json($feedbacks, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}