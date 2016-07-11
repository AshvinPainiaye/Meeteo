<?php

namespace Meeteo\MeeteoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManageController extends Controller
{
    public function ManageAction()
    {
        // Create em for entity user
        $usersRepository = $this->getDoctrine()
                ->getRepository('MeeteoMeeteoBundle:User');
        
        // Get all users from database
        $listeusers = $usersRepository->findAll();
        
        // If null raise execption
        if (!$listeusers) {
            throw $this->createNotFoundException("Aucun rapport à afficher");
        }
        
        // Return listeusers to view manage.html.twig
        return $this->render('MeeteoMeeteoBundle:Manage:manage.html.twig', array(
                    'listeusers' => $listeusers
        ));
    }

}
