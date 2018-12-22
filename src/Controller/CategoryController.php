<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CategoryType;


class CategoryController extends Controller
{
    /**
    * @Route("/category",name="allCategory")
    */
    public function showall()
    {
        
        $em = $this->getDoctrine()->getManager();
        $allCategories = $em->getRepository(Category::class)->findAll();
        if (!$allCategories) {
            throw $this->createNotFoundException(
            'Aucun produit trouvé '
            );
        }
       // var_dump($allCategories);
        return $this->render('category/index.html.twig', array(
            'categories' => $allCategories
            
        ));
    }

    /**
     * @Route("category/new",name="category_new")
     */
    public function addCategory(Request $request, ObjectManager $manager)
    {  
        $title = "Add category";
        $category = new Category();

        $formCategory = $this->createFormBuilder($category)
                             ->add('name')
                             ->add('description')
                             ->add('Add', SubmitType::class)
                             ->getForm();
        
        //Request Handling
        $formCategory->handleRequest($request);
        $category = $formCategory->getData();

        //Test if the form is validate and  submitted
        if ($formCategory->isValid() && $formCategory->isSubmitted()) {   
            $manager->persist($category);
            $manager->flush();
           // return new Response('Le catégorie est  ajoutée avec succès !'); 
           return $this->redirectToRoute("allCategory");
        }else
            return $this->render('category/new.html.twig', array('formCategory' =>
            $formCategory->createView(),
            'title' => $title
            ));    
    }

    /**
     * @Route("category/{id}",name="show_info_category")
     */
    public function showCategory($id)
    {  
        
        $repo = $this->getDoctrine()->getRepository(Category::class);
        
        //Request Handling
        $category= $repo->find($id);
       
        return $this->render('category/showCategory.html.twig',  array(
            'category' => $category));
    }


     /**
     * @Route("category/delete/{id}",name="deleteCategory")
     */
    public function deleteCategory($id)
    {  
        
        $repo = $this->getDoctrine()->getManager();
        $category =$repo->getRepository(Category::class)->find($id);
        $repo->remove($category);
        $repo->flush();
        return $this->redirectToRoute("allCategory");
    }

    ///-----

    /**
     * @Route("category/update/{id}",name="categoryUpdate")
     */
    public function updateCategory(Category $category ,Request $request, ObjectManager $manager)
    {  
        $title = "Update category";
       // $formCategory = $this->createForm(CategoryType::class,$category);
       $formCategory = $this->createFormBuilder($category)
                            ->add('name')
                            ->add('description')
                            ->add('Update', SubmitType::class)
                            ->getForm();
        //Request Handling
        $formCategory->handleRequest($request);
        $category = $formCategory->getData();

        //Test if the form is validate and  submitted
        if ($formCategory->isValid() && $formCategory->isSubmitted()) {   
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute("allCategory"); 
        }else
            return $this->render('category/new.html.twig', array('formCategory' =>
            $formCategory->createView(),
            'title' => $title
            ));
    }
    
}
