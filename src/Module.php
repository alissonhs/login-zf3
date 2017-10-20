<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Login;

use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module {

    const VERSION = '3.0.3-dev';

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig() {
        
    }

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getServiceManager()->get('EventManager');
        $eventManager->getSharedManager()->attach(
                'Zend\Mvc\Controller\AbstractActionController', MvcEvent::EVENT_DISPATCH,
                [$this, 'verificaLogin'], 100);
    }

    public function verificaLogin($e) {
        $controller = $e->getTarget();
        $rota = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
        if ($rota != 'login' && $rota != 'login/default') {
            $sessao = new Container('Auth');
            if (!$sessao->admin) {
                return $controller->redirect()->toRoute('login');
            }
        }
    }

}
