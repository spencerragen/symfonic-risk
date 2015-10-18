<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="territories")
 */

class Territory
{
	/**
     * @ORM\Column(type="string", length=128)
     * @ORM\Id
     */
    protected $name;

	/**
     * @ORM\Column(type="integer")
     */
    protected $empire;

	/**
     * @ORM\Column(type="string", length=6)
     */
    protected $color; // color would be better off in the empires table, now that I think about it

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Territory
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
     * Set empire
     *
     * @param integer $empire
     *
     * @return Territory
     */
    public function setEmpire($empire)
    {
        $this->empire = $empire;

        return $this;
    }

    /**
     * Get empire
     *
     * @return integer
     */
    public function getEmpire()
    {
        return $this->empire;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Territory
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
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

    public function __toString()
    {
        return "name: {$this->name}; empire: {$this->empire}; color: #{$this->color}";
    }
}
