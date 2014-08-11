<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 11.08.14
 * Time: 12:58
 */

namespace Event\Storage;


use Event\EventStorageAbstract;
use Event\Manager;
use Event\StaticManager;
use Event\Storage\Doctrine\Entity\Event;

class Doctrine extends EventStorageAbstract {

    /** @var  \Doctrine\ORM\EntityManager */
    protected $entityManager;

    /**
     * @param Manager $manager
     */
    function invokeEvents(Manager $manager) {
        $repository = $this->entityManager->getRepository('\Event\Storage\Doctrine\Entity');
        $events = $repository->findBy(array(
            'status' => 'created'
        ));
        /** @var Event $event */
        foreach ($events as $event) {
            StaticManager::getInstance()->triggerByName($event->getAlias(), $event->getParams());
            $event->setStatus('processed');
        }
        $this->entityManager->flush();
    }
}