<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login" ,methods={"POST"})
     */
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }


    /**
     * @Route("/login", name="login" ,methods={"POST"})
     */
    public function Connection(Request $req): JsonResponse
    {
        $data = json_decode($req->getContent(), true);
        $repository = $this->getDoctrine()->getRepository(User::class);

        $username = $data['username'];
        $password = $data['password'];
        $account = $repository->findOneBy([
            'username' =>  $username,
            'password' => $password,
        ]);
        if($account  != null){
            return new JsonResponse($account->toArray(), Response::HTTP_CREATED);
        }
        return  new JsonResponse(['status' => 'not connected'], Response::HTTP_BAD_REQUEST);
      
    }
}
