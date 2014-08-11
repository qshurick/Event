<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 11.08.14
 * Time: 12:24
 */

namespace Event;


use Zend\EventManager\EventInterface;

interface FactoryInterface {
    /**
     * @param array $params
     * @return EventInterface
     */
    public function getEventFor($params = array());
} 