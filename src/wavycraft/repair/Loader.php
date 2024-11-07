<?php

declare(strict_types=1);

namespace wavycraft\repair;

use pocketmine\plugin\PluginBase;

final class Loader extends PluginBase {

    protected function onEnable() : void{
        $this->getServer()->getCommandMap()->register("Repair", new RepairCommand());
    }
}