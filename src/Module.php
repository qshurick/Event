<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 11.08.14
 * Time: 15:38
 */

namespace Event;


use Zend\EventManager\EventManager;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;

class Module implements InitProviderInterface {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Initialize workflow
     *
     * @param  ModuleManagerInterface $manager
     * @return void
     */
    public function init(ModuleManagerInterface $manager) {
        $config = $manager->getEvent()->getParam('ServiceManager')->get('Config');
        if (isset($config['dao-events'])) {
            $eventsConfig = $config['dao-events'];
            $eventMap = array();
            if (isset($eventsConfig['mapper'])) {
                $eventMap = $eventsConfig['mapper'];
            }
            $eventManager = new Manager($eventMap, new EventManager());
            if (isset($eventsConfig['listeners'])) {
                foreach ($eventsConfig['listeners'] as $eventAlias => $listeners) {
                    foreach ($listeners as $listener) {
                        $eventManager->attach($eventAlias, $listener);
                    }
                }
            }
            StaticManager::setStaticManager($eventManager);
        }
    }
}