<?php

namespace App\Controller;


use App\Entity\Activiteit;
use App\Entity\User;
use App\Repository\ActiviteitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeelnemerController extends AbstractController
{
    /**
     * @Route("/user/activiteiten", name="activiteiten")
     */
    public function activiteitenAction(ActiviteitRepository $activiteitRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $beschikbareActiviteiten = $activiteitRepository->getBeschikbareActiviteiten($user->getId());
        $ingeschrevenActiviteiten = $activiteitRepository->getIngeschrevenActiviteiten($user->getId());
        $totaal = $activiteitRepository->getTotaal($ingeschrevenActiviteiten);


        return $this->render('deelnemer/activiteiten.html.twig', [
            'beschikbare_activiteiten' => $beschikbareActiviteiten,
            'ingeschreven_activiteiten' => $ingeschrevenActiviteiten,
            'totaal' => $totaal,
        ]);
    }

    /**
     * @Route("/user/inschrijven/{id}", name="inschrijven")
     */
    public function inschrijvenActiviteitAction(Activiteit $activiteit, EntityManagerInterface $entityManager): Response
    {
        if (
            $activiteit->getMaxDeelnemers() > $activiteit->getUsers()->count()
            && $activiteit->getDatum() >= new \DateTime('today midnight')
        ) {
            /** @var User $user */
            $user = $this->getUser();
            $user->addActiviteit($activiteit);

            $entityManager->flush();
        }

        return $this->redirectToRoute('activiteiten');
    }

    /**
     * @Route("/user/uitschrijven/{id}", name="uitschrijven")
     */
    public function uitschrijvenActiviteitAction(Activiteit $activiteit, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $user->removeActiviteit($activiteit);

        $entityManager->flush();

        return $this->redirectToRoute('activiteiten');
    }

}
