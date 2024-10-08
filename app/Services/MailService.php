<?php

namespace App\Services;

use App\Mail\BookAcceptShip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;

class MailService
{
    public function sendBookAccept($email, $fullName, $book, $token)
    {
        Mail::to($email)->send(new BookAcceptShip($fullName, $book, $token));
    }

    public function compareToken($token): bool
    {
        $id = Auth::user()->id;
        return $token == DB::table('user_mail_accept')->where('user_id', $id)->select('accept_token')->get()->shift()->accept_token ? true : false;
    }
}