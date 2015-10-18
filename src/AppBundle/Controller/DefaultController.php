<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Empire;
use AppBundle\Entity\Territory;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $empires = $this->getDoctrine()->getRepository('AppBundle:Empire')->findAll();
        $columns = array();
        $empirecss = array(array('id' => 0, 'color' => 'efefef')); // initialize with empty cell color
        $rows = array();
        $max = 0;

        foreach($empires as &$empire) {
            // get the list of territories in each empire and assign the color to each empire
            $territories = $this->getDoctrine()->getRepository('AppBundle:Territory')->findByEmpire($empire->getId());
            $empirecss[] = array('id' => $empire->getId(), 'color' => $territories[0]->getColor());

            if(($check = count($territories)) > $max) {
                $max = $check;
            }

            // this part can be done less badly
            $out_empires[] = array(
                                'id' => $empire->getId(),
                                'empire' => $empire->getName()
                            );

            $columns[] = array(
                                'id' => $empire->getId(),
                                'empire' => $empire->getName(),
                                'territories' => $territories
                            );
        }

        // build rows for the (terribly named) Native table
        for($i = 0; $i < $max; $i++) {
            $row = array();
            foreach($columns as $column) {
                // space it out so the Territories end up in the proper columns
                if($i < count($column['territories'])) {
                    $row[] = array('color' => $column['territories'][$i]->getEmpire(), 'name' => $column['territories'][$i]->getName());
                } else {
                    $row[] = array('color' => 0, 'name' => '');
                }
            }
            $rows[] = $row;
        }

        // set up the capitol selection form
        $form = $this->createFormBuilder()
                    ->add('capitol', 'text')
                    ->add('randomize', 'button', array('label' => 'Randomize'))
                    ->getForm();

        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'empires' => $out_empires,
            'empirecss' => $empirecss,
            'rows' => $rows,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/search")
     */
    public function search(Request $request) {
        if($request->query->has('term')) {
            $term = $request->query->getAlpha('term');
            $territory = $this->getDoctrine()->getRepository('AppBundle:Territory');

            $qb = $territory->createQueryBuilder('t');
            $result = $qb->select(['t.empire as id', 't.name as label'])
                        ->where($qb->expr()->like('t.name', ':term'))
                        ->setParameter('term', "$term%");
            $query = $qb->getQuery()->getResult();
        }

        return new JsonResponse($query);
    }

    /**
     * @Route("/empire/{id}")
     */
    public function showEmpire($id) {
        $empire = $this->getDoctrine()
            ->getRepository('AppBundle:Empire')
            ->find($id);

        if (!$empire) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response($empire);
    }

    /**
     * @Route("/territory/{id}")
     */
    public function showTerritory($id) {
        $territory = $this->getDoctrine()
            ->getRepository('AppBundle:Territory')
            ->find($id);

        if (!$territory) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response($territory);

    }
}

?>
