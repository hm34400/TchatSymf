<?php
namespace AppBundle\Handler;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthenticationHandler
 *
 * @author loic
 */
  //ce handler permet de gérer des actions lors de la deconnexion de l'utilisateur
class LogoutHandler implements LogoutSuccessHandlerInterface{
    
    //la fonction va permettre de deconnecter l'utilisateur de la session
    public function onLogoutSuccess(Request $request) {
        // on redirige vers la route choisi
        return new RedirectResponse("./disconnect/".$request->getSession()->get("usr"));
    }


}
