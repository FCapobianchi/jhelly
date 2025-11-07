<?php

declare(strict_types=1);

namespace App\Presentation\Device;

use App\Core\mDNSDiscoveryService;
use App\Core\RequireLoggedUser;
use Nette;

final class DevicePresenter extends Nette\Application\UI\Presenter {
    
    use RequireLoggedUser;

    public function __construct(private mDNSDiscoveryService $mDNS) {
        
    }

    public function handleFindDevices():void {
        $devices = $this->mDNS->getDevices();
        $this->template->devices = $devices;
        $this->redrawControl('deviceSnippet');
    }

}
