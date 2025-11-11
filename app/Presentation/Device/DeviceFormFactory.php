<?php

declare(strict_types=1);

namespace App\Form;

use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class DeviceFormFactory {

    public function default(): Form {
        $form = new Form();
        $form->setHtmlAttribute("novalidate");
        $form->addText('interface',"interface")->setRequired(true)->setHtmlAttribute("readonly","readonly")->setHtmlAttribute("class","form-control");
        $form->addText('protocol',"protocol")->setRequired(true)->setHtmlAttribute("readonly","readonly")->setHtmlAttribute("class","form-control");
        $form->addText('name',"name")->setRequired(true)->setHtmlAttribute("readonly","readonly")->setHtmlAttribute("class","form-control");
        $form->addText('service',"service")->setRequired(true)->setHtmlAttribute("readonly","readonly")->setHtmlAttribute("class","form-control");
        $form->addText('domain',"domain")->setRequired(true)->setHtmlAttribute("readonly","readonly")->setHtmlAttribute("class","form-control");
        $form->addText('host',"host")->setRequired(true)->setHtmlAttribute("readonly","readonly")->setHtmlAttribute("class","form-control");
        $form->addText('ip',"ip")->setRequired(true)->setHtmlAttribute("readonly","readonly")->setHtmlAttribute("class","form-control");
        $form->addText('port',"port")->setRequired(true)->setHtmlAttribute("readonly","readonly")->setHtmlAttribute("class","form-control");
        $form->addText('info',"info")->setRequired(true)->setHtmlAttribute("readonly","readonly")->setHtmlAttribute("class","form-control");
        $form->addText('attributes',"attributes")->setRequired(true)->setHtmlAttribute("readonly","readonly")->setHtmlAttribute("class","form-control");
        $form->addText('user',"user")->setHtmlAttribute("class","form-control");
        $form->addText('password',"password")->setHtmlAttribute("class","form-control");
        $form->addProtection();
        return $form;
    }

}
