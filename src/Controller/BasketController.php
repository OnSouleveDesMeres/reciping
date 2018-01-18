<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Ingredient;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class BasketController extends Controller
{
    /**
     * @Route("/basket/add/", name="add")
     */
    public function index()
    {

        $session = new Session();
        $session->start();

        $isConnected = $session->get('is_connected');

        if (!$isConnected){
            return null;
        }

        if(isset($_POST)){

            if(isset($_POST['ingredient']) && $_POST['ingredient'] != "" &&
                isset($_POST['quantity']) && $_POST['quantity'] != ""){

                $person = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->findOneBy([
                        'id' => $session->get('id_user'),
                    ]);
                $ingredient = $this->getDoctrine()
                    ->getRepository(Ingredient::class)
                    ->findOneBy([
                        'id' => $_POST['ingredient'],
                    ]);

                $element = $this->getDoctrine()->getManager();

                $basket = new Basket();

                $basket->setUser($person);
                $basket->setIngredient($ingredient);
                $basket->setQuantity($_POST['quantity']);

                $element->persist($basket);

                $element->flush();

                return $this->render('validation/validated.html.twig');

            }

        }

    }

    /**
     * @Route("/basket/delete/", name="delete")
     */
    public function delete()
    {

        $session = new Session();
        $session->start();

        $isConnected = $session->get('is_connected');

        if (!$isConnected){
            return null;
        }

        if(isset($_POST)){

            if(isset($_POST['id']) && $_POST['id'] != ""){

                $basket = $this->getDoctrine()
                    ->getRepository(Basket::class)
                    ->findOneBy([
                        'id' => $_POST['id'],
                    ]);

                $element = $this->getDoctrine()->getManager();

                $element->remove($basket);

                $element->flush();

                return $this->render('validation/validated.html.twig');

            }

        }

    }

    /**
     * @Route("/mon-panier", name="basket")
     */
    public function show()
    {

        $session = new Session();
        $session->start();

        $isConnected = $session->get('is_connected');

        if (!$isConnected){
            return $this->redirectToRoute('index');
        }

        $request_count = $this->getDoctrine()
            ->getRepository(Basket::class)
            ->findBy([
                'user' => $session->get('id_user'),
            ]);



        return $this->render('basket.html.twig',
            [
                'counting' => count($request_count),
                'username' => $session->get('user_name'),
                'is_connected' => $session->get('is_connected'),
                'user_list' => $request_count,
            ]);

    }

}
