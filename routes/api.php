<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\FriendsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// routes/api.php

Route::prefix('v1')->group(function(){
    
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);






    

    Route::post('/send-request/{receiverId}', [FriendsController::class, 'sendFriendRequest'])->middleware('auth:sanctum');
    Route::post('/accept-request/{senderId}', [FriendsController::class, 'acceptFriendRequest'])->middleware('auth:sanctum');
    Route::post('/reject-request/{senderId}', [FriendsController::class, 'rejectFriendRequest'])->middleware('auth:sanctum');
    Route::get('/list/{user}', [FriendsController::class, 'getFriendsList'])->middleware('auth:sanctum');
});

// routes/api.php

// use App\Http\Controllers\FriendController;

// Route::middleware('auth:sanctum')->group(function () {
//     Route::prefix('v1')->group(function () {
        
//     });
// });
