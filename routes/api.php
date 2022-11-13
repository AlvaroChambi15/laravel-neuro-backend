<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UnitController;
use App\Models\Feedback;
use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('ut', [UnitController::class, "index"]);
Route::get('showUt/{num}', [UnitController::class, "show"]);

// Route::get('pst', [PostController::class, "index"]);
Route::get('pst/{num}', [PostController::class, "show"]);

Route::get('pst/{num}/{ut}', [PostController::class, "showPost"]);

Route::get('contents/{post}', [ContentController::class, "show"]);

Route::post('contents', [ContentController::class, "storePhotoGroup"]);

Route::get('contentsGI/{contentId}', [ContentController::class, "showGroupImages"]);

Route::get('keyWords/{postId}', [KeywordController::class, "show"]);

Route::get('feedbacks/{postId}', [FeedbackController::class, "show"]);

Route::get('coments/{postId}', [ComentController::class, "show"]);



// =========================================================

Route::prefix("v1/auth")->group(function () {

    Route::post('/login', [AuthController::class, "login"]);
    Route::post('/registro', [AuthController::class, "registro"]);

    Route::post('phoUser', [AuthController::class, "updatePhotoUser"]);
    Route::post('namesUser', [AuthController::class, "updateNameUser"]);
    Route::post('emailUser', [AuthController::class, "updateEmailUser"]);
    Route::post('passUser', [AuthController::class, "updatePasslUser"]);

    Route::middleware("auth:sanctum")->group(function () {

        Route::post('/logout', [AuthController::class, "logout"]);
        Route::get('/perfil', [AuthController::class, "perfil"]);
    });
});



Route::middleware("auth:sanctum")->group(function () {

    Route::apiResource("unit", UnitController::class);
    Route::apiResource("post", PostController::class);
    Route::apiResource("content", ContentController::class);
    Route::apiResource("keyWord", KeywordController::class);
    Route::apiResource("feedback", FeedbackController::class);
    Route::apiResource("coment", ComentController::class);
    Route::apiResource("like", LikeController::class);
});




Route::get("/no_autorizado", function () {
    return response()->json(["mensaje" => "NO ESTAS AUTORIZADO PARA VER ESTA PAGINA!"]);
})->name("login");