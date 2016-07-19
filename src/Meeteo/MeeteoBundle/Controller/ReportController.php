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
        0 => 0,
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        10 => 10,
        11 => 11,
        12 => 12,
        13 => 13,
        14 => 14,
        15 => 15,
        16 => 16,
        17 => 17,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 25,
        26 => 26,
        27 => 27,
        28 => 28,
        29 => 29,
        30 => 30,
        31 => 31,
        32 => 32,
        33 => 33,
        34 => 34,
        35 => 35,
        36 => 36,
        37 => 37,
        38 => 38,
        39 => 39,
        40 => 40,
        41 => 41,
        42 => 42,
        43 => 43,
        44 => 44,
        45 => 45,
        46 => 46,
        47 => 47,
        48 => 48,
        49 => 49,
        50 => 50,
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
    ->add('imageFile', VichImageType::class, array('label' => ' ','required' => false))
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
