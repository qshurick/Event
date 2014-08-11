<?php
/**
 * Created by PhpStorm.
 * User: aleksandr
 * Date: 11.08.14
 * Time: 13:00
 */

namespace Event\Storage\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Class Event
 * @package Event\Storage\Doctrine
 * @ORM\Entity()
 * @ORM\Table(name="event")
 */
class Event {

    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    protected $alias;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var string
     * @ORM\Column(name="arguments", type="string")
     */
    protected $_params;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $status;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="creation_date")
     */
    protected $creationDate;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="processed_date")
     */
    protected $processDate;

        /**
     * @return string
     */
    public function getAlias() {
        return $this->alias;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getParams() {
        if (!$this->params) {
            $this->params = $this->_params ? \Zend\Json\Json::decode($this->_params) : array();
        }
        return $this->params;
    }

    /**
     * @param string $status
     */
    public function setStatus($status) {
        $this->status = $status;
        $this->processDate = new DateTime();
    }

    /**
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate() {
        return $this->creationDate;
    }

} 