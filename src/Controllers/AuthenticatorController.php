<?php

namespace Tyondo\Mnara\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Vendor\Laravel\Facade as Google2FA;
use Tyondo\Mnara\Models\User;
use Illuminate\Support\Facades\Auth;
use Tyondo\Mnara\Helpers\MnaraHelper;

class AuthenticatorController extends Controller
{

    /**
     * Create a new controller instance.
     *https://gist.github.com/rdev5/e7f68dcfab8452bb5c65070a60422638
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        //return $secret;
        $valid = $this->validateInput($key = $this->getSecretKey()); //expand this function to not allow the user to login if false
        $googleUrl = $this->getGoogleUrl($key);
        //return view(config('mnara.views.authentication.index'), compact('key', 'googleUrl', 'inlineUrl', 'valid'));
        return MnaraHelper::isThemeSupportAvailable(config('mnara.views.authenticator.index'), compact('key', 'googleUrl', 'inlineUrl', 'valid'));
    }

}
