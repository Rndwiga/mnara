<?php
/**
 * Created by PhpStorm.
 * User: Rndwiga
 * Date: 2/20/2017
 * Time: 8:25 PM
 */

namespace Tyondo\Mnara\Helpers;
use Caffeinated\Themes\Facades\Theme;
use PragmaRX\Google2FA\Vendor\Laravel\Facade as Google2FA;

class MnaraHelper
{
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