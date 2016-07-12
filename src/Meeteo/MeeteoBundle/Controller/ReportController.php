<?php

namespace Meeteo\MeeteoBundle\Controller;

use Meeteo\MeeteoBundle\Entity\Report;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ReportController extends Controller {

    public function ReportAction(Request $request, $lat, $lon) {
        // Create a report and give it a date, latitude, longitude
        $report = new Report();
        $report->setDate(new \DateTime('now'))
                ->setLat($lat)
                ->setLon($lon);
        // TODO: Create a class for this form
        $form = $this->createFormBuilder($report)
                ->add('weather', ChoiceType::class, array(
                    'choices' => array(
                        0 => 'Ensoleillé',
                        1 => 'Nuageux',
                        2 => 'Pluvieux',
                        3 => 'Brume',
                        4 => 'Neige',
                        5 => 'Grèle',
                    ),
                ))
                ->add('temperature', ChoiceType::class, array(
                    'choices' => array(
                        0 => 'Très froid',
                        1 => 'Froid',
                        2 => 'Idéale',
                        3 => 'Chaud',
                        4 => 'Très chaud',
                    ),
                ))
                ->add('wind', ChoiceType::class, array(
                    'choices' => array(
                        0 => 'Pas de vent',
                        1 => 'Vent modéré',
                        2 => 'Vent assez fort',
                        3 => 'Vent fort',
                        4 => 'Cyclone',
                    ),
                ))
                ->add('imageFile', VichImageType::class, array('label' => 'Photo','required' => false))
                ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Get connected user
            $user = $this->get('security.token_storage')->getToken()->getUser();
            // Set user for report, save to database and redirect to homepage
            $report->setUser($user);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($report);
            $em->flush();
            return $this->redirectToRoute('meeteo_meeteo_homepage');
        }
        // Create the form view
        return $this->render('MeeteoMeeteoBundle:Report:report.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
