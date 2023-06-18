<?php

namespace App\Service;

class PasswordGenerator
{


    public function generate(int $length, bool $uppercaseLatters = false, bool $digits = false, bool $specialCharacters = false,): string
    {
        //Recuperation des caracteres
        $lowerCaseLattersSet = range('a','z');
        $upperCaseLattersSet = range('A', 'Z');
        $digitsSet = range(0, 9);
        $specialCharactersSet = array_merge(
            range('!', '/'),
            range(':', '@'),
            range('[', '`'),
            range('{', '~'),
        );


        $characters= $lowerCaseLattersSet;// //On affecte les caracters de l'Alphabet [a-z] en minuscule
        $password = [$this->pickRandomItemFromTab($lowerCaseLattersSet)];//Rajoute aleatoire au moins d'une lettre en minuscule

//        // Ajout de lettre en minuscule
//        if($uppercaseLatters){
//            //fusion des deux tables [a-z] et [A-Z] avec array_merge()
//            $characters = array_merge($characters, $upperCaseLattersSet);
//
//            ////On rajoute une lettre en majuscule de maniere aleatoire
//            $password []=$this->pickRandomItemFromTab($upperCaseLattersSet) ;
//        }
//        if($digits){
//            $characters = array_merge($characters, $digitsSet);
//
//            //On rajoute un nombre de maniere aleatoire
//            $password []=$this->pickRandomItemFromTab($digitsSet) ;
//        }
//        if ($specialCharacters){
////           $characters = array_merge($characters,['!', '#', '$', '%', '&', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', ']', '^', '_', '`', '{', '|', '}', '~']);
//            $characters = array_merge($characters, $specialCharactersSet);
//
//            //On rajoute un caractere special de maniere aleatoire
//            $password []=$this->pickRandomItemFromTab($specialCharactersSet ) ;
//
//        }

        // Refactoring

        $mapping = [
            'uppercaseLatters' => $upperCaseLattersSet,
            'digits' => $digitsSet,
            'specialCharacters' => $specialCharactersSet,
        ];

        foreach ($mapping as $constraintEnable => $charctersSet){

            if ($$constraintEnable){
                $characters = array_merge($characters, $charctersSet);
                $password []= $this->pickRandomItemFromTab($charctersSet );
            }
        }

        $numberOfChractersRumuning = $length -count($password);

        for ($i = 0; $i<$numberOfChractersRumuning; $i++){
//         $password .=$characters[mt_rand(0, count($characters)-1)];
//         $password .=$characters[array_rand(array: $characters)];
            $password []=$this->pickRandomItemFromTab($characters);// Plus securisé
        }

        //Convertie la chaine de caractere en tableau avec str_split
//         $password = str_split($password);

        $password= $this->secureShuffle($password); // Melange elements de notre tableau

        //Convertie le tableau en chaine caractere
        return implode('', $password) ;

    }
    
    private function secureShuffle(array $arr):array
    {
        $length = count($arr);
        for ($i = $length - 1; $i>0; $i--) {
            $j = random_int(0, $i);
            $tmp       = $arr[$i];
            $arr[$i]   = $arr[$j];
            $arr[$j]   = $tmp;
        }
        return $arr ;
    }

    private function pickRandomItemFromTab(array $tab): string
    {
        return $tab[random_int(0, count($tab)-1)];
    }

}