<?php

namespace App\Service;

class PasswordGenerator
{


    public function generate(
        int $length,
        bool $uppercaseLatters = false,
        bool $digits = false,
        bool $specialCharacters = false,
    ): string
    {
        //Recuperation des lettres de [a-z] en minuscules
        $lowerCaseLattersSet = range('a','z');
        $upperCaseLattersSet = range('A', 'Z');
        $digitsSet = range(0, 9);
        $specialCharactersSet = array_merge(
            range('!', '/'),
            range(':', '@'),
            range('[', '`'),
            range('{', '~'),
        );

        $characters= $lowerCaseLattersSet;

        $password = [$this->pickRandomItemFromTab($lowerCaseLattersSet)];

        // Ajout de lettre en minuscule
        if($uppercaseLatters){
            //fusion des deux tables [a-z] et [A-Z] avec array_merge()
            $characters = array_merge($characters, $upperCaseLattersSet);

            ////On rajoute une lettre en majuscule de maniere aleatoire
            $password []=$this->pickRandomItemFromTab($upperCaseLattersSet) ;
        }
        if($digits){
            $characters = array_merge($characters, $digitsSet);

            //On rajoute un nombre de maniere aleatoire
            $password []=$this->pickRandomItemFromTab($digitsSet) ;
        }
        if ($specialCharacters){
//           $characters = array_merge($characters,['!', '#', '$', '%', '&', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', ']', '^', '_', '`', '{', '|', '}', '~']);
            $characters = array_merge($characters, $specialCharactersSet);

            //On rajoute un caractere special de maniere aleatoire
            $password []=$this->pickRandomItemFromTab($specialCharactersSet ) ;

        }

        $numberOfChractersRumuning = $length -count($password);
        //dd($password);

        for ($i = 0; $i<$numberOfChractersRumuning; $i++){
//         $password .=$characters[mt_rand(0, count($characters)-1)];
//         $password .=$characters[array_rand(array: $characters)];
            $password []=$this->pickRandomItemFromTab($characters);// Plus securisé
        }

        //Convertie la chaine de caractere en tableau
//         $password = str_split($password);

        $password= $this->secureShuffle($password);

        //Convertie le tableau en chaine caractere
        return implode('', $password) ;

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

    private function pickRandomItemFromTab(array $tab): string
    {
        return $tab[random_int(0, count($tab)-1)];
    }

}