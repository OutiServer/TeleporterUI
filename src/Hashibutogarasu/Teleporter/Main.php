<?php

declare(strict_types=1);

namespace Hashibutogarasu\Teleporter;

use Hashibutogarasu\Teleporter\Model\YmlArrayParser;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

use Vecnavium\FormsUI\SimpleForm;

class Main extends PluginBase implements Listener
{

    public function onLoad(): void
    {
        $this->getLogger()->info(TextFormat::WHITE . "I've been loaded!");
    }

    public function onEnable(): void
    {
        $this->getLogger()->info(TextFormat::DARK_GREEN . "I've been enabled!");
    }

    public function onDisable(): void
    {
        $this->getLogger()->info(TextFormat::DARK_RED . "I've been disabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {
            case "teleportui":
                $yml = yaml_parse_file($this->getDataFolder() . 'teleporter_map.yml');
                $this->teleporterform($sender, $yml);
                return true;
            default:
                throw new \AssertionError("This line will never be executed");
        }
    }

    public function teleporterform($player, $model)
    {
        $model = array($model);
        $array = $model[0]["map"];

        $form = new SimpleForm(function (Player $player, int $data = null) {
            if ($data === null) {
                return true;
            }
            $selecteditem = YmlArrayParser::getSelecteditem($data);
            YmlArrayParser::$current_item = $selecteditem;

            foreach ($selecteditem as $key => $value) {
                if(array_key_exists("map",$value)){
                    $this->teleporterform($player,$value);
                }
                else{
                    $pos = $value["pos"];

                    $player->teleport(new Vector3($pos[0],$pos[1],$pos[2]));
                }
            }
        });

        $form->setTitle("§lTeleporter Menu");
        new YmlArrayParser($array);
        foreach ($array as $key => $value) {
            foreach ($model[0]["map"][$key] as $key2 => $value2) {
                $hasChild = array_key_exists("map", $value2);
                $displayname = $value2["displayname"];
                if (!$hasChild) {
                    $pos = $value2["pos"];
                    $posx = $pos[0];
                    $posy = $pos[1];
                    $posz = $pos[2];

                    $form->addButton("§l$displayname\n§r§dTeleport to $posx $posy $posz", 0, "");

                    YmlArrayParser::$itemscount = YmlArrayParser::$itemscount + 1;
                } else {
                    foreach ($value2["map"] as $key => $value3) {
                        YmlArrayParser::$childitemscount = YmlArrayParser::$childitemscount + 1;
                    }

                    $form->addButton("§l$displayname");
                }
            }
        }

        // $form->addButton("§lWithdraw Money\n§r§dClick to withdraw...", 0, "textures/ui/icon_book_writable");
        // $form->addButton("§lDeposit Money\n§r§dClick to deposit...", 0, "textures/items/map_filled");
        // $form->addButton("§lTransfer Money\n§r§dClick to transfer...", 0, "textures/ui/FriendsIcon");
        // $form->addButton("§lTransactions\n§r§dClick to open...", 0, "textures/ui/lock_color");
        // $form->addButton("§l§cEXIT\n§r§dClick to close...", 0, "textures/ui/cancel");
        $player->sendForm($form);
        return $form;
    }
}
