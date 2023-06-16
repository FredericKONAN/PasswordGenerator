<?php

namespace App\Controller;

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

    #[Route('/generate-password', name: 'app_generate_password')]
     public function generatePassword(Request $request)
     {
         $length            =$request->query->getInt('length');
         $uppercaseLatters  =$request->query->getBoolean('uppercase_latters');
         $digits            =$request->query->getBoolean('digits');
         $specialCharacters =$request->query->getBoolean('special_characters');

         //       Recuperation des lettres de [a-z] en minuscules
         $characters = range('a','z');

         if($uppercaseLatters){
             //fusion des deux tables [a-z] et [A-Z] avec array_merge()
             $characters = array_merge($characters, range('A', 'Z'));
         }
         if($digits){
             $characters = array_merge($characters, range(0, 9));
         }
         if ($specialCharacters){
//           $characters = array_merge($characters,['!', '#', '$', '%', '&', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', ']', '^', '_', '`', '{', '|', '}', '~']);
             $characters = array_merge($characters, range('!', '@'));
         }

         shuffle($characters);
         $password = '';

         for ($i = 0; $i<$length; $i++){

//           $password .=$characters[mt_rand(0, count($characters)-1)];
             $password .=$characters[array_rand(array: $characters)];
         }

        return $this->render("pages/generatePassword.html.twig",compact('password'));
     }
}
