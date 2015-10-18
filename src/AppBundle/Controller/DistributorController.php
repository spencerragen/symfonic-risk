<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Player;

use AppBundle\Entity\Empire;
use AppBundle\Entity\Territory;

class DistributorController extends Controller
{
	private $players;
	private $territory_pool;
	private $empire_pool;
	private $empires;

	/**
     * @Route("/distribute")
     */
	public function distribute(Request $request) {
        $term = $request->query->getAlpha('capitol');
        $pool = array();
        $players = array();

        $this->populatePools();

        if(!isset($term) || empty($term)) {
            return new Response('Invalid capitols');
        }

        // build out the base distributions for selected empires
        foreach($term as $cap) {
            $capitol = $this->getDoctrine()->getRepository('AppBundle:Territory')->findOneByName($cap);
            $territories = $this->getDoctrine()->getRepository('AppBundle:Territory')->findByEmpire($capitol->getEmpire());
            $empire = $this->getDoctrine()->getRepository('AppBundle:Empire')->findOneById($capitol->getEmpire());
            $player = new Player();

            $player->setCapitol($capitol);
            $player->setEmpire($empire);

            if(!$this->selectedEmpire($player->getEmpire())) {
            	$this->chooseEmpire($player->getEmpire());
            }

            // each player gets at least 2 territories from their own empire in addition to the capitol
            $this->getRandomTerritories($player, $territories);
            $this->players[] = $player;
        }

        // there must be at least 5 players by the rules, so if we have less than that we need to add
        // two neutral empires
        while(count($this->players) < 5) {
        	$this->createNeutralEmpire();
        }

        $this->distributeTerritories();

        $rows = array();
        $out_empires = array();
        return $this->render('default/distribution.html.twig', array(
            'players' => $this->players,
        ));
    }

    protected function createNeutralEmpire() {
    	$neutral = array_rand($this->empire_pool, 1);

    	// since neutral armies don't have capitols, they can select from any random territory and
    	// it won't really matter
    	$select = null;
    	while($select === null) {
    		$select = $this->territory_pool[array_rand($this->territory_pool, 1)];

    		if($select === false) {
    			$select = null;
    			continue;
    		}

    		$empire = $this->getDoctrine()->getRepository('AppBundle:Empire')->findOneById($select->getEmpire());
    		if($this->selectedEmpire($empire)) {
    			$select = null;
    			continue;
    		}


    		$player = new Player();
            $player->setCapitol($select);
            $player->setEmpire($empire);

    		$this->chooseEmpire($empire);
    		$this->chooseTerritory($select);

    		$this->players[] = $player;
    	}
    	return true;
    }

    protected function populatePools() {
    	$this->territory_pool = $this->getDoctrine()->getRepository('AppBundle:Territory')->findAll();
    	$this->empire_pool = $this->getDoctrine()->getRepository('AppBundle:Empire')->findAll();
    }

    protected function chooseEmpire($empire) {
    	foreach($this->empire_pool as &$pool) {
    		if($pool === false) {
    			continue;
    		}
    		if($pool->getId() == $empire->getId()) {
    			$this->addEmpire($pool);
    			$pool = null;
    			$this->empire_pool = array_filter($this->empire_pool);
    			return true;
    		}
    	}

    	return false;
    }

    protected function chooseTerritory($territory) {
    	foreach($this->territory_pool as &$pool) {
    		if($pool === false) {
    			continue;
    		}
    		if($pool->getName() == $territory->getName()) {
    			$this->addTerritory($pool);
    			$pool = null;
    			$this->territory_pool = array_filter($this->territory_pool);
    			return true;
    		}
    	}

    	return false;
    }

    protected function selectedEmpire($empire) {
    	if(empty($this->empires)) {
    		return false; // pretty easy
    	}

    	foreach($this->empires as $pool) {
    		if($pool === false) {
    			continue;
    		}

    		if($pool->getId() == $empire->getId()) {
    			return true;
    		}
    	}

    	return false;
    }

    protected function addEmpire($empire) {
    	$this->empires[] = $empire;
    }

    protected function addTerritory($territory) {
    	$this->territories[] = $territory;
    }

    // weeee recursion
    // in 3 player games we do 3 own territories, in 6 player we do 2
    // eventually I need to add more options for customization, so $number can be changed
    protected function getRandomTerritories($player, $territories, $number = 2) {
    	$select = null;

    	if($number <= 0) {
    		return $this;
    	}

    	while($select === null) {
    		$select = $territories[array_rand($territories, 1)];
    		if($select === false) {
    			$select = null;
    			continue;
    		}

    		if($player->hasTerritory($select->getName())) {
    			$select = null;
    			continue;
    		}

    		$player->addTerritory($select);
    		$this->chooseTerritory($select);
    	}
    	
    	return $this->getRandomTerritories($player, $territories, --$number);
    }

    protected function distributeTerritories() {
    	// the first empire is chosen by whoever won the dice roll to be first player

    	$place = 0;
    	if(count($this->players) == 6) {
    		// in games with 6 players, players 1 & 2 get 8 territories, and the rest get 7
    		$counts = array(8, 8, 7, 7, 7, 7);
    	} else {
    		// when there are less than 5 players, we have a 5 player game
    		// in games with 5 players, players 1-4 get 9 territories and player 5 gets 8
    		$counts = array(9, 9, 8, 8, 8);
    	}

		foreach($this->players as $player) {
			$this->getRandomTerritories($player, $this->territory_pool, $counts[$place++] - $player->numTerritories());
		}

    	return false;
    }
}
