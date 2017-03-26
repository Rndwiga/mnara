<?php

namespace Tyondo\Mnara\Controllers;

use Illuminate\Http\Request;
use Tyondo\Mnara\Helpers\Mnara2faHelper;
use Tyondo\Mnara\Facades\MnaraFacade as Mnara;



class AuthenticatorController extends Controller
{

    /**
     * Create a new controller instance.
     *https://gist.github.com/rdev5/e7f68dcfab8452bb5c65070a60422638
     * @param mixed
     *
     */
    public function __construct(Mnara2faHelper $g2fa)
    {
        $this->middleware('auth');
        $this->g2fa = $g2fa;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $valid = $this->g2fa->validateInput($key = $this->g2fa->getSecretKey()); //expand this function to not allow the user to login if false
        $googleUrl = $this->g2fa->getGoogleUrl($key);
        return Mnara::view(config('mnara.views.authenticator.index'), compact('key', 'googleUrl', 'inlineUrl', 'valid'));
    }

}
