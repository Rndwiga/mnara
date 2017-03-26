<?php

namespace Tyondo\Mnara\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tyondo\Mnara\Facades\MnaraFacade as Mnara;
use Tyondo\Mnara\Models\User;
use Tyondo\Mnara\Models\Role;
use Tyondo\Mnara\Models\Permission;
use Tyondo\Mnara\Requests\StoreRequest;
use Tyondo\Mnara\Requests\UpdateRequest;

class RoleController extends Controller
{
	
	/**
	 * Set resource in constructor.
	 */
	function __construct()
	{
		$this->route = "role";
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if ( Auth::user()->can( config('mnara.acl.role.index', false) ) ) {
			$roles = $this->getData();

			return Mnara::view(config('mnara.views.roles.index'), compact('roles') );
	 	}

	 	return Mnara::view(config('mnara.views.layouts.unauthorized'), [ 'message' => 'view role list' ]);
	}

	/**
	 * Returns paginated list of items, checks if filter used
	 * @return array Permissions
	 */
	protected function getData()
	{
		if ( \Request::has('search_value') ) {
			$value = \Request::get('search_value');
			$roles = Role::where('name', 'LIKE', '%'.$value.'%')
				->orWhere('slug', 'LIKE', '%'.$value.'%')
				->orWhere('description', 'LIKE', '%'.$value.'%')
				->orderBy('name')->paginate( config('mnara.pagination.roles', 15) );
			session()->flash('search_value', $value);
		} else {
			$roles = Role::orderBy('name')->paginate( config('mnara.pagination.roles', 15) );
			session()->forget('search_value');	
		}

		return $roles;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if ( Auth::user()->can( config('mnara.acl.role.create', false) ) ) {
		    $route = $this->route;
		   // return view( config('mnara.views.roles.create'), compact('route') );
			return Mnara::view( config('mnara.views.roles.create'), compact('route') );
		}

		return Mnara::view(config('mnara.views.layouts.unauthorized'), [ 'message' => 'create new roles' ]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StoreRequest $request)
	{		
		$level = "danger";
		$message = " You are not permitted to create roles.";

		if ( Auth::user()->can ( config('mnara.acl.role.create', false) ) ) {
			Role::create($request->all());
			$level = "success";
			$message = "<i class='fa fa-check-square-o fa-1x'></i> Success! Role created.";
		}

		return redirect()->route( config('mnara.route.as') .'role.index')
				->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if ( Auth::user()->canAtLeast( [ config('mnara.acl.role.edit', false),  config('mnara.acl.role.show', false)] ) ) {
			$resource = Role::findOrFail($id);
			$show = "1";
			$route = $this->route;
			return Mnara::view( config('mnara.views.roles.show'), compact('resource','show','route') );
		}

		return Mnara::view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'view roles' ]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if ( Auth::user()->canAtLeast( [ config('mnara.acl.role.edit', false),  config('mnara.acl.role.show', false)] ) ) {
			$resource = Role::findOrFail($id);
			$show = "0";
			$route = $this->route;

			return Mnara::view( config('mnara.views.roles.edit'), compact('resource','show','route') );
		}

		return Mnara::view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'edit roles' ]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, UpdateRequest $request)
	{		
		$level = "danger";
		$message = " You are not permitted to update roles.";

		if ( Auth::user()->can ( config('mnara.acl.role.edit', false) ) ) {
			$role = Role::findOrFail($id);
			$role->update($request->all());
			$level = "success";
			$message = "<i class='fa fa-check-square-o fa-1x'></i> Success! Role edited.";
		}

		return redirect()->route( config('mnara.route.as') .'role.index')
				->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{		
		$level = "danger";
		$message = " You are not permitted to destroy roles.";

		if ( Auth::user()->can ( config('mnara.acl.role.destroy', false) ) ) {
			Role::destroy($id);
			$level = "warning";
			$message = "<i class='fa fa-check-square-o fa-1x'></i> Success! Role deleted.";
		}

		return redirect()->route( config('mnara.route.as') .'role.index')
				->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
	}

	/**
	 * Show the form for editing the role permissions.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editRolePermissions($id)
	{
		if ( Auth::user()->can( config('mnara.acl.role.permissions', false) ) ) {
			$role = Role::findOrFail($id);

			$permissions = $role->permissions;

	    	$available_permissions = Permission::whereDoesntHave('roles', function ($query) use ($id) {
			    $query->where('role_id', $id);
			})->get();

			return Mnara::view( config('mnara.views.roles.permission'), compact('role', 'permissions', 'available_permissions') );
	 	}

	 	return Mnara::view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'sync role permissions' ]);
	}

	/**
	 * Sync roles and permissions.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateRolePermissions($id, Request $request)
	{
		$level = "danger";
		$message = " You are not permitted to update role permissions.";

		if ( Auth::user()->can ( config('mnara.acl.role.permissions', false) ) ) {
			$role = Role::findOrFail($id);
			if ($request->has('slug')) {
				$role->permissions()->sync( $request->get('slug') );
			} else {
				$role->permissions()->detach();
			}
			$level = "success";
			$message = "<i class='fa fa-check-square-o fa-1x'></i> Success! Role permissions updated.";
		}

		return redirect()->route( config('mnara.route.as') .'role.index')
				->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
	}

	/**
	 * Show the form for editing the role users.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editRoleUsers($id)
	{
		if ( Auth::user()->can( config('mnara.acl.role.users', false) ) ) {
			$role = Role::findOrFail($id);

			$users = $role->users;

	    	$available_users = User::whereDoesntHave('roles', function ($query) use ($id) {
			    $query->where('role_id', $id);
			})->get();

			return Mnara::view( config('mnara.views.roles.user'), compact('role', 'users', 'available_users') );
		}

	 	return Mnara::view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'sync role users' ]);
	}

	/**
	 * Sync roles and users.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateRoleUsers($id, Request $request)
	{
		$level = "danger";
		$message = " You are not permitted to update role users.";

		if ( Auth::user()->can ( config('mnara.acl.role.users', false) ) ) {
			$role = Role::findOrFail($id);
			if ($request->has('slug')) {
				$role->users()->sync( $request->get('slug') );
			} else {
				$role->users()->detach();
			}
			$level = "success";
			$message = "<i class='fa fa-check-square-o fa-1x'></i> Success! Role users updated.";
		}

		return redirect()->route( config('mnara.route.as') .'role.index')
				->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
	}

	/**
	 * A full matrix of roles and permissions.
	 * @return Response
	 */
	public function showRoleMatrix()
	{
		if ( Auth::user()->can( config('mnara.acl.role.viewmatrix', false) ) ) {
			$roles = Role::all();
			$perms = Permission::all();
			$prs = DB::table('permission_role')->select('role_id as r_id','permission_id as p_id')->get();

			$pivot = [];
			foreach($prs as $p) {
				$pivot[] = $p->r_id.":".$p->p_id;
			}

			return Mnara::view( config('mnara.views.roles.rolematrix'), compact('roles','perms','pivot') );
		}

	 	return Mnara::view(config('mnara.views.layouts.unauthorized'), [ 'message' => 'view the role matrix' ]);
	}

	/**
	 * Sync roles and permissions.
	 * @return Response
	 */
	public function updateRoleMatrix(Request $request)
	{		
		$level = "danger";
		$message = " You are not permitted to update role permissions.";

		if ( Auth::user()->can ( config('mnara.acl.role.permissions', false) ) ) {
			$bits = $request->get('perm_role');
			foreach($bits as $v) {
				$p = explode(":", $v);
				$data[] = array('role_id' => $p[0], 'permission_id' => $p[1]);
			}
			
			DB::transaction(function () use ($data) {
				DB::table('permission_role')->delete();
				DB::statement('ALTER TABLE permission_role AUTO_INCREMENT = 1');
				DB::table('permission_role')->insert($data);
			});

			$level = "success";
			$message = "<i class='fa fa-check-square-o fa-1x'></i> Success! Role permissions updated.";
		}

		return redirect()->route( config('mnara.route.as') .'role.matrix')
				->with( ['flash' => ['message' => $message, 'level' =>  $level] ] );
	}


}
