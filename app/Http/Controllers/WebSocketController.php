<?php
namespace App\Http\Controllers;
use App\Model\GroupMessage;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WebSocketController extends Controller implements MessageComponentInterface{
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $querystring = $conn->httpRequest->getUri()->getQuery();
        parse_str($querystring,$queryarray);
        $conn->this_user_id = $queryarray['user_id'];
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
//        $numRecv = count($this->clients) - 1;
//        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
//            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $msg = json_decode($msg);
        if ($msg->type == "user") {
            DB::table('messages')->insert([
                'content' => $msg->text,
                'from' => $msg->sender_id,
                'to' => $msg->receiver_id
            ]);
        } else {
            $group_msg = new GroupMessage();
            $group_msg->content = $msg->text;
            $group_msg->from = $msg->sender_id;
            $group_msg->to_group_id = $msg->receiver_id;
            $group_msg->save();
//            DB::table('group_messages')->insert([
//                'content' => $msg->text,
//                'from' => $msg->sender_id,
//                'to_group_id' => $msg->receiver_id
//            ]);
        }
        foreach ($this->clients as $client) {
            if ($msg->type == "user") {
                if ($from !== $client && $client->this_user_id == $msg->receiver_id) {
                    // The sender is not the receiver, send to each client connected
                    $client->send(json_encode($msg));
                }
            } else {
                if ($from !== $client && in_array($client->this_user_id, $this->usersIdInGroup($msg->receiver_id))) {
                    // The sender is not the receiver, send to each client connected
//                    echo sprintf('123');
                    $client->send(json_encode($msg));
                }
            }
        }
    }

    public function usersIdInGroup($group_id)
    {
        $user_ids_in_group = DB::table('group_users')->select('user_id')->where('group_id', $group_id)->get();
        $arr = [];
        foreach ($user_ids_in_group as $item) {
            array_push($arr, $item->user_id);
        }
        return $arr;
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}