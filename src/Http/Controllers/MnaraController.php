<?php
namespace Tyondo\Mnara\Http\Controllers;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Tyondo\Mnara\Facades\MnaraFacade as Mnara;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\RouteCollection;


class MnaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response | mixed
     */
    public function index()
    {

        if ( Auth::user()->can( config('mnara.acl.mnara.index', false) ) ) {
          $dashboard = config('mnara.dashboard'); //links
          $title = config('mnara.site_title');  //title
         return Mnara::view(config('mnara.views.layouts.dashboard'), compact('dashboard', 'title'));
        }

        return Mnara::view(config('mnara.views.layouts.unauthorized'), [ 'message' => 'view the dashboard' ]);
    }
}
