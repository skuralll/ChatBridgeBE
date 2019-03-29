<?php

namespace chatbridge;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\CommandEvent;

class EventListener implements Listener
{

	private $plugin;

	public function __construct($plugin)
	{
		$this->plugin = $plugin;
	}

	public function onJoin(PlayerJoinEvent $event)
	{
		ChatBridgeAPI::sendMessage('**⭕' . $event->getPlayer()->getName() . 'がログインしました** ' . '(' . count($this->plugin->getServer()->getOnlinePlayers()) . '/' . $this->plugin->getServer()->getMaxPlayers() . ')');
	}

	public function onQuit(PlayerQuitEvent $event)
	{
		ChatBridgeAPI::sendMessage('**❌' . $event->getPlayer()->getName() . 'がログアウトしました** ' . '(' . (count($this->plugin->getServer()->getOnlinePlayers()) - 1) . '/' . $this->plugin->getServer()->getMaxPlayers() . ')');
	}

	public function onChat(PlayerChatEvent $event)
	{
		ChatBridgeAPI::sendMessage('<' . $event->getPlayer()->getName() . '>' . $event->getMessage());
	}

	public function onCommand(CommandEvent $event)
	{
		$sender = $event->getSender();
		$command = $event->getCommand();
		$commandArray = explode(" ", $command);

		switch($commandArray[0])
		{
			case "say":
			case "me":
				array_shift($commandArray);
				$message = implode(" ", $commandArray);
		        ChatBridgeAPI::sendMessage('<' . $sender->getName() . '>' . $message);
				break;
		}
	}

}