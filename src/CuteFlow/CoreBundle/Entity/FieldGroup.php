<?php

namespace CuteFlow\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuteFlow\CoreBundle\Entity\FieldGroup
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FieldGroup
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var object $usergroup
     *
     * @ORM\Column(name="usergroup", type="object")
     */
    private $usergroup;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set usergroup
     *
     * @param object $usergroup
     */
    public function setUsergroup($usergroup)
    {
        $this->usergroup = $usergroup;
    }

    /**
     * Get usergroup
     *
     * @return object 
     */
    public function getUsergroup()
    {
        return $this->usergroup;
    }
}