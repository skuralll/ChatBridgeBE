<?php

namespace chatbridge;

use pocketmine\plugin\PluginBase;

use chatbridge\task\SyncMessageTask;
use chatbridge\provider\ProviderManager;
use chatbridge\provider\SettingProvider;

class Main extends PluginBase {
	
	public function onEnable()
	{
		date_default_timezone_set('Asia/Tokyo');

		ProviderManager::init($this);
		ChatBridgeAPI::init($this);
		$this->getScheduler()->scheduleRepeatingTask(new SyncMessageTask($this), SettingProvider::get()->getSyncInterval());
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);

        ChatBridgeAPI::sendMessage('**❗サーバーが起動しました  **(' . date("m/d H:i") . ')');
	}

	public function onDisable()
	{
		ChatBridgeAPI::sendMessageInstance('**❗サーバーが停止しました  **(' . date("m/d H:i") . ')');
	}

}