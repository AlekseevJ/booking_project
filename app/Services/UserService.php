<?php

namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class UserService
{
    public function generateAcceptToken($user, $book)
    {
        $id = $user->id;
        $token = Str::random(32);

        DB::table('user_mail_accept')->where('user_id', $id)->delete();
        DB::table('user_mail_accept')->insert(['accept_token' => $token, 'user_id' => $id, 'booking_id' => $book->id, 'created_at' => Carbon::now()]);

        return $token;
    }
}