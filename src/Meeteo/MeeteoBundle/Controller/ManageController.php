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
        $listeUsers = $usersRepository->findAll();

        // If null no user raise execption
        // if (!$listeUsers) {
        //     throw $this->createNotFoundException("Aucun Utilisateur à afficher");
        // }

        // Return listeusers to view manage.html.twig
        return $this->render('MeeteoMeeteoBundle:Manage:manage.html.twig', array(
                    'listeUsers' => $listeUsers
        ));
    }

    public function EditAction(){

    }

}
