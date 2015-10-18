<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Empire;
use AppBundle\Entity\Territory;

class Player {
	protected $doctrine;

	protected $capitol;
	protected $empire;

	protected $territories;

	function __construct() {
		$this->territories = array();
	}

	public function addTerritory($territory) {
		// don't add the capitol to the territory list
		if($this->capitol == $territory) {
			return false;
		}

		// check current territories, don't add one already in the list
		foreach($this->territories as $terr) {
			if($terr->getName() == $territory) {
				return false;
			}
		}

		$this->territories[] = $territory;

		return true;
	}

	public function hasTerritory($territoryName) {
		if($this->capitol->getName() == $territoryName) {
			return true;
		}

		foreach($this->territories as $territory) {
			if($territory->getName() == $territoryName) {
				return true;
			}
		}

		return false;
	}

	public function numTerritories() {
		return count($this->territories);
	}

	public function setEmpire($empire) {
        $this->empire = $empire;

        return $this;
    }

    public function getEmpire() {
        return $this->empire;
    }

	public function setCapitol($capitol) {
        $this->capitol = $capitol;

        return $this;
    }

    public function getCapitol() {
        return $this->capitol;
    }

    public function setTerritories($territories) {
    	$this->territories = $territories;

    	return $this;
    }

    public function getTerritories() {
        return $this->territories;
    }
}

?>