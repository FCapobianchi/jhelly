<?php

declare(strict_types=1);

namespace App\Core;

/** VERIFICA CHE L'UTENTE SIA LOGGATO TRAMITE INJECTION SULLA FUNCTION STARTUP DEL PRESENTER */
trait RequireLoggedUser {

    public function injectRequireLoggedUser(): void {

        $this->onStartup[] = function () {
            if (!$this->getUser()->isLoggedIn()) {
                $this->redirect('Sign:default', ['backlink' => $this->storeRequest()]);
            }
        };

    }
    
}
