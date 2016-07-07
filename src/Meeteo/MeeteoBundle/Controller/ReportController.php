<?php

namespace Meeteo\MeeteoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReportController extends Controller
{
    public function ReportAction()
    {
        return $this->render('MeeteoMeeteoBundle:Report:report.html.twig', array(
            // ...
        ));
    }

}
