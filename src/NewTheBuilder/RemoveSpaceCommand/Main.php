<?php

namespace NewTheBuilder\RemoveSpaceCommand;

use JsonException;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    /**
     * @return void
     * @throws JsonException
     */
    protected function onEnable(): void {

        //Listener
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $config = new Config($this->getDataFolder() . "Config.yml", Config::YAML, [
            "Message" => "§cPlease do not put spaces in your order."
        ]);
        $config->save();

    }

    /**
     * @param PlayerCommandPreprocessEvent $event
     * @return void
     */
    public function RemoveSpaceCommand(PlayerCommandPreprocessEvent $event) {
        $message = $event->getMessage();
        $sender = $event->getPlayer();

        $msg = explode(' ', trim($message));
        $m = substr("$message", 0, 1);
        $whitespace_check = substr($message, 1, 1);
        $slash_check = substr($msg[0], -1, 1);
        $quote_mark_check = substr($message, 1, 1) . substr($message, -1, 1);

        if ($m == '/') {
            if ($whitespace_check === ' ' or $whitespace_check === '\\' or $slash_check === '\\' or $quote_mark_check === '""') {
                $event->cancel();
                $config = new Config($this->getDataFolder() . "Config.yml", Config::YAML);
                $sender->sendMessage($config->get("Message"));
            }
        }
    }
}