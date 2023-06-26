<?php

namespace App\Controller;

use App\Service\PasswordGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
//    CONST PASSWORD_DEFAULT_LENGTH = 12;
//    CONST PASSWORD_MIN_LENGTH = 8;
//    const PASSWORD_MAX_LENGTH = 60;

    #[Route('/', name: 'app_home')]
    public function home(Request $request): Response
    {


        return $this->render("pages/home.html.twig", [
            'password_default_length' => $request->cookies->getInt('app_length',$this->getParameter('app.password_default_length')),
            'uppercase_letters'=>$request->cookies->getBoolean('app_uppercase_letters'),
            'digits'=>$request->cookies->getBoolean('app_digits'),
            'special_characters'=>$request->cookies->getBoolean('app_special_characters'),
            'password_min_length' => $this->getParameter('app.password_min_length'),
            'password_max_length' => $this->getParameter('app.password_max_length'),
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/generate-password', name: 'app_generate_password')]
     public function generatePassword(Request $request, PasswordGenerator $passwordGenerator): Response
     {
        //Nous nous assurons que la longueur du mot de passe est toujours
        // au minimum {app.password_min_length}
        // et au maximum {app.password_max_length}.
        $length = max(min(
            $request->query->getInt('length'),
            $this->getParameter('app.password_max_length')),
            $this->getParameter('app.password_min_length'));

        $uppercaseLatters  =$request->query->getBoolean('uppercase_letters');
        $digits            =$request->query->getBoolean('digits');
        $specialCharacters =$request->query->getBoolean('special_characters');

//        //Methode 1 pour stoker les preferences de l'utilisateur avec la session de symfony
//         $session = $request->getSession();
//
//         $session->set('app.length', $length);
//         $session->set('app.upperCaseLetters', $uppercaseLatters);
//         $session->set('app.digits', $digits);
//         $session->set('app.specialCharacters', $specialCharacters);


         $password = $passwordGenerator->generate(
             $length,
             $uppercaseLatters,
             $digits,
             $specialCharacters,
         );

        $response = $this->render("pages/generatePassword.html.twig",compact('password'));

       $response->headers->setCookie(
            new Cookie(
            'app_length', $length, new \DateTimeImmutable('+5 years')
            ));

        $response->headers->setCookie(
            new Cookie(
                'app_uppercase_letters', $uppercaseLatters? '1':'0', new \DateTimeImmutable('+5 years')
            ));

        $response->headers->setCookie(
            new Cookie(
                'app_digits', $digits? '1':'0', new \DateTimeImmutable('+5 years')
            ));
        $response->headers->setCookie(
            new Cookie(
                'app_special_characters', $specialCharacters? '1':'0', new \DateTimeImmutable('+5 years')
            ));

        return $response;
     }

}
