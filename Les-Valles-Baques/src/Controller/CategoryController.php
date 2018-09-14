<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;

class CategoryController extends AbstractController
{

    /**
     * @Route("/category", name="category")
     */
    public function index(CategoryRepository $category)
    {
        $treeCategory = [];
        $categorys = $category->findAll();

        foreach ($categorys as $category) {
            dump($category->getChildren());
        }
        /**
         *! teste avec twig
         * foreach ($categorys as $category) {
            dump($category);
            do {
                if ( null === $category->getParent() ) {
                    $parent = null;
                } else {
                $parent=1;
                foreach ($category as $subcategorys ) {
                    $treeCategory[] = $subcategorys;
                    dump('while');
                    dump($subcategorys);die();

                        $parent = $subcategorys->getParent();
                        $category = $subcategorys;
                        return $category;
                    }
                }
            }
            while (null !== $parent);


                $treeCategory[] = $category;
            }
                dump('dd');
        
        dump($treeCategory);
        exit;
         */
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categorys,
        ]);
    }

    public function deepdown($cat)
    {

    }
}
