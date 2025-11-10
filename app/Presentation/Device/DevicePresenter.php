<?php

declare(strict_types=1);

namespace App\Presentation\Device;

use App\Core\JhellyAPI;
use App\Core\mDNSDiscoveryService;
use App\Core\RequireLoggedUser;
use App\Model\DeviceFacade;
use Nette;
use Nette\Utils\ArrayHash;

final class DevicePresenter extends Nette\Application\UI\Presenter {
    
    use RequireLoggedUser;


    public function __construct(private mDNSDiscoveryService $mDNS, private DeviceFacade $model) {

    }

    public function renderDefault():void {
        $dbDevices = $this->model->getDevices();
        $this->template->dbDevices = $dbDevices;
    }

    public function handleFindDevices():void {
        $devices = $this->mDNS->getDevices();
        $this->template->devices = $devices;
        $this->redrawControl('deviceSnippet');
    }

    public function renderAdd(array|ArrayHash $device):void {
        bdump($device);
        $parameters['base_uri'] = "http://{$device['host']}:{$device['port']}";
        $shellyAPI = new JhellyAPI($parameters);
        bdump($shellyAPI->shelly());

    }

}
