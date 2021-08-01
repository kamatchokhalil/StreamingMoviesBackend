<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CusController extends AbstractController
{

    private $cusReposiotry;
    public function __construct(){
       
    }
    /**
     * @Route("/cus", name="Getcus" ,methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            
        ]);
    }
}
