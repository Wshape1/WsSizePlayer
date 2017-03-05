<?php

namespace WsSizePlayer;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\entity\Entity;
use pocketmine\event\player\PlayerRespawnEvent;

class WMain extends PluginBase implements Listener{

public $WSize=array();

public function onEnable(){
$this->getServer()->getPluginManager()->registerEvents($this, $this);
$this->getLogger()->info("§8[§6WsSizePlayer§8] §aPlugin is loaded!");
}
public function Respawn(PlayerRespawnEvent $event){
$player=$event->getPlayer();
if(!empty($this->WSize[$player->getName()])){
$player->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT,1);
}
}

public function onCommand(CommandSender $sender, Command $command, $label, array $args){
if(!$sender instanceof Player) return $sender->sendMessage("§c请在游戏内使用");
switch($command->getName()){
case "wsize":
if($sender->isOP()){
if(!isset($args[0])){
$sender->sendMessage("§8[§6WsSizePlayer§8]\n§b/wsize <Size> \n§b/wsizep <Player> <Size>\n§b#Size填1就是原尺寸");
return true;
}elseif(isset($args[0]) and !isset($args[1])){
if(is_numeric($args[0])){
$this->WSize[$sender->getName()]=$args[0];
$sender->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT,$args[0]);
$sender->sendMessage("§8[§6WsSizePlayer§8]§e成功将你的尺寸改为 ".$args[0]);
return true;
}else{
$sender->sendMessage("§8[§6WsSizePlayer§8]§cSize必须是一个数字");
return true;
}
}
}else{
$sender->sendMessage("§c你没有权限使用此命令!");
return true;
}
 case "wsizep":
 if($sender->isOP()){
if(!isset($args[0])){
$sender->sendMessage("§8[§6WsSizePlayer§8]\n§b/wsize <Size> \n§b/wsizep <Player> <Size>\n§b#Size填1就是原尺寸");
return true;
}elseif(isset($args[1]) and !isset($args[2])){
if(is_numeric($args[1])){
$ta=$this->getServer()->getPlayerExact($args[0]);
if($ta !== null){
$ta->setDataProperty(Entity::DATA_SCALE, Entity::DATA_TYPE_FLOAT,$args[1]);
$sender->sendMessage("§8[§6WsSizePlayer§8]§e成功将 {$args[0]} 的尺寸改为 ".$args[1]);
$ta->sendMessage("§8[§6WsSizePlayer§8]§eOP {$sender->getName()} 将你的尺寸改为 ".$args[1]);
return true;
}else{
$sender->sendMessage("§8[§6WsSizePlayer§8]§e玩家 {$args[0]} 不存在");
return true;
}
}else{
$sender->sendMessage("§8[§6WsSizePlayer§8]§cSize必须是一个数字");
return true;
}
}
}else{
$sender->sendMessage("§c你没有权限使用此命令!");
return true;
}
}
}
}
