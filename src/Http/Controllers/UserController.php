<?php

namespace Tyondo\Mnara\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Tyondo\Mnara\Facades\MnaraFacade as Mnara;
use Tyondo\Mnara\Models\User;
use Tyondo\Mnara\Models\Role;

use Tyondo\Mnara\Http\Requests\UserStoreRequest;
use Tyondo\Mnara\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{

	protected $model = User::class;

	/**
	 * Set resource model in constructor.
	 */
	function __construct() {
		$this->model = $this->getModel();
	}


	/**
	 * Determine which model to use
	 * @return object Model
	 */
	function getModel() {
		$model = config('mnara.user.model', $this->model);
        return new $model;
	}
	/**
	 * Display a listing of the resource.
	 * @param  \Illuminate\Http\Request
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
  		if ( Auth::user()->can( config('mnara.acl.user.index', false) ) ) {
			if ( $request->has('search_value') ) {
				$value = $request->get('search_value');
				$users = $this->model->where('name', 'LIKE', '%'.$value.'%')
					->orderBy('name')->paginate( config('mnara.pagination.users', 15) );
				session()->flash('search_value', $value);
			} else {
				$users = $this->model->orderBy('name')->paginate( config('mnara.pagination.users', 15) );
				session()->forget('search_value');	
			}
			
			return Mnara::view( config('mnara.views.users.index'), compact('users') );
	 	}

	 	return Mnara::view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'view user list' ]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
	 	if ( Auth::user()->can( config('mnara.acl.user.create', false) ) ) {
			return Mnara::view(config('mnara.views.users.create'));
	 	}

	 	return Mnara::view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'create new users' ]);

	}

	/**
	 * Store a newly created resource in storage.
	 * @param \Tyondo\Mnara\Requests\UserStoreRequest
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserStoreRequest $request)
	{
		$level = "danger";
		$message = " You are not permitted to create users.";

		if ( Auth::user()->can ( config('mnara.acl.user.create', false) ) ) {
			$this->model->create($request->all());
			$level = "success";
			$message = "<i class='fa fa-check-square-o fa-1x'></i> Success! User created.";
		}

		return redirect()->route( config('mnara.route.as') . 'user.index')
				->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
  		if ( Auth::user()->canAtLeast( [ config('mnara.acl.user.show', false),  config('mnara.acl.user.edit', false) ] ) ) {
			$resource = $this->model->findOrFail($id);
			$show = "1";
			return Mnara::view( config('mnara.views.users.show'), compact('resource','show') );
	 	}

	 	return Mnara::view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'view users' ]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
  		if ( Auth::user()->canAtLeast( [ config('mnara.acl.user.edit', false),  config('mnara.acl.user.show', false) ] ) ) {
			$resource = $this->model->findOrFail($id);
			$show = "0";
			return Mnara::view( config('mnara.views.users.edit'), compact('resource','show') );
	 	}

	 	return Mnara::view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'edit users' ]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
     * @param  object UserUpdateRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserUpdateRequest $request, $id)
	{
		$level = "danger";
		$message = " You are not permitted to update users.";

		if ( Auth::user()->can ( config('mnara.acl.user.edit', false) ) ) {
			$user = $this->model->findOrFail($id);
			if ($request->get('password') == '') {
        		$user->update( $request->except('password') );
    		} else {
        		$user->update( $request->all() );
    		}
			$level = "success";
			$message = "<i class='fa fa-check-square-o fa-1x'></i> Success! User edited.";
		}
		
		return redirect()->route( config('mnara.route.as') . 'user.index')
				->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$level = "danger";
		$message = " You are not permitted to destroy user objects";

		if ( Auth::user()->can ( config('mnara.acl.user.destroy', false) ) ) {
			$this->model->destroy($id);
			$level = "warning";
			$message = "<i class='fa fa-check-square-o fa-1x'></i> Success! User deleted.";
		}

		return redirect()->route( config('mnara.route.as') . 'user.index')
					->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
	}

	/**
	 * Show the form for editing the user roles.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function editUserRoles($id)
	{
  		if ( Auth::user()->can( config('mnara.acl.user.role', false) ) ) {
			$user = $this->model->findOrFail($id);

			$roles = $user->roles;

	    	$available_roles = Role::whereDoesntHave('users', function ($query) use ($id) {
			    $query->where('user_id', $id);
			})->get();

			return Mnara::view( config('mnara.views.users.role'), compact('user', 'roles', 'available_roles') );
		}

	 	return Mnara::view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'sync user roles' ]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateUserRoles($id, Request $request)
	{
		$level = "danger";
		$message = " You are not permitted to update user roles.";

		if ( Auth::user()->can ( config('mnara.acl.user.role', false) ) ) {
			$user = $this->model->findOrFail($id);
			if ($request->has('ids')) {
				$user->roles()->sync( $request->get('ids') );
			} else {
				$user->roles()->detach();
			}
			$level = "success";
			$message = "<i class='fa fa-check-square-o fa-1x'></i> Success! User roles edited.";
		}

		return redirect()->route( config('mnara.route.as') . 'user.index')
				->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
	}

	/**
	 * [userMatrix description]
	 * @return \Illuminate\Http\Response
	 */
	public function showUserMatrix()
	{
  		if ( Auth::user()->can( config('mnara.acl.user.viewmatrix', false) ) ) {
			$roles = Role::all();
			$users = $this->model->orderBy('name')->get();
			$us = DB::table('role_user')->select('role_id as r_id','user_id as u_id')->get();

			$pivot = [];
			foreach($us as $u) {
				$pivot[] = $u->r_id.":".$u->u_id;
			}

			return Mnara::view( config('mnara.views.users.usermatrix'), compact('roles','users','pivot') );
		}

	 	return Mnara::view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'sync user roles' ]);
	}

	/**
	 * [updateMatrix description]
	 * @return \Illuminate\Http\Response
	 */
	public function updateUserMatrix(Request $request)
	{		
		$level = "danger";
		$message = " You are not permitted to update user roles.";

		if ( Auth::user()->can ( config('mnara.acl.user.usermatrix', false) ) ) {
			$bits = $request->get('role_user');
			foreach($bits as $v) {
				$p = explode(":", $v);
				$data[] = array('role_id' => $p[0], 'user_id' => $p[1]);
			}
			
			DB::transaction(function () use ($data) {
				DB::table('role_user')->delete();
				DB::statement('ALTER TABLE role_user AUTO_INCREMENT = 1');
				DB::table('role_user')->insert($data);
			});
			$level = "success";
			$message = "<i class='fa fa-check-square-o fa-1x'></i> Success! User roles updated.";
		}

		return redirect()->route( config('mnara.route.as') . 'user.matrix')
				->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
	}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUserProfile($id)
    {
        //return Auth::user()->can(config('mnara.acl.user.profile', false));
        if ( Auth::user()->can([config('mnara.acl.user.profile', false) ] ) ) {
            $resource = $this->model->findOrFail($id);
            $show = "1";
            return Mnara::view( config('mnara.views.users.profile'), compact('resource','show') );
        }

        return Mnara::view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'view users' ]);
    }
}
