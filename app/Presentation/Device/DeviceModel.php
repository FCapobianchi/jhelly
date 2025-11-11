<?php

namespace App\Model;

use Nette;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

final class DeviceFacade {

    public function __construct(private Explorer $database) { }

    public function getDevices():Selection {
        return $this->database->table("devices");
    }

    public function get($id):ActiveRow {
        return $this->database->table("devices")->where($id)->fetch();
    }
    
}
