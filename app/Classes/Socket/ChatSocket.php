<?php

namespace App\Classes\Socket;

use App\Classes\Socket\Base\BaseSocket;
use Ratchet\ConnectionInterface;

class ChatSocket extends BaseSocket
{
    protected $clients;

    public function __construct(){
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn){
        echo "trying make a new connection\n";
        $this->clients->attach($conn);

        echo "new connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg){
        $numRecv = count($this->clients) - 1;

        echo sprintf('Connection %d sending message "%s" to %d other connection%s'. "\n",
          $from->resourceId, $msg, $numRecv, $numRecv == 1? '' : 's');

        foreach ($this->clients as $client) {
          if($from != $client){
            $client->send($msg);
          }
        }
    }

    public function onClose(ConnectionInterface $conn){
        $this->clients->detach($conn);

        echo "connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e){
        echo "Ann error has occurred: {$e->getMessage()} {$e->getStack()}\n";
    }


}
