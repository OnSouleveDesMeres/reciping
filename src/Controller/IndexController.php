<?php

namespace App\Controller;

use App\Entity\Basket;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {

        $isError = "";

        $session = new Session();
        $session->start();

        $isConnected = $session->get('is_connected');

        $request_count = $this->getDoctrine()
            ->getRepository(Basket::class)
            ->findBy([
                'user' => $session->get('id_user'),
            ]);

        return $this->render('index.html.twig',
            [
                'counting' => count($request_count),
                'username' => $session->get('user_name'),
                'is_connected' => $session->get('is_connected'),
            ]);
    }
}
