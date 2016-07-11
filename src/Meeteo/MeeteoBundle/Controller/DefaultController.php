<?php
namespace Meeteo\MeeteoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
    public function indexAction() {
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
