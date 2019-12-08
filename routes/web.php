<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\HomeController;
use Illuminate\Routing\Router;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::group(
	['middleware' => ['auth']],
	function (Router $route)
	{
		$route->get('/campaign', [CampaignController::class, 'list'])->name('campaign.list');
		$route->get('/campaign/create', [CampaignController::class, 'getCreate'])->name('campaign.create');
		$route->post('/campaign/create', [CampaignController::class, 'postCreate']);
	}
);
