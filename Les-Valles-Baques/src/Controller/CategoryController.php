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

        if (!$categories) {
            throw $this->createNotFoundException('Il n\'y a rien par ici.');
        }

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function categoryShow(QuizzRepository $quizzRepo, CategoryRepository $category, $id)
    {
        $category = $category->findOneBy(['id' => $id]);
        $quizzs = $quizzRepo->findBy(['category' => $id]);

        if (!$category) {
            throw $this->createNotFoundException('Il n\'y a aucune catégorie par ici.');
        }

        return $this->render('category/category.html.twig', [
            'category' => $category,
            'quizzs' => $quizzs,
        ]);
    }
}
