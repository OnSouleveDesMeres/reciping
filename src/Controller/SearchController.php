<?php

namespace App\Controller;

use App\Entity\Containing;
use App\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    /**
     * @Route("/search/multiple/{name}", name="search_multiple")
     */
    public function search($name)
    {

        $search_multiple = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->findByContainName($name);

        return $this->render('search/result_search.html.twig',[
            'result_list' => $search_multiple,
        ]);

    }
    /**
     * @Route("/search/one/{id}", name="search_single")
     */
    public function search_one($id)
    {

        $search_recipe = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->findOneBy([
                'id' => $id,
            ]);

        $ingredients_list = $this->getDoctrine()
            ->getRepository(Containing::class)
            ->findBy([
                'recipe' => $id,
            ]);

        return $this->render('search/result_one_search.html.twig',[
            'result' => $search_recipe,
            'ingredients_list' => $ingredients_list,
        ]);

    }
}
