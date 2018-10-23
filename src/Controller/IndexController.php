<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController2',
        ]);
    }
        /**
     * @Route("/index2", name="index2")
     */
     public function index2()
     {
         return $this->render('index/index.html.twig', [
             'controller_name' => 'IndexController',
         ]);
     }
}
