<?php

use App\Http\Controllers\Admin\ClassesController;
use App\Http\Controllers\Backend\LokerApplyController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LayananController;
use App\Http\Controllers\Front\PagesController;
use App\Http\Controllers\Loker\BerandaLoker;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register frontend web routes for your application.
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get("/pages/page/{id}", [PagesController::class, "showKelas"]);
Route::get("/pages/about", [PagesController::class, "showAbout"]);
Route::get("/pages/contact", [PagesController::class, "showContact"]);
Route::get("/pages/blog", [PagesController::class, "showListBlog"]);
Route::get("/pages/blog/{id}/{slug}", [PagesController::class, "showBlog"]);
// Layanan
Route::get("/pages/Banking-Solution", [LayananController::class, "ShowBankingSolution"]);
Route::get("/pages/Capacity-Building", [LayananController::class, "ShowCapacityBuilding"]);
Route::get("/pages/Talent-Solution", [LayananController::class, "ShowCTalentSolution"]);
// Class
Route::get('/list-class', [ClassesController::class, "listClass"]);
Route::post('/list-class', [ClassesController::class, "findClass"]);
// Loker Apply
Route::resource('admin/apply', LokerApplyController::class);
Route::get('admin/getdatacvpelamar', [LokerApplyController::class, 'getdatacvpelamar']);
Route::post('admin/approvecvpelamar', [LokerApplyController::class, 'approvecvpelamar']);
// Loker
Route::resource('loker', BerandaLoker::class);
Route::get('/loker/{id}/detail', [BerandaLoker::class, "detail"]);
Route::post('/loker/apply', [BerandaLoker::class, "apply"]);
Route::get('/admin/loker/getkabupaten/{id}', [BerandaLoker::class, 'getkabupaten']);
Route::get('/admin/loker/getkecamatan/{id}', [BerandaLoker::class, 'getkecamatan']);
Route::get('/admin/loker/getkelurahan/{id}', [BerandaLoker::class, 'getkelurahan']);

Route::get("/promo", [HomeController::class, "showAllPromo"]);

Route::get('/template', function () {
	return view('front.cvtemplate.cv');
});
Route::get('/kurikulum', function () {
	return view('frontend.pages.kurikulum.kurikulum');
});
