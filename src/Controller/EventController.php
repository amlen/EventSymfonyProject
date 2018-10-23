<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Event;
use App\Entity\Category;
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
     * @Route("/", name="event")
     */
    public function index()
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
    /**
     * @Route("/add",name="event_add")
     */
    public function AddEvent(Request $request,ObjectManager $manager){
        dump($request);

        if($request->request->count() > 0){
            $event = new Event();
            $event-> setNom($request->$request->get('nom'))
                  -> setDescription($request->$request->get('description'))
                  -> setDate($request->$request->get('date'));
            
            $manager->persist($event);
            $manager->flush();
        }
        return $this->render('event/addEvent.html.twig');
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
                     ->add('date')
                   /*  ->add('categoryId', EntityType::class, [
                         
                         // looks for choices from this entity
                        'class' => Category::class,

                        // uses the User.username property as the visible option string
                        'Choice_label' => 'name',
                        ])*/
                     ->add('Add', SubmitType::class)
                    
                     ->getForm();
        
        //Request Handling
        $formEvent->handleRequest($request);
        $event = $formEvent->getData();

        //Test if the form is validate and  submitted
        if ($formEvent->isValid() && $formEvent->isSubmitted()) {
            $event->setCreatdAt(new \DateTime());
            
            $manager->persist($event);
            $manager->flush();
            return new Response('La tâche ajoutée avec succès !'); 
        }
        return $this->render('event/new.html.twig', array('formEvent' =>
        $formEvent->createView()));
    }
}
