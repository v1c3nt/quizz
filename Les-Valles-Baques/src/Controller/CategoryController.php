<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;


class CategoryController extends AbstractController
{

    private function categoryTree($parent_id = null)
    {
        $treeCategories = array();
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();
        dump($categories);

        foreach ($categories as $category) {
            dump($category);
            dump($treeCategories);
            array_push(
                $treeCategories,
                array_filter([
                    $category->getId() => $category->getName(),
                    'children' => $this->categoryTree($category->getId())
                ])
            );
            dump($treeCategories);
        }
        return $treeCategories;


    }

    /**
     * @Route("/category", name="category")
     */
    public function index(CategoryRepository $category)
    {

        $treeCategories = [];
        $categories = $category->findAll();



        foreach ($categories as $category) {

            $xx = $category->getChildren();


        }





        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
        ]);
    }

    public function deepdown($cat)
    {

    }
}
