<?php

namespace App\Controller;


use App\Entity\Activiteit;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ActiviteitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
* @Route("user/")
* @IsGranted("ROLE_USER")
*/
class DeelnemerController extends AbstractController
{
    /**
     * @Route("activiteiten", name="activiteiten")
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
            'user' => $user
        ]);
    }

    /**
     * @Route("inschrijven/{id}", name="inschrijven")
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
     * @Route("uitschrijven/{id}", name="uitschrijven")
     */
    public function uitschrijvenActiviteitAction(Activiteit $activiteit, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $user->removeActiviteit($activiteit);

        $entityManager->flush();

        return $this->redirectToRoute('activiteiten');
    }

    /**
     * @Route("{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('activiteiten');
        }

        return $this->render('deelnemer/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
