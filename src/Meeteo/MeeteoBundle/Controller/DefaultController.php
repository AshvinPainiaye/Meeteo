<?php

namespace Meeteo\MeeteoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction($weatheroption) {
        // Create em for entity Report
        $reportRepository = $this->getDoctrine()
                ->getRepository('MeeteoMeeteoBundle:Report');
        // Get all report from database
        $listereports = $reportRepository->findAll();

        // Return listereports to view index.html.twig
        return $this->render('MeeteoMeeteoBundle:Default:index.html.twig', array(
                    'listereports' => $listereports, 'weatheroption' => $weatheroption
        ));
    }
}
