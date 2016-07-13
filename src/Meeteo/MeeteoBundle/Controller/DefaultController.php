<?php
namespace Meeteo\MeeteoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class DefaultController extends Controller {
    public function indexAction() {
        // Create em for entity Report
        $reportRepository = $this->getDoctrine()
                ->getRepository('MeeteoMeeteoBundle:Report');

        // Get all report from database
        $listereports = $reportRepository->findAll();

        // If null raise execption
        // if (!$listereports) {
        //     throw $this->createNotFoundException("Aucun rapport à afficher");
        // }

        // Return listereports to view index.html.twig
        return $this->render('MeeteoMeeteoBundle:Default:index.html.twig', array(
                    'listereports' => $listereports
        ));
    }
}
