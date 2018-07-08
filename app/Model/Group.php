<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    protected $table = "groups";
    protected $fillable = ['name', 'image'];

    public static function getAllGroupsOfAuthUser ()
    {
        return DB::table('group')
            ->join('group_users', 'group.id', '=', 'group_users.group_id')
            ->select('group.name as name', 'group.image as image', 'group.id as group_id')
            ->where('group_users.user_id', Auth::id())
            ->get();
    }
}
