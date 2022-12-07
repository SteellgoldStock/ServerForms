<?php

namespace steellgold\serverforms;

use pocketmine\plugin\PluginBase;
use steellgold\serverforms\listeners\PlayerListeners;

class SF extends PluginBase {

	public static $instance;

	protected function onEnable(): void {
		self::$instance = $this;
		$this->saveDefaultConfig();
		$this->getServer()->getPluginManager()->registerEvents(new PlayerListeners(), $this);
	}

	protected function onDisable(): void {

	}

	/**
	 * @return mixed
	 */
	public static function getInstance() {
		return self::$instance;
	}
}