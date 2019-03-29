<?php

namespace chatbridge;

use chatbridge\task\AsyncSendTask;
use chatbridge\provider\SettingProvider;

class ChatBridgeAPI
{

    private static $plugin;

    public static function init($plugin)
    {
        self::$plugin = $plugin;
    }

    public static function sendMessage($message)
    {
        $content = [
                    'type' => 'message',
                    'content' => $message
                ];
        self::$plugin->getServer()->getAsyncPool()->submitTask(new AsyncSendTask($content));
    }

    public static function sendMessageInstance($message)
    {
        $options = [
                'http' => [
                              'method' => 'POST',
                              'header' => 'Content-Type: application/json',
                              'content' => json_encode(['type' => 'message', 'content' => $message]),
                              'timeout' => 2
                        ]
                    ];
        $options['ssl']['verify_peer']=false;
        $options['ssl']['verify_peer_name']=false;
        @$result = file_get_contents(SettingProvider::get()->getURL(), false, stream_context_create($options));
        if($result) $server->getLogger()->info("§cDiscordBotとの接続に失敗しました");
    }

    public static function syncMessage()
    {
        self::$plugin->getServer()->getAsyncPool()->submitTask(new AsyncSyncMessageTask());
    }

}