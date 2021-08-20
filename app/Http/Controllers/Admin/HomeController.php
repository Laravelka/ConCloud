<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EnvEditor\EnvFile;
use App\User;
use Artisan;

class HomeController extends Controller
{
	public function home(Request $request)
	{
		return response()->view('admin.home');
	}

	public function index(Request $request)
	{
		return response()->view('admin.index');
	}

	public function users(Request $request)
	{
		$users = User::get();

		return response()->view('admin.users.index', [
			'users' => $users
		]);
	}

	public function settings(Request $request)
	{
		return response()->view('admin.settings');
	}
	
	public function settingsPost(Request $request)
	{
		$validated = $request->validate([
			'password' => 'required',
			'folder_id' => 'required'
		]);
		
		$env = EnvFile::loadFrom(base_path()."/.env");

		$env->setValue('ADMIN_PW', $request->password);
		$env->setValue('GOOGLE_DRIVE_ROOT_FOLDER_ID', $request->folder_id);

		$env->saveTo(base_path()."/.env");

		Artisan::call('config:cache');

		return response()->view('admin.settings', [
			'message' => 'Данные успешно изменены!'
		]);
	}

	public function usersEdit(Request $request, $id)
	{
		$user = User::find($id);

		return response()->view('admin.users.edit', [
			'user' => $user
		]);
	}

	public function usersEditPost(Request $request)
	{
		$user = User::find($request->id);
		$user->update($request->all());

		return response()->view('admin.users.edit', ['user' => $user]);
	}

	public function indexPost(Request $request)
	{
		$validated = $request->validate([
			'password' => 'required'
		]);
		
		if ($request->password != config('app.pw')) {
			return response()->view('admin.index', [
				'error' => true
			]);
		} else {
			\Session::put('isAuth', true);
		}
		return response()->view('admin.index');
	}
}
