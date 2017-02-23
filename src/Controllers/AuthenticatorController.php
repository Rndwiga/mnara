<?php

namespace Tyondo\Mnara\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Vendor\Laravel\Facade as Google2FA;
use Tyondo\Mnara\Models\User;
use Illuminate\Support\Facades\Auth;
use Tyondo\Mnara\Helpers\MnaraHelper;

class AuthenticatorController extends Controller
{
    private $fileName;
    private $name;
    private $email;
    private $secretKey;
    private $keySize;
    private $keyPrefix = '';
    /**
     * Create a new controller instance.
     *https://gist.github.com/rdev5/e7f68dcfab8452bb5c65070a60422638
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->fileName = config('mnara_authenticator.options.file');
        $this->name  = config('mnara_authenticator.options.name');
        $this->email  = config('mnara_authenticator.options.email');
        $this->keySize = config('mnara_authenticator.options.keySize');
        $this->keyPrefix = config('mnara_authenticator.options.keyPrefix');
    }

    public function check2fa()
    {
        $isValid = $this->validateInput();
        // Render index and show the result
        return $this->index($isValid);
    }
    /** This function generates QRCode that will be used in connecting with google authenticator
     * @param $key
     * @return bool
     */
    private function getGoogleUrl($key)
    {
        return Google2FA::getQRCodeGoogleUrl( //can switch this line with <<return Google2FA::getQRCodeInline()>>
            $this->name,
            $this->email,
            $key
        );
    }
    /**This function is used to get stored secret key, if the key does not exist, it creates it and returns it
     * @param null
     * @return string
     */
    private function getSecretKey()
    {
        if (! $this->secretKey = $this->getStoredKey())
        {
            $this->secretKey = Google2FA::generateSecretKey($this->keySize, $this->keyPrefix);
            $this->storeKey($this->secretKey);
        }
        return $this->secretKey;
    }
    /**This function checks whether the secret key is set, if so, it returns it. Else, it pull it from the user account
     * @return string
     */
    private function getStoredKey()
    {
        // No need to read it from db again if we already have it
        if ($this->secretKey)
        {
            return $this->secretKey;
        }
        //If the key is not there already, read it from db and avail it for the application
        $secret = User::where('id',Auth::user()->id)->pluck('google2fa_secret');
            $this->secretKey = $secret['0'];
            return $this->secretKey;
    }
    /**This function is used to save the generated key to the database
     * @param $secretKey
     * @return null
     */
    private function storeKey($secretKey)
    {
        $user = User::find(Auth::user()->id);
        $user->google2fa_secret = $secretKey;
        $user->save();
    }
    /**
     * @return mixed
     */
    private function validateInput($key)
    {
        // Get the code from input submitted by the user
        if (! $enteredCode = request()->get('code'))
        {
            return false;
        }
        // Verify the code
        return Google2FA::verifyKey($key, $enteredCode);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $valid = $this->validateInput($this->getSecretKey());
        $googleUrl = $this->getGoogleUrl($this->secretKey);
        $inlineUrl = $this->getInlineUrl($this->secretKey);
       # return view('welcome', compact('key', 'googleUrl', 'inlineUrl', 'valid'));
        return MnaraHelper::isThemeSupportAvailable(config('mnara.views.authenticator.index'), compact('key', 'googleUrl', 'inlineUrl', 'valid'));
    }

    public function home()
    {
        //return $secret;
        $valid = $this->validateInput($key = $this->getSecretKey()); //expand this function to not allow the user to login if false
        $googleUrl = $this->getGoogleUrl($key);
        //return view(config('mnara.views.authentication.index'), compact('key', 'googleUrl', 'inlineUrl', 'valid'));
        return MnaraHelper::isThemeSupportAvailable(config('mnara.views.authenticator.index'), compact('key', 'googleUrl', 'inlineUrl', 'valid'));
    }

}
