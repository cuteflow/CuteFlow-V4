<?php

namespace CuteFlow\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuteFlow\CoreBundle\Entity\Field
 *
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="fieldType", type="string")
 * @ORM\DiscriminatorMap({"textfield"="TextField"})
 */
class Field
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
     * @var boolean $writeProtected
     *
     * @ORM\Column(name="write_protected", type="boolean")
     */
    private $writeProtected;

    /**
     * @var string $color
     *
     * @ORM\Column(name="color", type="string", length=10)
     */
    private $color;


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
     * Set writeProtected
     *
     * @param boolean $writeProtected
     */
    public function setWriteProtected($writeProtected)
    {
        $this->writeProtected = $writeProtected;
    }

    /**
     * Get writeProtected
     *
     * @return boolean 
     */
    public function getWriteProtected()
    {
        return $this->writeProtected;
    }

    /**
     * Set color
     *
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }
}