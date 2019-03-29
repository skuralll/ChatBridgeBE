<?php

namespace chatbridge\task;

use pocketmine\plugin\Plugin;
use pocketmine\scheduler\Task;

class SyncMessageTask extends Task
{

	public function __construct(Plugin $plugin)
	{
		$this->plugin = $plugin;
	}

	public function onRun(int $Tick)
	{
		$this->plugin->getServer()->getAsyncPool()->submitTask(new AsyncSyncMessageTask());
	}

}