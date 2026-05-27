<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
class PageController extends Controller
{
    public function caraPesan()
    {
        return view('user.cara-pesan'); 
    }


    public function hubungiKami()
{
    return view('user.hubungi-kami');
}


public function pusatBantuan()
{
    return view('user.pusat-bantuan');
}


public function tentangKami()
{
    return view('user.tentang-kami');
}


public function privasi()
{
    return view('user.privasi');
}


public function syaratKetentuan()
{
    return view('user.syarat-ketentuan');
}
}