<?php

namespace Meeteo\MeeteoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {

        /*###########################
        * ##### COMMENTS ###########
        * il faudrait renommer $repository par un nom plus évocateur style $reportRepository
        * Parfois vous pouvez avoir plus repository dans la même action
        * ###########################
        */
        $repository = $this->getDoctrine()
                ->getRepository('MeeteoMeeteoBundle:Report');

        $listereports = $repository->findAll();

        if (!$listereports) {
            throw $this->createNotFoundException("Aucun rapport à afficher");
        }

        return $this->render('MeeteoMeeteoBundle:Default:index.html.twig', array(
                    'listereports' => $listereports
        ));
    }

}
