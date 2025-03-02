<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

	public function __construct()
	{
		//$this->middleware('admin', ['except' => ['login', 'logout','settings','postSettings']]);
		$this->middleware('auth');
	}
	/**
	 * Make Login
	 *
	 * @return Response
	 */
	public function login()
	{
		return view('dashboard');
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::to('/login')->with('success', 'Your are now logged out!');
	}

	/**
	 * Show all user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();
		$allRoles = Role::all();
		return view('user.index', compact(['users', 'allRoles']));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('user.create', compact('faculties'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		try {
			// return $request;
			$this->validate($request, [
				'name' => 'required|max:255',
				'email' => 'email|required|unique:users',
				'password' => 'required|confirmed|min:6'
			]);
			$data = array();
			$data = $request->all();

			$user = User::create([
				'name' => $data['name'],
				'email' => $data['email'],
				'phone' => $data['phone'],
				'subject_position' => $data['subject_position'],
				'password' => bcrypt($data['password']),
				'status' => $data['status'],
			]);
			$user->attachRole(Role::where('name', 'general')->first());
			$notification = array('title' => 'Data Store', 'body' => 'User Created Succesfully.');
			return Redirect::route('user.create')->with("success", $notification);
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}

	public function edit($id)
	{
		$user = User::find($id);
		return view('user.edit', compact('user'));
	}

	public function update(Request $request, $id)
	{
		$user = User::find($id);
        $user->update([
			'name' => $request->name,
			'email' => $request->email,
			'status' => $request->status,
		]);
        if ($request->password){
            $user->update([
                'password'=>bcrypt($request->password)
            ]);
        }
		toastr()->success('User updated successfully...', 'Success');
		return redirect()->route('user.index');
	}

	public function role_update(Request $request, $id)
	{
		try {
			// return $id;
			$user = User::find($id);
			$roles = $request->roles;
			DB::table('role_user')->where('user_id', $id)->delete();
			foreach ($roles as $role) {
				$user->attachRole($role);
			}
			toastr()->success('Roles added successfully...', 'Success');
			return redirect()->back();
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(User $user)
	{
		try {
			$user->delete();
			toastr()->success('User deleted successfully', 'Sucess');
			return redirect()->back();
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}

	/**
	 * Change the specified user informations.
	 *
	 *@return Response
	 */
	public function settings()
	{
		$user = Auth::user();
		return view('user.settings', compact('user'));
	}

	public function postSettings(Request $request)
	{
		$request->validate([
			'password' => 'required|same:password_confirmation|different:oldpassword'
		]);
		if ($request->oldpassword == $request->password) {
			toastr()->warning('Choose a new password', 'Warning!');
			return redirect()->back();
		}
		$user_id = auth()->user()->id;
		User::where('id', $user_id)->update([
			'password' => bcrypt($request['password']),
			'password_raw' => $request['password']
		]);
		toastr()->success('Password Updated Successfully', 'Success');
		return redirect()->back();
	}
}
