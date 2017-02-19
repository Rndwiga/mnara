<?php
namespace Tyondo\Mnara\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Shinobi; //ACL

use App\Http\Controllers\Controller;

class MnaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      if ( Shinobi::can( config('mnara.acl.mnara.index', false) ) ) {
            $links = config('mnara.dashboard');
            return view( config('mnara.views.layouts.dashboard') )
                    ->with('dashboard', $links)
                    ->with('title', config('mnara.site_title') );
        }


        return view( config('mnara.views.layouts.unauthorized'), [ 'message' => 'view the dashboard' ]);
    }
}
