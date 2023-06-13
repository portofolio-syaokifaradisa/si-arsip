<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\URL;

class URLHelper{
    public static function has($subUrl){
        $currentURL = URL::current();
        return str_contains($currentURL, $subUrl);
    }
}