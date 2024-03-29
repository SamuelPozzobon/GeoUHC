<?php

#Plugin Traducido al Español por @visito66

namespace FRISCOWZ;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\entity\Effect;
use pocketmine\block\IronOre;
use pocketmine\block\GoldOre;
use pocketmine\block\Sand;
use pocketmine\block\Gravel;
use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\level\Position;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\command\Command;
use pocketmine\level\Level;
use pocketmine\scheduler\CallbackTask;
use pocketmine\scheduler\PluginTask;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;


class Main extends PluginBase implements Listener {
public $pvp;
    public $prefix = TextFormat::DARK_GRAY . "[" . TextFormat::RED . "§bUHC" . TextFormat::DARK_GRAY . "] " . TextFormat::GRAY;
    public $globalmute = false;
    public $spam = [];
   public function onEnable() {
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask(array($this, "Cord")), 0);
    		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask(array($this, "Alive")), 20 * 60);
    		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask(array($this, "msg")), 20 * 120);
    $this->pvp = FALSE;
   }
	public function Cord(){
	foreach($this->getServer()->getOnlinePlayers() as $player){
	if($player->getInventory()->getItemInHand()->getId() == "345") {
	$x = $player->getFloorX();
	$y = $player->getFloorY();
	$z = $player->getFloorZ();
 	$player->sendPopup($this->prefix . "§3X: §7$x §3Y: §7$y §3Z: §7$z");
}
}
}
public function Alive (){
	foreach($this->getServer()->getOnlinePlayers() as $p){
		$p->sendTip($this->prefix .  "§7 Diviertete en El UHC :3");
	}	
}
public function msg (){

 foreach($this->getServer()->getOnlinePlayers() as $p){

$p->sendMessage($this->prefix . "¿Quieres revisar tus coords? Usa la brújula que te fue dada al principio!");
}
}
  	
  public function onBreak(BlockBreakEvent $event) {
    if($event->getBlock()->getId() == 15) {
      $drops = array(Item::get(265, 0, 2));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 17) {
      $drops = array(Item::get(5, 0, 4));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 14) {
      $drops = array(Item::get(266, 0, 3));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 18) {
      $drops = array(Item::get(260, 0, 1));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 56) {
      $drops = array(Item::get(264, 0, 1));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 83) {
      $drops = array(Item::get(116, 0, 1));
      $event->setDrops($drops);
    }
    if($event->getBlock()->getId() == 16) {
      $drops = array(Item::get(50, 0, 4));
      $event->setDrops($drops);
    }
  }
public function onJoin(PlayerJoinEvent $event){
$player = $event->getPlayer();
$name = $player->getName();
$this->getServer()->broadcastPopup("§a[UHC] §a+ ".$event->getPlayer()->getName()." joined.");
$event->setJoinMessage("");
}
public function onQuit(PlayerQuitEvent $event){
$player = $event->getPlayer();
$name = $player->getName();
$this->getServer()->broadcastPopup("§a[UHC] §4- ".$event->getPlayer()->getName()." left.");
$event->setQuitMessage("");
}
public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {

	$cmd = strtolower($cmd->getName());
$players = $sender->getName();
	switch($cmd){
case 'uhc':
if ($sender->isOp()){
switch($args[0]){

case "reset":
foreach($this->getServer()->getOnlinePlayers() as $p){
$p->setMaxHealth(20);
$p->setHealth(20);
$p->setFood(20);
$p->setGamemode(0);
$p->getInventory()->clearAll();
$p->removeAllEffects();
}
$this->getServer()->broadcastMessage(" §7El UHC ha sido Reseteado !");
return true;
break;

case "help":
$sender->sendMessage("§7<< §bUHC Edit By @visito66 §7>> ");
$sender->sendMessage("§b/uhc reset: §7Restablece el UHC!");
$sender->sendMessage("§b/uhc meetup: §7Da Kit Meetup");
$sender->sendMessage("§b/uhc start: §7 Enpieza El UHC");
$sender->sendMessage("§b/uhc tpall: §7Tpall Hacia ti");
$sender->sendMessage("§b/uhc food: §7Da 64 filetes a todos los jugadores!");
$sender->sendMessage("§b/uhc pvp <on/off>: §7Habilita y deshabilita  PvP!");
$sender->sendMessage("§b/uhc scenario <hero>: §7Selecciona un escenario!");

$sender->sendMessage("§b/uhc globalmute: §7Silencia a todos los no ops!");
return true;
break;
case "pvp":
if($args[1] == "on"){
 $this->pvp = TRUE;
 $this->getServer()->broadcastMessage("§7PvP activado!");
 
   
 }

 If($args[1] == "off"){
$this->pvp = FALSE;
 $this->getServer()->broadcastMessage("§7PvP desactivado");
}
return true;
break;

case "scenario":
if($args[1] == "hero"){
 $this->getServer()->broadcastMessage("§7El escenario es §b...!");
 $this->getServer()->broadcastMessage("§7Se le ha dado un efecto al azar!");
 foreach($this->getServer()->getOnlinePlayers() as $p){
 	           $kit = rand(1, 2);
 	           $speed = Effect::getEffect($kit);
                    $speed->setAmplifier(1);
                    $speed->setVisible(true);
                    $speed->setDuration(1000000);
                    $p->addEffect($speed);
   }
 }
return true;
break;
 case "meetup":
foreach($this->getServer()->getOnlinePlayers() as $p){
$p->getInventory()->clearAll();
$p->getInventory()->addItem(Item::get(276, 0, 1));
$p->getInventory()->addItem(Item::get(ITEM::GOLDEN_APPLE, 0, 6));
$p->getInventory()->addItem(Item::get(ITEM::GOLDEN_APPLE, 0, 3));
$p->getInventory()->addItem(Item::get(257, 0, 1));
$p->getInventory()->addItem(Item::get(364, 0, 64));
$p->getInventory()->addItem(Item::get(ITEM::BOW, 0, 1));
$p->getInventory()->addItem(Item::get(ITEM::ARROW, 0, 32));
$p->getInventory()->addItem(Item::get(346, 0, 1));

$p->getInventory()->setHelmet(Item::get(310, 0, 1));
$p->getInventory()->setChestplate(Item::get(311, 0, 1));
$p->getInventory()->setLeggings(Item::get(312, 0, 1));
$p->getInventory()->setBoots(Item::get(313, 0, 1));
$p->getInventory()->sendArmorContents($p);
}	            
$this->getServer()->broadcastMessage("§7Se le ha dado el kit Meetup!");
return true;
break;


case "start":
foreach($this->getServer()->getOnlinePlayers() as $p){
$p->getInventory()->clearAll();

$p->getInventory()->addItem(Item::get(257, 0, 1));
$p->getInventory()->addItem(Item::get(364, 0, 64));
$p->getInventory()->addItem(Item::get(50, 0, 16));
$p->getInventory()->addItem(Item::get(345, 0, 1));


$p->getInventory()->setBoots(Item::get(301, 0, 1));
$p->getInventory()->sendArmorContents($player);
}	            

$this->getServer()->broadcastMessage("§7¡UHC que comienza en 10 segundos! §cNO Se Valla.");
Sleep(10);
$this->getServer()->broadcastMessage(" §7¡El UHC ha comenzado!");
return true;
break;


case "food":
foreach($this->getServer()->getOnlinePlayers() as $p){
$p->getInventory()->addItem(Item::get(364, 0, 64));
$this->getServer()->broadcastMessage(" §7Se le ha dado 64 filetes.");
}
return true;
break;
///GlobalMute///

            case "globalmute":
                if ($sender->hasPermission("UHC.host")) {
                    if ($this->globalmute === false) {
                        $this->getServer()->broadcastMessage($this->prefix . TextFormat::GRAY . "Global Mute Ha sido activado!");
                        $this->globalmute = true;
                        return true;
                    } else {
                        $this->getServer()->broadcastMessage($this->prefix . TextFormat::GRAY . "Global Mute ha sido desactivado.");
                        $this->globalmute = false;
                        return true;
                    }
                }


case "tpall":
foreach($this->getServer()->getOnlinePlayers() as $p){
$p->teleport(new Vector3($sender->x, $sender->y, $sender->z));
$this->getServer()->broadcastMessage(" §7Teleportando...");
}
return true;
break;

}
}else{
	$sender->sendMessage("§cNo tienes permitido hacer esto.");
}
return true;
break;

}
}
    public function onPlayerDeath(PlayerDeathEvent $event)
    {
        $player = $event->getPlayer();
        $player->setGamemode(3);
        if ($player instanceof Player) {
            $cause = $player->getLastDamageCause();
            if ($cause instanceof EntityDamageByEntityEvent) {
                $killer = $cause->getDamager();
                $killer->setHealth($killer->getHealth() + 10);
                $killer->sendMessage("ha resivido  §c10 <3 §7de vida");
                $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " was killed by " . $killer->getName() . ".");
            } else {
                $cause = $player->getLastDamageCause()->getCause();
                if($cause === EntityDamageEvent::CAUSE_SUFFOCATION)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " suffocated.");
                } elseif ($cause === EntityDamageEvent::CAUSE_DROWNING)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " drowned.");
                } elseif ($cause === EntityDamageEvent::CAUSE_FALL)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " fell to hard.");
                } elseif ($cause === EntityDamageEvent::CAUSE_FIRE)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " burned.");
                } elseif ($cause === EntityDamageEvent::CAUSE_FIRE_TICK)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " burned.");
                } elseif ($cause === EntityDamageEvent::CAUSE_LAVA)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " tried to swim in lava.");
                } elseif ($cause === EntityDamageEvent::CAUSE_BLOCK_EXPLOSION)
                {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " explode.");
                } else {
                    $event->setDeathMessage($this->prefix . TextFormat::RED . $player->getName() . " died.");
                }
            }
        }
    }
////Mute and Grade////
    public function onChat(PlayerChatEvent $event)
    {
        $player = $event->getPlayer();
        if ($this->globalmute === true) {
            if (!$event->getPlayer()->hasPermission("UHC.host")) {
                $event->setCancelled();
                $player->sendMessage($this->prefix . "§7You cannot chat while Global Mute has been enabled!");
            }
        } else {
            if(!$player->hasPermission("UHC.host"))
            {
                if(!isset($this->spam[$player->getName()]))
                {
                    $lastTime = 0;
                } else {
                    $lastTime = $this->spam[$player->getName()];
                }
                if(time() - $lastTime > 5)
                {
                    $this->spam[$player->getName()] = time();
                } else {
                    $event->setCancelled(true);
                    $player->sendMessage($this->prefix . TextFormat::GRAY . "No  spam Papoh :v.");
                }
            }


            if($player->hasPermission("UHC.group.Owner"))
            {
                $event->setFormat(TextFormat::WHITE . "[" . TextFormat::DARK_RED . "Owner" . TextFormat::WHITE . "] " . TextFormat::LIGHT_PURPLE . $player->getName() . ": " . TextFormat::GRAY . $event->getMessage());
            } elseif($player->hasPermission("UHC.group.Host"))
            {
                $event->setFormat(TextFormat::WHITE . "[" . TextFormat::DARK_RED . "Host" . TextFormat::WHITE . "] " . TextFormat::LIGHT_PURPLE . $player->getName() . ": " . TextFormat::GRAY . $event->getMessage());
            } elseif($player->hasPermission("UHC.group.Owner"))
            {
                $event->setFormat(TextFormat::WHITE . "[" . TextFormat::DARK_RED . "Owner" . TextFormat::WHITE . "] " . TextFormat::LIGHT_PURPLE . $player->getName() . ": " . TextFormat::GRAY . $event->getMessage());
            } elseif($player->hasPermission("UHC.group.Admin"))
            {
                $event->setFormat(TextFormat::WHITE . "[" . TextFormat::RED . "Admin" . TextFormat::WHITE . "] " . TextFormat::LIGHT_PURPLE . $player->getName() . ": " . TextFormat::GRAY . $event->getMessage());
            } elseif($player->hasPermission("UHC.group.Dev"))
            {
                $event->setFormat(TextFormat::WHITE . "[" . TextFormat::RED . "Dev" . TextFormat::WHITE . "] " . TextFormat::LIGHT_PURPLE . $player->getName() . ": " . TextFormat::GRAY . $event->getMessage());
            } elseif($player->hasPermission("UHC.group.Mod"))
            {
                $event->setFormat(TextFormat::WHITE . "[" . TextFormat::DARK_AQUA . "Mod" . TextFormat::WHITE . "] " . TextFormat::LIGHT_PURPLE . $player->getName() . ": " . TextFormat::GRAY . $event->getMessage());
            } elseif($player->hasPermission("UHC.group.Trainee"))
            {
                $event->setFormat(TextFormat::WHITE . "[" . TextFormat::GREEN . "Trainee" . TextFormat::WHITE . "] " . TextFormat::LIGHT_PURPLE . $player->getName() . ": " . TextFormat::GRAY . $event->getMessage());
            } elseif($player->hasPermission("UHC.group.Helper"))
            {
                $event->setFormat(TextFormat::WHITE . "[" . TextFormat::GREEN . "Helper" . TextFormat::WHITE . "] " . TextFormat::LIGHT_PURPLE . $player->getName() . ": " . TextFormat::GRAY . $event->getMessage());
            } elseif($player->hasPermission("UHC.group.YouTube"))
            {
                $event->setFormat(TextFormat::WHITE . "[" . TextFormat::RED . "YouTube" . TextFormat::WHITE . "] " . TextFormat::LIGHT_PURPLE . $player->getName() . ": " . TextFormat::GRAY . $event->getMessage());
            } else {
                $event->setFormat(TextFormat::WHITE . $player->getName() . ": " . TextFormat::GRAY . strtolower($event->getMessage()));
            }
        }
    }



    }
