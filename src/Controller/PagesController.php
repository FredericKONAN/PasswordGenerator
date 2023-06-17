<?php

namespace App\Controller;

use App\Service\PasswordGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render("pages/home.html.twig");
    }

    /**
     * @throws \Exception
     */
    #[Route('/generate-password', name: 'app_generate_password')]
     public function generatePassword(Request $request): Response
     {
//         $length            =$request->query->getInt('length');
//         $uppercaseLatters  =$request->query->getBoolean('uppercase_latters');
//         $digits            =$request->query->getBoolean('digits');
//         $specialCharacters =$request->query->getBoolean('special_characters');

         $passwordGenerate = new PasswordGenerator();
         
         $password = $passwordGenerate->generate(
             $request->query->getInt('length'),
             $request->query->getBoolean('uppercase_latters'),
             $request->query->getBoolean('digits'),
             $request->query->getBoolean('special_characters'),
         );

        return $this->render("pages/generatePassword.html.twig",compact('password'));
     }

}
