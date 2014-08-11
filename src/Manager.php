<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 11.08.14
 * Time: 11:55
 */

namespace Event;


use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManager;

class Manager  {

    /** @var EventManager */
    protected $manager;
    protected $eventMap = array();
    /** @var  \Logger\LoggerInterface */
    protected $logger;

    /**
     * @param array             $eventMap
     * @param null|EventManager $manager
     */
    function __construct($eventMap = array(), $manager = null) {
        $this->eventMap = $eventMap;
        $this->manager = $manager;
        if ($this->manager === null)
            $this->manager = new EventManager();

        $this->logger = \Logger\Logger::getLogger(__CLASS__);
    }

    /**
     * @param string        $eventAlias
     * @param array         $eventParams
     * @param null|callable $callback
     * @throws \Exception
     */
    public function triggerByName($eventAlias, $eventParams = array(), $callback = null) {
        try {
            if (isset($this->eventMap[$eventAlias])) {
                    $factoryClass = $this->eventMap[$eventAlias];
                    $factory = new $factoryClass();
                    if ($factory instanceof FactoryInterface) {
                        $event = $factory->getEventFor($eventParams);
                        $this->manager->trigger($event, null, null, $callback);
                    } else {
                        throw new \Exception("Class '$factoryClass' MUST be an instance of 'FactoryInterface'");
                    }

            } else {
                throw new \Exception("Event alias '$eventAlias' wasn't registered");
            }
        } catch (\Exception $e) {
            $this->logger->error($e);
            throw $e;
        }
    }

    /**
     * @param EventInterface    $event
     * @param null|callable     $callback
     * @throws \Exception
     */
    public function trigger($event, $callback = null) {
        try {
            $this->manager->trigger($event, null, null, $callback);
        } catch (\Exception $ex) {
            $this->logger->error($ex);
            throw $ex;
        }
    }

    /**
     * @param string    $eventAlias
     * @param callable  $callback
     * @param int       $priority
     */
    public function attach($eventAlias, $callback, $priority = 1) {
        $this->manager->attach($eventAlias, $callback, $priority);
    }

}