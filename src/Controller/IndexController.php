<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Login\Controller;

use Login\Form\FormLogin;
use Login\Model\LoginAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    private $form;

    public function __construct() {
        $this->form = new FormLogin();
    }

    public function indexAction() {

        $this->form->setAttributes([
            'method' => 'POST',
            'action' => '/login/login'
        ]);
        $this->form->prepare();
        $viewModel = new ViewModel(['form' => $this->form]);
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function loginAction() {
        $view = new ViewModel(['form' => $this->form]);
        $view->setTerminal(true);
        $view->setTemplate("/login/index/index");
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->form->setData($request->getPost());
            if ($this->form->isValid()) {
                $auth = new AuthenticationService();
                $adapter = new LoginAdapter(
                        $request->getPost('login'), $request->getPost('senha'));
                $result = $auth->authenticate($adapter);
                if ($result->getCode() == Result::SUCCESS) {
                    $sessao = new Container('Auth');
                    $sessao->admin = true;
                    $sessao->identity = $result->getIdentity();
                    $this->redirect()->toRoute("home");
                } else {
                    $view->setVariable("erros", $result->getMessages());
                }
            }
        }
        return $view;
    }

    public function logoutAction() {
        $sessao = new Container;
        $sessao->getManager()->getStorage()->clear();
        return $this->redirect()->toRoute('login');
    }

}
