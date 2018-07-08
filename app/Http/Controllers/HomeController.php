<?php

namespace App\Http\Controllers;

use App\Model\Group;
use App\Model\GroupMessage;
use App\Model\Message;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::getAllOtherUsers();
        $groups = Group::getAllGroupsOfAuthUser();
        $this->addLastMessagePropertyToUsersCollection($users);
        $this->addLastMessagePropertyToGroupsCollection($groups);
        $all_contacts = $users->concat($groups);

        return view('home', compact('users', 'all_contacts'));
    }

    protected function addLastMessagePropertyToUsersCollection (&$users)
    {
        $last_message = $this->getLastMessageForEachConversation(Message::getAllMessagesOfAuthUser());
        $this->createLastUserMessageInStringForm($users, $last_message);
    }

    protected function getLastMessageForEachConversation ($messages)
    {
        $userMessages = array();
        foreach ($messages as $message) {
            $key = ($message->from < $message->to) ? "{$message->from}_{$message->to}" : "{$message->to}_{$message->from}";
            $userMessages[$key]['content'] = $message->content;
            $userMessages[$key]['from'] = $message->from;
        }
        return $userMessages;
    }

    protected function createLastUserMessageInStringForm (&$users, $last_message)
    {
        foreach ($users as $user) {
            $key = (Auth::id() < $user->id) ? Auth::id() . "_{$user->id}" : "{$user->id}_" . Auth::id();
            if (isset($last_message[$key])) {
                $user->last_message = ($last_message[$key]['from'] == Auth::id()) ? "Bạn: {$last_message[$key]['content']}" : "{$last_message[$key]['content']}";
            }
        }
    }

    protected function addLastMessagePropertyToGroupsCollection (&$groups)
    {
        $group_messages = GroupMessage::getAllGroupMessagesOfAuthUser($this->getGroupIdsOfAuthUser($groups));
        $last_message = $this->getLastMessageFromAllGroupMessages($group_messages);
        $this->createLastMessageInStringForm($groups, $last_message);
    }

    protected function getGroupIdsOfAuthUser (&$groups)
    {
        $groups_array = [];
        foreach ($groups as $group) {
            array_push($groups_array, $group->group_id);
        }
        return $groups_array;
    }

    protected function getLastMessageFromAllGroupMessages ($group_messages)
    {
        $last_message = [];
        foreach ($group_messages as $message) {
            $key = ($message->from < $message->to_group_id) ? "{$message->from}_{$message->to_group_id}" : "{$message->to_group_id}_{$message->from}";
            $last_message[$message->to_group_id]['content'] = $message->content;
            $last_message[$message->to_group_id]['from'] = $message->from;
        }
        return $last_message;
    }

    protected function createLastMessageInStringForm (&$groups, $last_message)
    {
        foreach ($groups as $group) {
            $key = (Auth::id() < $group->group_id) ? Auth::id() . "_{$group->group_id}" : "{$group->group_id}_" . Auth::id();
            if (isset($last_message[$group->group_id])) {
                $user_name = (User::find($last_message[$group->group_id]['from']))->name;
                $group->last_message = ($last_message[$group->group_id]['from'] != Auth::id()) ? "{$user_name}: {$last_message[$group->group_id]['content']}" : "Bạn: {$last_message[$group->group_id]['content']}";
            }
        }
    }

    public function getUserIDArray($group_id, $user_ids)
    {
        $rows = array();
        array_push($user_ids, Auth::id());
        foreach ($user_ids as $user_id) {
            $rows[] = [
                'group_id' => $group_id,
                'user_id' => $user_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        return $rows;
    }

    public function create_group()
    {
        $isGroupNameExist = count(DB::table("group")->where("name", \request()->group_name)->get()) > 0;
        if ($isGroupNameExist) {
            return Response::json("exist");
        }
        DB::table('group')->insert([
            'name' => \request()->group_name,
            'image' => \request()->group_image,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $group_id = DB::getPdo()->lastInsertId();
        DB::table('group_users')->insert(
            $this->getUserIDArray($group_id, \request()->users)
        );
        $response = array(
            'group_id' => $group_id
        );
        return Response::json($response);
    }

    public function get_messages()
    {
        if (\request()->type == "user") {
            $messages = DB::table('messages')
                ->where('from', Auth::id())
                ->where('to', \request()->partner_id)
                ->orWhere(function ($query) {
                    $query->where('from', \request()->partner_id)
                        ->where('to', Auth::id());
                })
                ->orderBy("created_at", "desc")
                ->skip(\request()->offset)
                ->limit(15)
                ->get();
        } else {
            $messages = DB::table('group_messages')
                ->join('users', 'group_messages.from', '=', 'users.id')
                ->select('users.image as image', 'group_messages.*', 'users.name as user_name')
                ->where('to_group_id', \request()->partner_id)
                ->orderBy("created_at", "desc")
                ->skip(\request()->offset)
                ->limit(15)
                ->get();
        }
        echo json_encode($messages);
    }
}
