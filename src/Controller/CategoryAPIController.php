<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Event;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CategoryAPIController extends AbstractController
{


    /**
    * @Route("/api/categories",name="api_allCategory",methods={"GET","HEAD"})
    */
    public function showall()
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }

        $categories = $this->getDoctrine()
                           ->getRepository(Category::class)
                           ->findAll();

        $jsonContent = $serializer->serialize($categories, 'json');

        $response = new JsonResponse();
        $response->setContent($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode('200');

        return $response;
    }

    /**
     * @Route("/api/addCategory",name="Api_category_new",methods={"POST", "OPTIONS"})
     */
    public function addCategory(Request $request)
    {  
        $response = new Response();
        $query = array();
        $json = $request->getContent();
        $content = json_decode($json, true);

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'POST, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }
       
        
        if (isset($content["name"]) && isset($content["description"]))
        {
            
            $cat = new Category();
            $cat->setName($content["name"]);
            $cat->setDescription($content["description"]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();
            
            $query['valid'] = true; 
            $query['data'] = array('name' => $content["name"],
                                   'description' => $content["description"]);
            $response->setStatusCode('201');
        }
        else 
        {
            $query['valid'] = true; 
            $query['data'] = null;
            $response->setStatusCode('404');
        }        

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($query));
        return $response; 
    }

     /**
     * @Route("/api/category/{id}",name="api_show_info_category",methods={"GET","HEAD"})
     */
    public function showCategory($id)
    {  
        
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET,OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }

        if ($id != null) {
            $categories = $this->getDoctrine()
                            ->getRepository(Category::class)
                            ->find($id);

            $jsonContent = $serializer->serialize($categories, 'json');

            $response = new JsonResponse();
            $response->setContent($jsonContent);
            
        }
        else
            {
                $query['valid'] = false; 
                $response->setStatusCode('404');
            }
        
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode('200');
        
        return $response;
    }

     /**
     * @Route("/api/deleteCategory/{id}",name="api_deleteCategory",methods={"DELETE", "OPTIONS"})
     */
    public function deleteCategory($id)
    {  
        
        $response = new Response();
        $query = array();

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }

        if ($id != null) {
            $em = $this->getdoctrine()->getManager();
            $category = $em->getRepository(Category::class)->find($id);
            $em->remove($category);
            $em->flush();

            $query['valid'] = true; 
            $response->setStatusCode('200');
        }
        else
        {
            $query['valid'] = false; 
            $response->setStatusCode('404');
        }

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($query));

        return $response;
    }

   

    /**
     * @Route("/api/updateCategory/{id}",name="Api_categoryUpdate",methods={"PUT", "OPTIONS"})
     */
    public function updateCategory($id,Request $request)
    {  
        
        $response = new Response();
        $query = array();

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'PUT, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }

        $json = $request->getContent();
        $content = json_decode($json, true);

        if ($id!= null)
        {
            $category = $this->getDoctrine()
                     ->getRepository(Category::class)
                     ->find($id);

            $category->setName($content["name"]);
            $category->setDescription($content["description"]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $query['valid'] = true; 
            $query['data'] = array('id' => $id,
                                   'name' => $content["name"],
                                   'description' => $content["description"]);
            $response->setStatusCode('200');
        }
        else 
        {
            $query['valid'] = false; 
            $query['data'] = null;
            $response->setStatusCode('404');
        }        

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($query));

        return $response;

    }
    
}
