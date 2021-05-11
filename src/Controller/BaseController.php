<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Transport\Smtp\Auth;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('base_vue_html.twig');
    }

    /**
     * @Route("/userapi", name="userapi")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function checkUser()
    {
        if ($user = $this->getUser()) {
            return $this->json($user);
        }
        return $this->json(0);
    }
}
