<?php

declare(strict_types=1);

namespace App\Presentation\Home;

use Nette;
use App\Core\RequireLoggedUser;
use App\Model\DeviceFacade;
use Nette\Utils\ArrayHash;
use Nette\Database\Table\ActiveRow;

final class HomePresenter extends Nette\Application\UI\Presenter {
    use RequireLoggedUser;
    
    public function __construct(private DeviceFacade $modelDevice) {
    }

    public function renderDefault($id):void {
        $selection = $this->modelDevice->getDevices();
        foreach($selection as $record){
            $array = $record->toArray();
            $array['info'] = unserialize($array['info']);
            $array['attributes'] = unserialize($array['attributes']);
            $device = ArrayHash::from($array);
            $protocol = ($array['port']==80)?'http':'https';
            //$auth = ($device->attributes->auth)?"{$device->user}:{$device->password}@":'';
            //$device->base_uri = "{$protocol}://{$auth}{$device->host}:{$device->port}";
            $device->base_uri = "{$protocol}://{$device->host}:{$device->port}";
            $this->template->devices[]=$device;
        }
    }
}
