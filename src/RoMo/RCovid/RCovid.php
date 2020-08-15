<?php

namespace RoMo\RCovid;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Internet;
class RCovid extends PluginBase implements Listener{
	public function onEnable(){
		@mkdir($this->getDataFolder());
		$this->key = new Config($this->getDataFolder(). 'setting.yml', Config::YAML, ['key' => '']);
		$this->kd = $this->key->getAll();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function Join(PlayerJoinEvent $event){
		if(!empty($this->kd['key'])){
			$url = 'http://api.corona-19.kr/korea/country/new/?serviceKey='. $this->kd['key'];
			$data = (array) json_decode(Internet::getURL($url));
			$korea = (array) $data['korea'];
			$newcase = $korea['newCcase'];
			$heal = $korea['recovered'];
			$player = $event->getPlayer();
			$player->sendMessage("§e==============");
			$player->sendMessage("§n§4[§fCOVID§4]§f§r오늘 §c코로나19 §f확진자 수는§6 ". $newcase ."명§f입니다.");
			$player->sendMessage("§n§4[§fCOVID§4]§f§r총 §b완치자 수§f는§6 ". $heal ."명§f입니다.");
			$player->sendMessage("§e==============");
		}
	}
}
