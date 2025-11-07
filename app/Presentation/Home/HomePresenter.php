<?php

declare(strict_types=1);

namespace App\Presentation\Home;

use App\Core\RequireLoggedUser;
use Nette;


final class HomePresenter extends Nette\Application\UI\Presenter {
    use RequireLoggedUser;
    
    public function renderDefault($id):void {

    }
}
