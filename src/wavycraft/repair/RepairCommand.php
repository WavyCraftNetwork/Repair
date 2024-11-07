<?php

declare(strict_types=1);

namespace wavycraft\repair;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\player\Player;

use pocketmine\utils\TextFormat as TextColor;

class RepairCommand extends Command {

    public function __construct() {
        parent::__construct("repair");
        $this->setDescription("Repairs the item in your hand");
        $this->setPermission("repair.cmd");
    }

    public function execute(CommandSender $sender, string $label, array $args) : bool{
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game...");
            return false;
        }

        $repairResult = RepairManager::getInstance()->repairItem($sender);

        switch ($repairResult) {
            case RepairManager::REPAIR_SUCCESS:
                $sender->sendMessage(TextColor::GREEN . "Your item has been repaired for $" . RepairManager::REPAIR_COST);
                break;

            case RepairManager::INSUFFICIENT_FUNDS:
                $sender->sendMessage(TextColor::RED . "You do not have enough money to repair this item. You need $" . RepairManager::REPAIR_COST . "...");
                break;

            case RepairManager::UNREPAIRABLE_ITEM:
                $sender->sendMessage(TextColor::RED . "You are not holding a repairable item...");
                break;
        }

        return true;
    }
}