<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\TrackingController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\CollectionItemController;
use App\Http\Controllers\Admin\CollectionViewController;
use App\Http\Controllers\Admin\FilesOmniController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserProjectController;
use App\Http\Controllers\Admin\QrcodeController;
use App\Http\Controllers\Admin\ShortLinkController;
use App\Http\Controllers\Admin\SiteZenController;
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



Route::prefix('admin')->group(function () {
    // Rotas para Users
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'delete']);

    // Rotas para Tasks
    Route::get('tasks', [TaskController::class, 'index']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::get('tasks/{id}', [TaskController::class, 'show']);
    Route::put('tasks/{id}', [TaskController::class, 'update']);
    Route::delete('tasks/{id}', [TaskController::class, 'delete']);

    // Rotas para Clients
    Route::get('clients', [ClientController::class, 'index']);
    Route::post('clients', [ClientController::class, 'store']);
    Route::get('clients/{id}', [ClientController::class, 'show']);
    Route::put('clients/{id}', [ClientController::class, 'update']);
    Route::delete('clients/{id}', [ClientController::class, 'delete']);

    // Rotas para Campaigns
    Route::get('campaigns', [CampaignController::class, 'index']);
    Route::post('campaigns', [CampaignController::class, 'store']);
    Route::get('campaigns/{id}', [CampaignController::class, 'show']);
    Route::put('campaigns/{id}', [CampaignController::class, 'update']);
    Route::delete('campaigns/{id}', [CampaignController::class, 'delete']);
    
    // Rotas para Trackings
    Route::get('trackings', [TrackingController::class, 'index']);
    Route::post('trackings', [TrackingController::class, 'store']);
    Route::get('trackings/{id}', [TrackingController::class, 'show']);
    Route::put('trackings/{id}', [TrackingController::class, 'update']);
    Route::delete('trackings/{id}', [TrackingController::class, 'delete']);

    // Rotas para Collections
    Route::get('collections', [CollectionController::class, 'index']);
    Route::post('collections', [CollectionController::class, 'store']);
    Route::get('collections/{id}', [CollectionController::class, 'show']);
    Route::put('collections/{id}', [CollectionController::class, 'update']);
    Route::delete('collections/{id}', [CollectionController::class, 'delete']);

    // Rotas para Collection Items
    Route::get('collection-items', [CollectionItemController::class, 'index']);
    Route::post('collection-items', [CollectionItemController::class, 'store']);
    Route::get('collection-items/{id}', [CollectionItemController::class, 'show']);
    Route::put('collection-items/{id}', [CollectionItemController::class, 'update']);
    Route::delete('collection-items/{id}', [CollectionItemController::class, 'destroy']);

    // Rotas para Collection Views
    Route::get('collection-views', [CollectionViewController::class, 'index']);
    Route::post('collection-views', [CollectionViewController::class, 'store']);
    Route::get('collection-views/{id}', [CollectionViewController::class, 'show']);
    Route::put('collection-views/{id}', [CollectionViewController::class, 'update']);
    Route::delete('collection-views/{id}', [CollectionViewController::class, 'destroy']);

    // Rotas para FilesOmnis
    Route::get('files-omnis', [FilesOmniController::class, 'index']);
    Route::post('files-omnis', [FilesOmniController::class, 'store']);
    Route::get('files-omnis/{id}', [FilesOmniController::class, 'show']);
    Route::put('files-omnis/{id}', [FilesOmniController::class, 'update']);
    Route::delete('files-omnis/{id}', [FilesOmniController::class, 'destroy']);

    // Rotas para Projects
    Route::get('projects', [ProjectController::class, 'index']);
    Route::post('projects', [ProjectController::class, 'store']);
    Route::get('projects/{id}', [ProjectController::class, 'show']);
    Route::put('projects/{id}', [ProjectController::class, 'update']);
    Route::delete('projects/{id}', [ProjectController::class, 'delete']);

    // Rotas para UserProjects
    Route::get('user-projects', [UserProjectController::class, 'index']);
    Route::post('user-projects', [UserProjectController::class, 'store']);
    Route::get('user-projects/{id}', [UserProjectController::class, 'show']);
    Route::put('user-projects/{id}', [UserProjectController::class, 'update']);
    Route::delete('user-projects/{id}', [UserProjectController::class, 'destroy']);

    // Rotas para Qrcodes
    Route::get('qrcodes', [QrcodeController::class, 'index']);
    Route::post('qrcodes', [QrcodeController::class, 'store']);
    Route::get('qrcodes/{id}', [QrcodeController::class, 'show']);
    Route::put('qrcodes/{id}', [QrcodeController::class, 'update']);
    Route::delete('qrcodes/{id}', [QrcodeController::class, 'destroy']);

    // Rotas para ShortLinks
    Route::get('short-links', [ShortLinkController::class, 'index']);
    Route::post('short-links', [ShortLinkController::class, 'store']);
    Route::get('short-links/{id}', [ShortLinkController::class, 'show']);
    Route::put('short-links/{id}', [ShortLinkController::class, 'update']);
    Route::delete('short-links/{id}', [ShortLinkController::class, 'destroy']);

    // Rotas para SiteZen
    Route::get('site-zen', [SiteZenController::class, 'index']);
    Route::post('site-zen', [SiteZenController::class, 'store']);
    Route::get('site-zen/{id}', [SiteZenController::class, 'show']);
    Route::put('site-zen/{id}', [SiteZenController::class, 'update']);
    Route::delete('site-zen/{id}', [SiteZenController::class, 'destroy']);
});
