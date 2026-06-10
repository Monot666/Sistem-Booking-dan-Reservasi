<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

/**
 * Serves static/informational pages.
 */
class PageController extends Controller
{
    /**
     * How to book guide page.
     */
    public function howToBook()
    {
        return view('user.cara-pesan');
    }

    /**
     * Contact us page.
     */
    public function contactUs()
    {
        return view('user.hubungi-kami');
    }

    /**
     * Help center page.
     */
    public function helpCenter()
    {
        return view('user.pusat-bantuan');
    }

    /**
     * About us page.
     */
    public function aboutUs()
    {
        return view('user.tentang-kami');
    }

    /**
     * Privacy notice page.
     */
    public function privacyNotice()
    {
        return view('user.privasi');
    }

    /**
     * Terms and conditions page.
     */
    public function termsAndConditions()
    {
        return view('user.syarat-ketentuan');
    }
}
