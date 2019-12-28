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

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\StepController;
use Illuminate\Routing\Router;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.forgot');
Route::post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail']);

Route::get('/password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset']);

Route::group(
	['middleware' => ['auth']],
	function (Router $route)
	{
		$route->get('/invite/{invite_id}', [InviteController::class, 'invite'])->name('invite');

		$route->get('/campaign', [CampaignController::class, 'list'])->name('campaign.list');
		$route->get('/campaign/create', [CampaignController::class, 'getCreate'])->name('campaign.create');
		$route->post('/campaign/create', [CampaignController::class, 'postCreate']);
		$route->get('/campaign/{campaign}/edit', [CampaignController::class, 'getEdit'])->name('campaign.edit');
		$route->post('/campaign/{campaign}/edit', [CampaignController::class, 'postEdit']);
		$route->get('/campaign/{campaign}/reset-link', [CampaignController::class, 'resetLink'])->name('campaign.reset-link');
		$route->get('/campaign/{campaign}/add-player/{user}', [CampaignController::class, 'addPlayer'])->name('campaign.add-player');
		$route->get('/campaign/{campaign}/remove-player/{user}', [CampaignController::class, 'removePlayer'])->name('campaign.remove-player');
		$route->get('/campaign/{campaign}/set-dm/{user}', [CampaignController::class, 'setDm'])->name('campaign.dm.set');
		$route->get('/campaign/{campaign}/unset-dm/{user}', [CampaignController::class, 'unsetDm'])->name('campaign.dm.unset');
		$route->get('/campaign/{campaign}/play', [CampaignController::class, 'play'])->name('campaign.play');

		$route->get('/api/campaigns/{campaign}', [CampaignController::class, 'get'])->name('api.campaign.detail');

		$route->post('/api/quest', [QuestController::class, 'add'])->name('api.quest.add');
		$route->post('/api/quest/{quest}', [QuestController::class, 'edit'])->name('api.quest.edit');
		$route->delete('/api/quest/{quest}', [QuestController::class, 'delete'])->name('api.quest.delete');
		$route->put('/api/quest/{quest}/visibility', [QuestController::class, 'visibility'])->name('api.quest.visibility');

		$route->post('/api/step', [StepController::class, 'add'])->name('api.step.add');
		$route->post('/api/step/{step}', [StepController::class, 'edit'])->name('api.step.edit');
		$route->delete('/api/step/{step}', [StepController::class, 'delete'])->name('api.step.delete');
		$route->put('/api/step/{step}/visibility', [StepController::class, 'visibility'])->name('api.step.visibility');
		$route->put('/api/step/{step}/state', [StepController::class, 'state'])->name('api.step.state');

		$route->post('/api/comment', [CommentController::class, 'add'])->name('api.comment.add');
		$route->post('/api/comment/{comment}', [CommentController::class, 'edit'])->name('api.comment.edit');
		$route->delete('/api/comment/{comment}', [CommentController::class, 'delete'])->name('api.comment.delete');
		$route->put('/api/comment/{comment}/visibility', [CommentController::class, 'visibility'])->name('api.comment.visibility');

		$route->post('/api/resource', [ResourceController::class, 'add'])->name('api.resource.add');
		$route->post('/api/resource/{resource}', [ResourceController::class, 'edit'])->name('api.resource.edit');
		$route->delete('/api/resource/{resource}', [ResourceController::class, 'delete'])->name('api.resource.delete');
		$route->put('/api/resource/{resource}/visibility', [ResourceController::class, 'visibility'])->name('api.resource.visibility');
	}
);
