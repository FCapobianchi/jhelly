<?php

declare(strict_types=1);

namespace App\Presentation\Sign;
use Nette;
use App\Form\SignFormFactory;
use Nette\Forms\Form;
use Nette\Utils\ArrayHash;
use Nette\Security\AuthenticationException;

/* PRESENTER CHE GESTISCE LE PAGINE DI LOGIN / LOGOUT SENZA AUTENTICAZIONE */
final class SignPresenter extends Nette\Application\UI\Presenter  {

    /** CONSTRUCT */
    public function __construct( ) {
        /** GESTIONE CLASSI */
    }

    protected function beforeRender(): void {
        $this->setLayout(dirname(__DIR__).'/@sign.latte');
    }

    /* COMPONENTE CHE GENERA IL FORM */
    protected function createComponentLoginForm(): Form {
        $form = (new SignFormFactory)->login();
        if($this->getParameter("backlink")) {
            $form->getComponent("backlink")->setValue($this->getParameter("backlink"));
        }
        $form->onValidate[] = $this->loginValidate(...);
        $form->onSuccess[] = $this->loginSucceeded(...);
        return $form;
    }

    /* FUNCTION DI VERIFICA DEI PARAMETRI PASSATI DAL FORM */
    public function loginValidate(Form $form, ArrayHash $values): void {

    }

    /* FUNCTION DI LOGIN */
    public function loginSucceeded(Form $form, ArrayHash $values): void {
        try {
            $this->getUser()->login($values->username, $values->password);
            $this->flashMessage('You are logged in.', "alert-success");
            $this->restoreRequest($values->backlink??'');
            $this->redirect('Home:default');
        } catch (AuthenticationException $e) {
            $form->addError("Login or password error.");
        }
    }

    public function renderOut():void {
        $this->getUser()->logout(true);
        $this->flashMessage("You are logged out.", "alert-success");
        $this->redirect(":default");
    }

}
