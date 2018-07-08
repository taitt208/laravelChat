<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    protected $table = "messages";
    protected $fillable = ['content', 'from', 'to'];

    public static function getAllMessagesOfAuthUser ()
    {
        return DB::table('messages')
            ->where('from', Auth::id())
            ->orWhere('to', Auth::id())
            ->get();
    }
}
