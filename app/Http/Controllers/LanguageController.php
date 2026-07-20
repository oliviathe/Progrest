<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($locale){
        $supportedLang = ['id', 'en']; 
        if(in_array($locale, $supportedLang)){
            session(["locale" => $locale]); 
        }
        return redirect()->back(); 
    }
}