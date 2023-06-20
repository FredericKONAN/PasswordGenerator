<?php

namespace App\Controller;

use App\Service\PasswordGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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
    public function home(): Response
    {
        return $this->render("pages/home.html.twig", [
            'password_default_length' => $this->getParameter('app.password_default_length'),
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
//         $length            =$request->query->getInt('length');
//         $uppercaseLatters  =$request->query->getBoolean('uppercase_latters');
//         $digits            =$request->query->getBoolean('digits');
//         $specialCharacters =$request->query->getBoolean('special_characters');
        //Nous nous assurons que la longueur du mot de passe est toujours
        // au minimum {app.password_min_length}
        // et au maximum {app.password_max_length}.
        $length = max(min(
            $request->query->getInt('length'),
            $this->getParameter('app.password_max_length')),
            $this->getParameter('app.password_min_length'));

         $password = $passwordGenerator->generate(
             $length,
             $request->query->getBoolean('uppercase_latters'),
             $request->query->getBoolean('digits'),
             $request->query->getBoolean('special_characters'),
         );

        return $this->render("pages/generatePassword.html.twig",compact('password'));
     }

}
