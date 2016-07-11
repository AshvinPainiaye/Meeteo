<?php

namespace Meeteo\MeeteoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManageController extends Controller
{
    public function ManageAction()
    {
        return $this->render('MeeteoMeeteoBundle:Manage:manage.html.twig', array(
            // ...
        ));
    }

}
