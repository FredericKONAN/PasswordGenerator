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

    /**
     * @throws \Exception
     */
    #[Route('/generate-password', name: 'app_generate_password')]
     public function generatePassword(Request $request): Response
     {
         $length            =$request->query->getInt('length');
         $uppercaseLatters  =$request->query->getBoolean('uppercase_latters');
         $digits            =$request->query->getBoolean('digits');
         $specialCharacters =$request->query->getBoolean('special_characters');


         //Recuperation des lettres de [a-z] en minuscules
         $lowerCaseLattersSet = range('a','z');
         $upperCaseLattersSet = range('A', 'Z');
         $digitsSet = range(0, 9);
         $specialCharactersSet = range('!', '@');

         $characters= $lowerCaseLattersSet;
         $password = '';

         $password .= $lowerCaseLattersSet[random_int(0, count($lowerCaseLattersSet)-1)];

         // Ajout de lettre en minuscule
         if($uppercaseLatters){
             //fusion des deux tables [a-z] et [A-Z] avec array_merge()
             $characters = array_merge($characters, $upperCaseLattersSet);

             ////On rajoute une lettre en majuscule de maniere aleatoire
             $password .=$upperCaseLattersSet[random_int(0, count($upperCaseLattersSet)-1)] ;
         }
         if($digits){
             $characters = array_merge($characters, $digitsSet);

             //On rajoute un nombre de maniere aleatoire
             $password .=$digitsSet[random_int(0, count($digitsSet)-1)] ;
         }
         if ($specialCharacters){
//           $characters = array_merge($characters,['!', '#', '$', '%', '&', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', ']', '^', '_', '`', '{', '|', '}', '~']);
             $characters = array_merge($characters, $specialCharactersSet);

             //On rajoute un caractere special de maniere aleatoire
             $password .=$specialCharactersSet[random_int(0, count($specialCharactersSet)-1)] ;

         }

         $numberOfChractersRumuning = $length -mb_strlen($password);
            //dd($password);

         for ($i = 0; $i<$numberOfChractersRumuning; $i++){
//         $password .=$characters[mt_rand(0, count($characters)-1)];
//         $password .=$characters[array_rand(array: $characters)];
           $password .=$characters[random_int(0, count($characters)-1)];// Plus securisé
         }

         //Convertie la chaine de caractere en tableau
         $password = str_split($password);

         $password= $this->secureShuffle($password);

         //Convertie le tableau en chaine caractere
         $password = implode('', $password);

        return $this->render("pages/generatePassword.html.twig",compact('password'));
     }

     private function secureShuffle(array $arr):array
     {
//         $arr = array_values($arr); on recupere un tableau numerote
         $length = count($arr);

         for ($i = $length - 1; $i>0; $i--) {
             $j = random_int(0, $i);
             $tmp       = $arr[$i];
             $arr[$i]   = $arr[$j];
             $arr[$j]   = $tmp;
         }
        return $arr ;
     }
}
