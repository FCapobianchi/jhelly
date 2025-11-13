<?php

declare(strict_types=1);

namespace App\Presentation\Device;

use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
use App\Core\JhellyAPI;
use App\Core\mDNSDiscoveryService;
use App\Core\RequireLoggedUser;
use App\Form\DeviceFormFactory;
use App\Model\DeviceFacade;

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
        $this->setView("form");
        if($this->template->error??false) {
            $this->flashMessage($this->template->error, "alert-danger");
        }
    }

    protected function createComponentDeviceForm(): form {
        $form = (new DeviceFormFactory)->default();
        $id = $this->getParameter("id");
        
        if($id) {
            $device = $this->model->get($id);
            $form->setDefaults($device);
        } else {
            $device = $this->getParameter("device");
            $attributes = $this->getDeviceInfo($device);
            if ($attributes['errno']??false) {
                $form->addError("{$attributes['errno']} - {$attributes['error']}");
                $form->getComponent("submit")->setDisabled(true);
                $attributes = [];
            }
            if ($attributes['auth']??false) {
                $form->getComponent("user")->setRequired(true);
                $form->getComponent("password")->setRequired(true);
            }
            $device["attributes"] = serialize($attributes);
            $info = str_replace('"','',$device['info']);
            $info = explode(" ",$info);
            $device['info'] = serialize($info);
            $form->setDefaults($device);
        }
        
        $form->onValidate[] = $this->deviceFormValidate(...);
        $form->onSuccess[] = $this->deviceFormSuccess(...);
        return $form;
    }

    protected function getDeviceInfo(array $device):array {
        $protocol = ($device['port']==80)?'http':'https';
        $parameters['base_uri'] = "{$protocol}://{$device['host']}:{$device['port']}";
        $jApi = new JhellyAPI($parameters);
        $response = $jApi->shelly();
        return $response->response??[];
    }

    public function deviceFormValidate(Form $form, ArrayHash $values) {
        bdump($values);
    }

    public function deviceFormSuccess(Form $form, ArrayHash $values) {
        bdump($values);
        $id = $this->getParameter("id");
        if($id) {
            $record = $this->model->get($id);
            $record->update($values);
        }
        else {
            $record = $this->model->add($values);
            
        }
        if($record) {
            $this->flashMessage("Data storage OK.","alert-success");
        }
        else {
            $this->flashMessage("Data storage KO.","alert-danger");

        }
        bdump($record);

    }

}
