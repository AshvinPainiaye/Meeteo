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
        $todaydate = new \DateTime("now");
        
         foreach ($listereports as $key => $report) {
                if ($report->getDate()->diff($todaydate)->h > 24 ){
                    unset($listereports[$key]);
                }
         }
        
        // Return listereports to view index.html.twig
        return $this->render('MeeteoMeeteoBundle:Default:index.html.twig', array(
                    'listereports' => $listereports
        ));
    }


    public function VentsAction() {

      // Create em for entity Report
      $reportRepository = $this->getDoctrine()
              ->getRepository('MeeteoMeeteoBundle:Report');
      // Get all report from database
      $listereports = $reportRepository->findAll();

      // Return listereports to view index.html.twig

      return $this->render('MeeteoMeeteoBundle:Maps:Vents.html.twig', array(
                  'listereports' => $listereports
      ));
    }

    public function TemperatureAction() {

      // Create em for entity Report
      $reportRepository = $this->getDoctrine()
              ->getRepository('MeeteoMeeteoBundle:Report');
      // Get all report from database
      $listereports = $reportRepository->findAll();

      // Return listereports to view index.html.twig

      return $this->render('MeeteoMeeteoBundle:Maps:temperature.html.twig', array(
                  'listereports' => $listereports
      ));
    }

}
