<?php

namespace App\Model;

use Nette;
use Nette\Database\Explorer;
use App\Model\JhellyFacade;
use Nette\Database\Table\Selection;

final class DeviceFacade {

    public function __construct(private Explorer $database) { }

    public function getDevices():Selection {
        return $this->database->table("devices");
    }
}
