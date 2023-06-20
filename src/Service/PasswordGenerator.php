<?php

namespace App\Service;

class PasswordGenerator
{


    public function generate(int $length, bool $uppercaseLatters = false, bool $digits = false, bool $specialCharacters = false,): string
    {
        //On defini nos differents ensemble de caracteres
        $lowerCaseLattersSet = range('a','z');
        $upperCaseLattersSet = range('A', 'Z');
        $digitsSet = range(0, 9);
        $specialCharactersSet = array_merge(
            range('!', '/'),
            range(':', '@'),
            range('[', '`'),
            range('{', '~'),
        );

        // Par defaut on rajoute l'ensemble des caracters [a-z] en minuscule
        $characters= [$lowerCaseLattersSet];
        //Rajoute aleatoirement au moins une lettre en minuscule de notre [a-z]
        $password = [$this->pickRandomItemFromTab($lowerCaseLattersSet)];
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

        // Mapper les contraintes à la lettre associée
        $mapping = [
            [$uppercaseLatters, $upperCaseLattersSet],
            [$digits, $digitsSet],
            [$specialCharacters , $specialCharactersSet],
        ];


        //Nous nous assurons que le mot de passe final contient au
        // moins une {lettre majuscule et/ou chiffre et/ou caractère spécial}
        //en fonction des contraintes demandées par l'utilisateur.
        //on fait aussi grossir en même temps le jeu de caractères
        // final avec le jeu de caractères de la contrainte demandée.
        foreach ($mapping as [$constraintEnable , $charctersSet]){

            if ($constraintEnable){
                $characters[] =  $charctersSet;
                $password []= $this->pickRandomItemFromTab($charctersSet );
            }
        }

        //Deconseil d'utiliser array_merge() au sien d'un foreach, consomme assez de memoire.
        $characters = array_merge(...$characters);

        $numberOfChractersRumuning = $length -count($password);

        for ($i = 0; $i<$numberOfChractersRumuning; $i++){
//         $password .=$characters[mt_rand(0, count($characters)-1)];
//         $password .=$characters[array_rand(array: $characters)];
            $password []=$this->pickRandomItemFromTab($characters);// Plus securisé
        }

        //Convertie la chaine de caractere en tableau avec str_split
//         $password = str_split($password);

        //Nous mélangeons le tableau pour rendre l'ordre des caractères de mot de passe imprévisible.
        $password= $this->secureShuffle($password);

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