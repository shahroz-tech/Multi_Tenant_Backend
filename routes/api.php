<?php

use App\Http\Controllers\Api\V1\ActivityLog\ActivityLogController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Comment\CommentController;
use App\Http\Controllers\Api\V1\Project\ProjectController;
use App\Http\Controllers\Api\V1\Stripe\StripeController;
use App\Http\Controllers\Api\V1\Stripe\StripeWebhookController;
use App\Http\Controllers\Api\V1\Task\TaskAssignController;
use App\Http\Controllers\Api\V1\Task\TaskController;
use App\Http\Controllers\Api\V1\Task\TaskFileController;
use App\Http\Controllers\Api\V1\Team\TeamController;
use App\Http\Controllers\Api\V1\User\UserController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    //-----------------------------------------------public routes------------------------------------------------------
    //auth route
    Route::controller(AuthController::class)->prefix('auth')->group(function () {
       Route::post("/login", "login")->name("login");
       Route::post("/register", "register");
    });

    //Stripe webhook
    Route::post('/stripe/webhook', [StripeWebhookController::class,'handle']);

    //--------------------------------------------authenticated routes--------------------------------------------------

    Route::middleware(['auth:sanctum','throttle:user-tier'])->group(function () {
        //auth routes
        Route::controller(AuthController::class)->prefix('auth')->group(function () {
            Route::post("/logout", "logout");
        });

        //users routes
        Route::apiResource('users',UserController::class);
        Route::post('users/{team}/invite', [UserController::class,'invite']);

        //teams routes
        Route::post('/teams/{team}/restore', [TeamController::class, 'restore']);
        Route::apiResource('teams', TeamController::class);

        //Project routes
        Route::post('/projects/{project}/restore', [ProjectController::class, 'restore']);
        Route::apiResource('projects', ProjectController::class);

        //comment routes
        Route::post('/comments/{comment}/restore', [CommentController::class, 'restore']);
        Route::apiResource('comments', CommentController::class);

        //task routes | assign & upload, delete
        Route::get('tasks/search', [TaskController::class, 'search']);
        Route::post('/tasks/{task}/restore', [TaskController::class, 'restore']);
        Route::apiResource('tasks', TaskController::class);
        Route::prefix('/tasks/{task}')->group(function () {
            Route::post('/assign', [TaskAssignController::class, 'assign']);
            Route::post('/files', [TaskFileController::class, 'upload']);
            Route::get('/files', [TaskFileController::class, 'list']);
            Route::delete('/files/{file}', [TaskFileController::class, 'destroy']);
        });

        //ActivityLog routes
        Route::get('/projects/{project}/activity-logs', [ActivityLogController::class, 'index']);

        //Stripe routes
        Route::controller(StripeController::class)->group(function () {
            Route::post('/subscribe', 'subscribe');
            Route::get('/subscription', 'show');
            Route::post('/subscription/cancel', 'cancel');
            Route::post('/subscription/resume', 'resume');
        });

    });
});


