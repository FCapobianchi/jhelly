<?php

namespace App\Model;

use Exception;
use Nette;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Utils\ArrayHash;

final class DeviceFacade {

    public function __construct(private Explorer $database) { }

    public function getDevices():Selection {
        return $this->database->table("devices");
    }

    public function get($id):ActiveRow {
        return $this->database->table("devices")->where($id)->fetch();
    }
    
    public function add(ArrayHash $values):ActiveRow|array|int|bool {
        try {
            $record = $this->database->table("devices")->insert($values);
        }
        catch(Exception $e){
            $record = 0;
        }
        return $record;
    }
}
