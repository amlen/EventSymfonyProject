<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Event;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Validator\Constraints\Date;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EventAPIController extends AbstractController
{
    /**
     * @Route("/api/events", name="api_show_events",methods={"GET","HEAD"})
     */
    public function index()
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
                           ->getRepository(Event::class)
                           ->findAll();

        $jsonContent = $serializer->serialize($categories, 'json');

        $response = new JsonResponse();
        $response->setContent($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode('200');

        return $response;
      
    }

    
    /**
     * @Route("/api/addEvent",name="api_event_new",methods={"POST"})
     */
    public function addEvent(Request $request)
    {  
        $response = new Response();
        $query = array();
        $json = $request->getContent();
        $content = json_decode($json, true);
        $eve = new Event();
        
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods',  'POST,  OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }
      
        //var_dump($content);
        if (isset($content["name"]) && isset($content["description"]) && isset($content["date"])
            && isset($content["category"]))
        {
            
            $category = $this->getDoctrine()
                     ->getRepository(Category::class)
                     ->find($content["category"]);

            $eve->setName($content["name"]);
            $eve->setDescription($content["description"]);
            $eve->setDate($content["date"]);
            $eve->setCategory($category);

            $em = $this->getDoctrine()->getManager();
            $em->persist($eve);
            $em->flush();
            
            $query['valid'] = true; 
            $query['data'] = array('name' => $content["name"],
                                   'description' => $content["description"],
                                   'category' => $content["category"],
                                   'date' => $content["date"]
                                );
            $response->setStatusCode('201');
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

     /**
     * @Route("/api/event/{id}",name="api_show_info_event",methods={"GET","HEAD"})
     */
    public function showEvent($id)
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

        if ($id != null) {
            $event = $this->getDoctrine()
                            ->getRepository(Event::class)
                            ->find($id);

            $jsonContent = $serializer->serialize($event, 'json');

            $response = new JsonResponse();
            $response->setContent($jsonContent);
            
        }
        else
            {
                $query['valid'] = false; 
                $response->setStatusCode('404');
            }
        
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode('201');
        
        return $response;
    }

     /**
     * @Route("/api/deleteEvent/{id}",name="api_deleteEvent",methods={"DELETE", "OPTIONS"})
     */
    public function deleteEvent($id)
    {  
        
        $response = new Response();
        $query = array();

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', ' DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }

        if ($id != null) {
            $em = $this->getdoctrine()->getManager();
            $event = $em->getRepository(Event::class)->find($id);
            $em->remove($event);
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
     * @Route("/api/updateEvent/{id}",name="api_categoryUpdate",methods={"PUT", "OPTIONS"})
     */
    public function updateEvent($id,Request $request)//ok
    {  
        
        $response = new Response();
        $query = array();

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', ' PUT, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }

        $json = $request->getContent();
        $content = json_decode($json, true);

        
        if ($id!= null)
        {
            $event = $this->getDoctrine()
                     ->getRepository(Event::class)
                     ->find($id);
            $category = $this->getDoctrine()
                     ->getRepository(Category::class)
                     ->find($content["category"]);

            $event->setName($content["name"]);
            $event->setDescription($content["description"]);
            $event->setDate($content["date"]);
            $event->setCategory($category);

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $query['valid'] = true; 
            $query['data'] = array('name' => $content["name"],
                                    'description' => $content["description"],
                                    'category' => $content["category"],
                                    'date' => $content["date"]
                                );
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
