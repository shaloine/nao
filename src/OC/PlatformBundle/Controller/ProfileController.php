<?php

namespace OC\PlatformBundle\Controller;


use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\ProfileController as BaseController;


class ProfileController extends BaseController
{
    
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();

        // Get back and returns all data associated with an user
        $articles = $em->getRepository('OCPlatformBundle:Article')->findAll();
        $comments = $em->getRepository('OCPlatformBundle:Comment')->findBy(array('warning' => '1'));
        $userObservations = $em->getRepository('OCPlatformBundle:Observation')->findBy(array('user' => $this->getUser()), array('date' => 'desc'));
        $ObservsToValid = $em->getRepository('OCPlatformBundle:Observation')->findBy(array('validated' => false), array('date' => 'asc'));
        $UsersToValid = $em->getRepository('OCPlatformBundle:User')->findBy(array('naturalist' => 1));
        $users = $em->getRepository('OCPlatformBundle:User')->findAll();

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'articles' => $articles,
            'comments' => $comments,
            'userObservations' => $userObservations,
            'ObservsToValid' => $ObservsToValid,
            'UsersToValid' => $UsersToValid,
            'users' => $users
        ));
    }

}
