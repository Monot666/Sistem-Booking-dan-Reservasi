<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class TesterController extends Controller
{
    public function index()
    {
        return "Hello World";
    }

    public function send()
    {
        try {
            $users = User::latest()->take(10)->get(); 

            Mail::send('email.tester', ['users' => $users], function ($message) {
                $message->to('cathyrium@gmail.com')
                        ->subject('Daftar User Terbaru');
            });

            return back()->with('success', 'Email berhasil dikirim ke cathyrium@gmail.com!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }

}
