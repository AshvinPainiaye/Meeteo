<?php

namespace Meeteo\MeeteoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManageController extends Controller {

    public function ManageAction() {
            // Create em for entity user
            $usersRepository = $this->getDoctrine()
                    ->getRepository('MeeteoMeeteoBundle:User');
            // Get all users from database
            $listeUsers = $usersRepository->findAll();
            // Return listeusers to view manage.html.twig
            return $this->render('MeeteoMeeteoBundle:Manage:manage.html.twig', array(
                        'listeUsers' => $listeUsers
            ));
    }

    public function EditAction($id, Request $request) {
        // Get our "authorization_checker" Object
        $auth_checker = $this->get('security.authorization_checker');
        // Check for Roles on the $auth_checker
        $isRoleAdmin = $auth_checker->isGranted('ROLE_ADMIN');
        // Test if user have ROLE_ADMIN
        if ($isRoleAdmin) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('MeeteoMeeteoBundle:User')->find($id);
            $editForm = $this->createFormBuilder($user)
                    ->add('username', 'text')
                    ->add('email', 'text')
                    ->add('roles', 'choice', array(
                        'multiple' => true,
                        'expanded' => true,
                        'choices' => array(
                            'ROLE_ADMIN' => 'ADMIN',
                            'ROLE_METEOROLOGUE' => 'METEOROLOGUE',
                        ),
                    ))
                    ->getForm();
            $editForm->handleRequest($request);
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em->flush();
                return $this->redirectToRoute('_manage');
            }
            $build['edit_form'] = $editForm->createView();
            return $this->render('MeeteoMeeteoBundle:Edit:edit.html.twig', $build);
        }
    }

}
