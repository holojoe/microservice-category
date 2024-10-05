<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::post('/categories/comsummer', function(Request $query) {
        Log::info($query);
        return response()->json([
            'message' => 'consumer receive',
            'data' => $query->all()
        ]);
    });
});
