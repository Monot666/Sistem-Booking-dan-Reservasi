<?php

/**
 * @deprecated This controller is for testing/development only.
 * Kept for reference — do NOT use in production routes.
 */

namespace App\Http\Controllers\_Deprecated;

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

            Mail::send('emails.tester', ['users' => $users], function ($message) {
                $message->to('roomlytrust@gmail.com')
                        ->subject('Daftar User Terbaru');
            });

            return back()->with('success', 'Email berhasil dikirim ke roomlytrust@gmail.com!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}
