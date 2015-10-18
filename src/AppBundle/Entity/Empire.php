<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="empires")
 */

class Empire
{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;

	/**
     * @ORM\Column(type="string", length=32)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $alternate;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $independent;

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
     *
     * @return Empire
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set alternate
     *
     * @param string $alternate
     *
     * @return Empire
     */
    public function setAlternate($alternate)
    {
        $this->alternate = $alternate;

        return $this;
    }

    /**
     * Get alternate
     *
     * @return string
     */
    public function getAlternate()
    {
        return $this->alternate;
    }

    /**
     * Set independent
     *
     * @param boolean $independent
     *
     * @return Empire
     */
    public function setIndependent($independent)
    {
        $this->independent = $independent;

        return $this;
    }

    /**
     * Get independent
     *
     * @return boolean
     */
    public function getIndependent()
    {
        return $this->independent;
    }

    public function __toString()
	{
		return "id: {$this->id}; name: {$this->name}; independent: " . ($this->independent ? 'true' : 'false');
	}
}
