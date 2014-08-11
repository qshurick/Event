<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 11.08.14
 * Time: 12:15
 */

namespace Event;


class StaticManager {
    /** @var Manager */
    protected static $instance;

    /**
     * @return Manager
     * @throws \Exception
     */
    public static function getInstance() {
        if (!static::$instance)
            throw new \Exception(__CLASS__ . " wasn't initialized");
        return static::$instance;
    }

    /**
     * @param Manager $manager
     * @throws \Exception
     */
    public static function setStaticManager(Manager $manager) {
        if (static::$instance)
            throw new \Exception(__CLASS__ . " already initialized");
        static::$instance = $manager;
    }
} 