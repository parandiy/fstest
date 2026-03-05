<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQPublisher
{
    public function publish(array $payload): void
    {
        $connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password')
        );

        $channel = $connection->channel();

        $channel->queue_declare('file_deleted', false, true, false, false);

        $msg = new AMQPMessage(json_encode($payload));

        $channel->basic_publish($msg, '', 'file_deleted');

        $channel->close();
        $connection->close();
    }
}
