<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupMessage extends Model
{
    protected $table = "group_messages";
    protected $fillable = ['content', 'from', 'to_group_id'];

    public static function getAllGroupMessagesOfAuthUser ($usersInGroup = array())
    {
        return DB::table('group_messages')
            ->whereIn('to_group_id', $usersInGroup)
            ->get();
    }
}
