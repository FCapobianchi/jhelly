<?php

namespace App\Model;

use Nette;
use Nette\Database\Explorer;

abstract class JhellyFacade {
    public function __construct( private Explorer $database, ) {
        /** EVENTUALI CONFIGURAZIONI */
    }
}
