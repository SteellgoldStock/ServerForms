<?php

namespace steellgold\serverforms\listeners;

use dktapps\pmforms\FormIcon;
use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use steellgold\serverforms\SF;

class PlayerListeners implements Listener {

	public function onPlayerJoinEvent(PlayerJoinEvent $event): void {
		$player = $event->getPlayer();
		$player->sendMessage(str_replace("{player}", $player->getName(), SF::getInstance()->getConfig()->get("messages")["join"]));
		$player->sendForm($this->getHomeForm());
	}

	public function getHomeForm(): MenuForm {
		$arr = [];
		foreach (SF::getInstance()->getConfig()->get("servers") as $key => $value) {
			$arr[$key] = new MenuOption(
				$value["title"] ?? "Unknown",
				$value["icon"] ? new FormIcon($value["icon"]["data"], $value["icon"]["type"]) : null
			);
		}

		return new MenuForm(
			"Choose a server",
			"You need to choose a server for join", $arr,
			function (Player $submitter, int $selected): void {
				$submitter->transfer(
					SF::getInstance()->getConfig()->get("servers")[$selected]["ip"],
					SF::getInstance()->getConfig()->get("servers")[$selected]["port"]
				);
			}
		);
	}
}