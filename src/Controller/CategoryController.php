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
     * @Route("/category", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
    /**
     * @Route("/category/new",name="newCategory")
     */
    public function new(Request $request,ObjectManager $manager)
    {   $category = new Category();
        // creates a category and gives it some dummy data for this example
        $category-> setname('new category');

        $form = $this->createFormBuilder($category)
            ->add('nom', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create category'))
            ->getForm();

            
        $form->handleRequest($request);
        $category = $form->getData();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return new Response('La catégorie '.$category->getNom().' ajoutée avec succès !');
         }
                
        return $this->render('category/new.html.twig', array(
            'form' => $form->createView(),
        ));

        /*
        $em = $this->getDoctrine()->getManager();
        $allCategories = $em->getRepository(Category::class)->findAll();
        return $this->render('category/index.html.twig', array(
            'categories' => $allCategories,
        ));*/
    }
/*
    public function showOneCategory($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('Category')->find($id);
        if (!$product) {
        throw $this->createNotFoundException(
        'Aucun produit trouvé pour cet id : '.$id
        );
        }
        return $this->render('category/index.html.twig', array(
            'categrory'=>$product->getName(),
        ));
    }*/

    /**
    * @Route("/category/all",name="allCategory")
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
        return $this->render('category/index.html.twig', array(
            'categories' => $allCategories,
        ));
    }


    //------
    /**
     * @Route("category/add",name="category_add")
     */
    public function addCategory(Request $request, ObjectManager $manager)
    {  
        ///------
        $category = new Category();

        $formCategory = $this->createForm(CategoryType::class,$category);
        
        //Request Handling
        $formCategory->handleRequest($request);
        $category = $formCategory->getData();

        //Test if the form is validate and  submitted
        if ($formCategory->isValid() && $formCategory->isSubmitted()) {   
            $manager->persist($category);
            $manager->flush();
           // return new Response('Le catégorie est  ajoutée avec succès !'); 
        }
        return $this->render('category/new.html.twig', array('formCategory' =>
        $formCategory->createView(),'buttonMode'=>'add'));
    }
    ///-----

       /**
     * @Route("category/{id}/update",name="category_update")
     */
    public function updateCategory(Category $category ,Request $request, ObjectManager $manager)
    {  
        
        $formCategory = $this->createForm(CategoryType::class,$category);
        
        //Request Handling
        $formCategory->handleRequest($request);
        $category = $formCategory->getData();

        //Test if the form is validate and  submitted
        if ($formCategory->isValid() && $formCategory->isSubmitted()) {   
            $manager->persist($category);
            $manager->flush();
           // return new Response('Le catégorie est  ajoutée avec succès !'); 
        }
        return $this->render('category/new.html.twig', array('formCategory' =>
        $formCategory->createView(),'buttonMode'=>'update'));
    }
    ///-----
}
