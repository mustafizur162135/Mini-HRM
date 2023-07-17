<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function setLanguage(Request $request)
    {
    
        $language = $request->input('language');
    
        // Store the selected language in the session
        Session::put('preferred_language', $language);
        
        // Set the preferred language
        App::setLocale($language);
    
        // Redirect back to the previous page or any desired route
        return redirect()->back();
    }
}
