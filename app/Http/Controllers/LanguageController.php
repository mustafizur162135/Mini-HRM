<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function setLanguage(Request $request)
    {
        $this->validate($request, [
            'language' => 'required|in:en,bn', // You can add more language codes if needed
        ]);



        $language = $request->input('language');
        dd($language);

        App::setLocale($language);


        return redirect()->back();
    }
}