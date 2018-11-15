<?php

namespace App\Controller;
//use symfony\Flex\Response;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Event;
//use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Validator\Constraints\Date;


class EventController extends Controller
{
    /**
     * @Route("/", name="show_events")
     */
    public function index()
    {   

        $ev = $this->getDoctrine()->getManager();
        $allEvents = $ev->getRepository(Event::class)->findAll();
        if (!$allEvents) {
        throw $this->createNotFoundException(
            'Aucun évenement trouvé '
        );
        }
        return $this->render('event/index.html.twig', array(
            'events' => $allEvents,
        ));
      
    }

      /**
     * @Route("event/{id}",name="show_info_event")
     */
    public function showEvent($id)
    {  
        
        $repo = $this->getDoctrine()->getRepository(Event::class);
        
        //Request Handling
        $event= $repo->find($id);
        //$event = $formEvent->getData();

       
        return $this->render('event/showEvent.html.twig',  array(
            'event' => $event));
    }
    
     /**
     * @Route("/new",name="event_new")
     */
    public function new(Request $request, ObjectManager $manager)
    {  
        $event = new Event();

        $formEvent = $this->createFormBuilder($event)
                     ->add('name')
                     ->add('description')
                     ->add('category')
                     ->add('date')
                     ->add('Add', SubmitType::class)
                     ->getForm();
        
        //Request Handling
        $formEvent->handleRequest($request);
        $event = $formEvent->getData();

        //Test if the form is validate and  submitted
        if ($formEvent->isValid() && $formEvent->isSubmitted()) {
           // $event->setCreatdAt(new \DateTime());
            
            $manager->persist($event);
            $manager->flush();
            return $this->redirectToRoute("show_events");
        }else
            return $this->render('event/new.html.twig', array('formEvent' =>
            $formEvent->createView()));
    }

    /**
     * @Route("/delete/{id}",name="deleteEvent")
     */
    public function deleteCategory($id)
    {  
        
        $repo = $this->getDoctrine()->getManager();
        $event =$repo->getRepository(Event::class)->find($id);
        $repo->remove($event);
        $repo->flush();
        return $this->redirectToRoute("show_events");
    }

      /**
     * @Route("update/{id}",name="EventUpdate")
     */
    public function updateEvent(Event $event ,Request $request, ObjectManager $manager)
    {  
        
      
       $formEvent = $this->createFormBuilder($event)
                            ->add('name')
                            ->add('description')
                            ->add('category')
                            ->add('date')
                            ->add('Update', SubmitType::class)
                            ->getForm();
        //Request Handling
        $formEvent->handleRequest($request);
        $event = $formEvent->getData();

        //Test if the form is validate and  submitted
        if ($formEvent->isValid() && $formEvent->isSubmitted()) {   
            $manager->persist($event);
            $manager->flush();
            return $this->redirectToRoute("show_events"); 
        }
        return $this->render('event/new.html.twig', array('formEvent' =>
            $formEvent->createView()));
    }
}
