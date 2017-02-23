<?php
/**
 * Created by PhpStorm.
 * User: Rndwiga
 * Date: 2/20/2017
 * Time: 8:25 PM
 */

namespace Tyondo\Mnara\Helpers;
use Caffeinated\Themes\Facades\Theme;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Vendor\Laravel\Facade as Google2FA;

class MnaraHelper
{
    public  $view;
    private $fileName;
    private $name;
    private $email;
    private $secretKey;
    private $keySize;
    private $keyPrefix = '';
    /**
     * Create a new controller instance.
     *https://gist.github.com/rdev5/e7f68dcfab8452bb5c65070a60422638
     *
     */
    public function __construct()
    {
        $this->fileName = config('mnara_authenticator.options.file');
        $this->name  = config('mnara_authenticator.options.name');
        $this->email  = config('mnara_authenticator.options.email');
        $this->keySize = config('mnara_authenticator.options.keySize');
        $this->keyPrefix = config('mnara_authenticator.options.keyPrefix');
    }
    public function regenerateSecretKey()
    {
        $this->secretKey = Google2FA::generateSecretKey($this->keySize, $this->keyPrefix);
        $this->storeKey($this->secretKey);
        return $this->home();
    }
    public function check2fa()
    {
        $isValid = $this->validateInput();
        // Render index and show the result
        //return $this->home($isValid);
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
     * @param string|null $options
     * @param string $view
     * @param $routes
     * @return object
     * This static class checks whether the theme plugin is available and installed if it is it uses the developed theme
     * The function also checks if addition route parameters are set
     *
     */

    static function isThemeSupportAvailable($view, $options = null, $routes = null)
    {
        if(class_exists('Caffeinated\Themes\Facades\Theme')){
            if(!$routes && !$options){
                return Theme::view($view);
            }elseif(!$routes){
                return Theme::view($view, $options);
            }
            return Theme::view($view, $options)->$routes;
        }else{
            if(!$routes && !$options){
                return view($view);
            }elseif (!$routes){
                return view($view, $options);
            }
            return view($view, $options)->$routes;
        }
    }

}