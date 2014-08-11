<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 11.08.14
 * Time: 11:49
 */

namespace Event;


abstract class EventStorageAbstract {
    /**
     * @param Manager $manager
     */
    abstract function invokeEvents(Manager $manager);
} 