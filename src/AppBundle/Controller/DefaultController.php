<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\Utilisateur;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/tchat")
 */
class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $user = $this->getUser();
        $user->setConnected(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $request->getSession()->set("usr", $user->getId());
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/users")
     */
    //on recupere une liste d'utilisateur
    public function getUsers() {

        return new JsonResponse($this->getDoctrine()->getRepository(Utilisateur::class)->findBy(array("connected" => "1")));
//        return new JsonResponse($this->getDoctrine()->getRepository(Utilisateur::class)->findAll());
    }

    /**
     * @Route("/messages")
     */
    //on recupere une liste de message
    public function getMessages() {

        return new JsonResponse($this->getDoctrine()->getRepository(Message::class)->findAll());
    }

    /**
     * @Route("/message/add")
     * @param Request $r
     */
    public function addMessage(Request $r) {
        $user = $this->getUser();
        $message = new Message();
        $message->setMessage($r->get("msg"));
        $message->setUtilisateur($user);
        $d = new DateTime();
        $d->setTimestamp(time());
        $d->format('Y-m-d H:i:s');
        $message->setHeure($d);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();
        return new Response("ok");
    }
    
    /**
     *@Route("/user/afk") 
     */
    public function setAfk(Request $r){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user -> setAfk(1);
        $em->merge($user);
        $em->flush();
        return new Response("afk");
    }
    /**
     *@Route("/user/noafk") 
     */
    public function setNoAfk(Request $r){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user -> setAfk(0);
        $em->merge($user);
        $em->flush();
        return new Response("no afk");
    }
    /**
     * @Route("/user/typing")
     */
    public function switchTyping(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->setTyping(!$user->getTyping());
        $em->merge($user);
        $em->flush();
        return new Response("typing");
    }


}
