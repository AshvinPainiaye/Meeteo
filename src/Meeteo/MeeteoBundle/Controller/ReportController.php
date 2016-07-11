<?php

namespace Meeteo\MeeteoBundle\Controller;

use Meeteo\MeeteoBundle\Entity\Report;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ReportController extends Controller {

    public function ReportAction(Request $request , $lat , $lon) {
        // create a task and give it some dummy data for this example
        $report = new Report();
        $report->setDate(new \DateTime('now'));
        /*###########################
        * ##### COMMENTS ###########
        * Vous pouvez chainer vos appels
        * $report->setLat($lat)
        *        ->setLon($lon);
        * ###########################
        */
        $report->setLat($lat);
        $report->setLon($lon);
        /*###########################
        * ##### COMMENTS ###########
        * Créez vos formulaires dans une classe à part. Cela vous permettra de
        * le réutiliser à d'autres endroit plus facilement.
        * ###########################
        */
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
                ->add('imageFile',  VichImageType::class, array('label' => 'Photo'))
              //  ->add('save', SubmitType::class, array('label' => 'Meeteo'))

                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          /*###########################
          * ##### COMMENTS ###########
          *
          */
            // ... perform some action, such as saving the task to the database
            $report->setWeather($form->get('weather')->getData());
            $report->setTemperature($form->get('temperature')->getData());
            $report->setWind($form->get('wind')->getData());
            $report->setImageFile($form->get('imageFile')->getData());
            /*
            * les lignes ci-dessus ne sont pas nécessaires. l'affectation des données du formulaires
            * dans l'entité se fait grâce à $form->handleRequest($request)
            * ###########################
            */
            $user = $this->get('security.token_storage')->getToken()->getUser();

            $report->setUser($user);
            //$user->setReport($report);

            $em = $this->getDoctrine()->getEntityManager();
            //$em->persist($user);
            $em->persist($report);
            $em->flush();
            return $this->redirectToRoute('meeteo_meeteo_homepage');
        }

        return $this->render('MeeteoMeeteoBundle:Report:report.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
