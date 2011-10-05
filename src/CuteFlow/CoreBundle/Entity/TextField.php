<?php

namespace CuteFlow\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuteFlow\CoreBundle\Entity\TextField
 *
 * @ORM\Entity
 */
class TextField extends Field
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
     * @var string $validationRegex
     *
     * @ORM\Column(name="validationRegex", type="string", length=255)
     */
    private $validationRegex;

    /**
     * @var string $defaultValue
     *
     * @ORM\Column(name="defaultValue", type="string", length=255)
     */
    private $defaultValue;


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
     * Set validationRegex
     *
     * @param string $validationRegex
     */
    public function setValidationRegex($validationRegex)
    {
        $this->validationRegex = $validationRegex;
    }

    /**
     * Get validationRegex
     *
     * @return string 
     */
    public function getValidationRegex()
    {
        return $this->validationRegex;
    }

    /**
     * Set defaultValue
     *
     * @param string $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * Get defaultValue
     *
     * @return string 
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
}