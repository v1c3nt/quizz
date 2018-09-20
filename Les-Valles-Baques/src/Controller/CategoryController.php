<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\QuizzRepository;
use App\Entity\Category;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(CategoryRepository $category)
    {

        $categories = $category->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function categoryShow(CategoryRepository $category)
    {

        $categories = $category->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

}
