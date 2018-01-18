<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function index()
    {

        $isError = "";

        $session = new Session();
        $session->start();

        $isConnected = $session->get('is_connected');

        if($isConnected)
        {
            return $this->redirectToRoute('index');
        }

        if(isset($_POST))
        {
            if(isset($_POST['pseudo']) && $_POST['pseudo'] != "" && isset($_POST['password']) && $_POST['password'] != "")
            {
                $password = sha1($_POST['password']);
                $personLogin = $this->getDoctrine()->getRepository(User::class)
                    ->findOneBy([
                            'email' => "{$_POST['pseudo']}",
                            'password' => "{$password}",
                        ]
                    );

                //If combo pseudo & password exist in the database
                if(!$personLogin)
                {
                    $isError = "Erreur, le pseudo ou le mot de passe est incorrect !";
                }
                else
                {

                    //And store some infos into it
                    $session->set('id_user', $personLogin->getId());
                    $session->set('pseudo', $personLogin->getFirstName());
                    $session->set('is_connected', true);

                    //then redirect to index page without show any thing
                    return $this->redirectToRoute('index');
                }

            }

        }

        return $this->render('login.html.twig', array(
            'title' => "Connexion",
            'body' => "Veuillez vous identifier !",
            'scripts' => "",
            'is_connected' => $isConnected,
            'loginState' => $isError,
        ));

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        $session = new Session();
        $session->set('is_connected', false);
        return $this->redirectToRoute('index');
    }
}
