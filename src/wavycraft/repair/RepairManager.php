<?php

declare(strict_types=1);

namespace wavycraft\repair;

use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\item\Armor;

use pocketmine\player\Player;

use pocketmine\utils\SingletonTrait;

use wavycraft\core\economy\MoneyManager;//core plugin which will not be released anytime soon...

final class RepairManager {
    use SingletonTrait;

    public const REPAIR_COST = 100;

    public const REPAIR_SUCCESS = 0;
    public const INSUFFICIENT_FUNDS = 1;
    public const UNREPAIRABLE_ITEM = 2;

    public function repairItem(Player $player) : int{
        $heldItem = $player->getInventory()->getItemInHand();
        $moneyManager = MoneyManager::getInstance();
        
        if (
            !$heldItem->isNull() &&
            $heldItem instanceof Item &&
            $heldItem instanceof Durable &&
            ($heldItem instanceof Tool || $heldItem instanceof Armor)
        ) {
            $playerBalance = $moneyManager->getBalance($player);

            if ($playerBalance >= self::REPAIR_COST) {
                $moneyManager->removeMoney($player, self::REPAIR_COST);
                $heldItem->setDamage(0);
                $player->getInventory()->setItemInHand($heldItem);
                return self::REPAIR_SUCCESS;
            } else {
                return self::INSUFFICIENT_FUNDS;
            }
        }

        return self::UNREPAIRABLE_ITEM;
    }
}