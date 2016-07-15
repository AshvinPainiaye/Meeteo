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
                        'Ensoleillé' => 'Ensoleillé',
                        'Nuageux' => 'Nuageux',
                        'Pluvieux' => 'Pluvieux',
                        'Brume' => 'Brume',
                        'Neige' => 'Neige',
                        'Grèle' => 'Grèle',
                    ),
                ))
                ->add('temperature', ChoiceType::class, array(
                    'choices' => array(
                        'Très froid' => 'Très froid',
                        'Froid' => 'Froid',
                        'Idéale' => 'Idéale',
                        'Chaud' => 'Chaud',
                        'Très chaud' => 'Très chaud',
                    ),
                ))
                ->add('wind', ChoiceType::class, array(
                    'choices' => array(
                        'Pas de vent' => 'Pas de vent',
                        'Vent modéré' => 'Vent modéré',
                        'Vent assez fort' => 'Vent assez fort',
                        'Vent fort' => 'Vent fort',
                        'Cyclone' => 'Cyclone',
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
