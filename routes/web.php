<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function() {
	Route::get('/user', function (Request $request) {
		return $request->user();
	});
	Route::prefix('files')->group(function() {
		Route::get('getAll', 'Api\FilesController@getAll');
		Route::post('upload', 'Api\FilesController@upload');
	});
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
	Route::get('/home', ['as' => 'home', 'uses' => 'Admin\HomeController@home'])
		->middleware('auth.admin');
	Route::get('/settings', ['as' => 'settings', 'uses' => 'Admin\HomeController@settings'])
		->middleware('auth.admin');
	Route::post('/settings', ['as' => 'settingsPost', 'uses' => 'Admin\HomeController@settingsPost']);

	Route::get('/exit', ['as' => 'exit', function(Request $request) {
		\Session::put('isAuth', null);

		return route()->redirect('/admin');
	}]);

	Route::group(['prefix' => 'users', 'as' => 'users'], function() {
		Route::get('/', 'Admin\HomeController@users')
			->middleware('auth.admin');
		Route::get('edit/{id}', ['as' => '.edit', 'uses' => 'Admin\HomeController@usersEdit'])
			->middleware('auth.admin');
		Route::post('edit/{id}', ['as' => '.editPost', 'uses' => 'Admin\HomeController@usersEditPost'])
			->middleware('auth.admin');
		/* 
		// Получение файлов по названию компании
		Route::get('files/{id}', ['as' => '.files', function(Request $request, $id) {
			$user = User::find($id);
			$arrUsers = User::where('id', $user->id)->orWhere('company', $user->company)->get();

			$newArrFiles = [];
			foreach($arrUsers as $arrUser) {
				$files = $arrUser->files()->get()->toArray();
				$newArrFiles = array_merge($newArrFiles, $files);
			}

			return response()->view('admin.users.files', [
				'files' => $newArrFiles
			]);
		}])->middleware('auth.admin');
		*/
		
		Route::get('files/{id}', ['as' => '.files',  function(Request $request, $id) {

			return response()->view('admin.users.files', [
				'user' => $request->user()
			]);
		}]);

		Route::get('files/getById/{id}', [
			'as' => '.filesGetById', 
			'uses' => 'Api\FilesController@getById'
		])->middleware('auth.admin');
	});

	Route::get('/', ['as' => 'index', 'uses' => 'Admin\HomeController@index'])
		->middleware('auth.admin');
	Route::post('/', ['as' => 'indexPost', 'uses' => 'Admin\HomeController@indexPost']);
	
});
