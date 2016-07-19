<?php

namespace Meeteo\MeeteoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Meeteo\MeeteoBundle\Entity\User;
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


    public function EditAction($id,Request $request){
      $em = $this->getDoctrine()->getManager();
      $user= $em->getRepository('MeeteoMeeteoBundle:User')->find($id);

      $editForm = $this->createFormBuilder($user)
      ->add('username', 'text')
      ->add('email', 'text')
      ->add('save', 'submit')
      ->getForm();

      $editForm->handleRequest($request);

      if ($editForm->isSubmitted() && $editForm->isValid()) {
        $em->flush();

        return $this->redirectToRoute('_manage');
        }
        $build['edit_form'] = $editForm->createView();

        return $this->render('MeeteoMeeteoBundle:Edit:edit.html.twig',$build );
    }

}
