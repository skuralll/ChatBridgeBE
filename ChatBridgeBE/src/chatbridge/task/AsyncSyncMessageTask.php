<?php

namespace chatbridge\task;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;

use chatbridge\provider\SettingProvider;

class AsyncSyncMessageTask extends AsyncTask
{

	private $result;
	private $url;

	public function __construct()
	{
		$this->url = SettingProvider::get()->getURL();
	}

	public function onRun()
	{
        $content = [
                    'type' => 'get'
                ];

        $options = [
                'http' => [
                              'method' => 'POST',
                              'header' => 'Content-Type: application/json',
                              'content' => json_encode($content),
                              'timeout' => 2
                        ]
                    ];
        $options['ssl']['verify_peer']=false;
        $options['ssl']['verify_peer_name']=false;
        @$this->result = file_get_contents($this->url, false, stream_context_create($options));
	}

	public function onCompletion(Server $server)
	{
		if($this->result === false) $server->getLogger()->info("§cDiscordBotとの接続に失敗しました");
		else
		{
			foreach (json_decode($this->result, true) as $value)
			{
				$server->broadcastMessage('[' . $value['user'] . ' ｜ §bDiscord§f] ' . $value['message']);	
			}
		}
	}

}