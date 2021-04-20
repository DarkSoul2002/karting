<?php

namespace App\Controller;

use App\Entity\Activiteit;
use App\Entity\Soortactiviteit;
use App\Entity\User;
use App\Form\ActiviteitType;
use App\Form\SoortActiviteitType;
use App\Repository\ActiviteitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MedewerkerController extends AbstractController
{
    /**
     * @Route("/admin/activiteiten", name="activiteitenoverzicht")
     */
    public function activiteitenOverzichtAction(ActiviteitRepository $activiteitRepository)
    {
        $activiteiten = $activiteitRepository->findAll();

        return $this->render('medewerker/activiteiten.html.twig', [
            'activiteiten' => $activiteiten
        ]);
    }

    /**
     * @Route("/admin/details/{id}", name="details")
     */
    public function detailsAction(Activiteit $activiteit, ActiviteitRepository $activiteitRepository, UserRepository $userRepository)
    {
        return $this->render('medewerker/details.html.twig', [
            'activiteit' => $activiteit,
            'deelnemers' => $userRepository->getDeelnemers($activiteit->getId()),
            'aantal' => $activiteitRepository->getTotaalActiviteiten(),
        ]);
    }

    /**
     * @Route("/admin/beheer", name="beheer")
     */
    public function beheerAction()
    {
        $activiteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();

        $soortactiviteiten = $this->getDoctrine()
            ->getRepository('App:Soortactiviteit')
            ->findAll();

        return $this->render('medewerker/beheer.html.twig', [
            'activiteiten' => $activiteiten,
            'soortactiviteiten' => $soortactiviteiten
        ]);
    }

    /**
     * @Route("/admin/add", name="add")
     */
    public function addAction(Request $request)
    {
        if ($request->get('soort') === 'activiteit') {
            $a = new Activiteit();

            $form = $this->createForm(ActiviteitType::class, $a);
        } elseif ($request->get('soort') === 'soortactiviteit') {
            $a = new Soortactiviteit();

            $form = $this->createForm(SoortActiviteitType::class, $a);
        }

        $form->add('save', SubmitType::class, ['label' => "voeg toe"]);
        //$form->add('reset', ResetType::class, ['label'=>"reset"]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($a);
            $em->flush();

            $this->addFlash(
                'notice',
                'item toegevoegd!'
            );
            return $this->redirectToRoute('beheer');
        }
        $activiteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();
        return $this->render('medewerker/add.html.twig', ['form' => $form->createView(), 'activiteiten' => $activiteiten]);
    }

    /**
     * @Route("/admin/update/{id}", name="update")
     */
    public function updateAction($id, Request $request)
    {
        if ($request->get('soort') === 'activiteit') {
            $a = $this->getDoctrine()
                ->getRepository('App:Activiteit')
                ->find($id);

            $form = $this->createForm(ActiviteitType::class, $a);
            $form->add('save', SubmitType::class, ['label' => "aanpassen"]);
        } elseif ($request->get('soort') === 'soortactiviteit') {
            $a = $this->getDoctrine()
                ->getRepository('App:Soortactiviteit')
                ->find($id);

            $form = $this->createForm(SoortActiviteitType::class, $a);
            $form->add('save', SubmitType::class, ['label' => "aanpassen"]);
        }


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the contact (no queries yet)
            $em->persist($a);


            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
            $this->addFlash(
                'notice',
                'Item aangepast!'
            );
            return $this->redirectToRoute('beheer');
        }

        $activiteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();

        return $this->render('medewerker/edit.html.twig', ['form' => $form->createView(), 'activiteiten' => $activiteiten]);
    }

    /**
     * @Route("/admin/delete/{id}", name="delete")
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->get('soort') === 'activiteit') {
            $a = $this->getDoctrine()
                ->getRepository('App:Activiteit')->find($id);
        } elseif ($request->get('soort') === 'soortactiviteit') {
            $a = $this->getDoctrine()
                ->getRepository('App:Soortactiviteit')->find($id);
        }
        $em->remove($a);
        $em->flush();

        $this->addFlash(
            'notice',
            'Item verwijderd!'
        );
        return $this->redirectToRoute('beheer');

    }
}
