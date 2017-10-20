<?php

namespace Login\Form;

/**
 * Description of FormLogin
 *
 * @author Adriano Barbosa
 */
class FormLogin extends \Zend\Form\Form {

    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $this->setName('login');
        $this->setAttributes(['class'=>'form-signin']);
        $login = new \Zend\Form\Element\Text('login');
        $login->setLabel('Usuário');
        $login->setAttributes(["class" => "form-control","placeholder"=>'Usuário']);
        $this->add($login);
        $senha = new \Zend\Form\Element\Password('senha');
        $senha->setLabel('Senha');
        $senha->setAttributes(["class"=>"form-control",'placeholder'=>'senha']);
        $this->add($senha);
        $submit = new \Zend\Form\Element\Submit('submit');
        $submit->setAttribute("class", "btn btn-primary");
        $submit->setValue("Entrar")
                ->setAttribute('id', 'submitbutton');
        $this->add($submit);
    }

}
