<?php
namespace Tyondo\Mnara\Controllers;

use Illuminate\Support\Facades\Auth;

class MnaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if ( Auth::user()->can( config('mnara.acl.mnara.index', false) ) ) {
            $links = config('mnara.dashboard');
            return view( config('mnara.views.layouts.dashboard') )
                    ->with('dashboard', $links)
                    ->with('title', config('mnara.site_title') );
        }

        return view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'view the dashboard' ]);
    }
}
