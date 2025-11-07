<?php

declare(strict_types=1);

namespace App\Form;

use Nette\Application\UI\Form;

class SignFormFactory {

    public function login(): Form {
        $form = new Form;
        //$form->setHtmlAttribute("novalidate");
        $form->addText("username")->setRequired();
        $form->addPassword("password")->setRequired();
        $form->addSubmit('submit');
        $form->addProtection("");
        $form->addHidden("backlink");
        return $form;
    }

}
