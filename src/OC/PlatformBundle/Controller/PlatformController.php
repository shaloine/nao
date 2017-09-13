<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use OC\PlatformBundle\Entity\Article;
use OC\PlatformBundle\Entity\User;
use OC\PlatformBundle\Form\ArticleType;
use OC\PlatformBundle\Entity\Comment;
use OC\PlatformBundle\Form\CommentType;
use OC\PlatformBundle\Entity\Observation;
use OC\PlatformBundle\Form\ObservationType;


class PlatformController extends Controller
{	
	/**
     * @Route("/", name="oc_platform_homepage")
     */
	public function indexAction()
	{
		return $this->render('OCPlatformBundle:Default:index.html.twig');
	}

    /**
     * @Route("/observation", name="oc_platform_observation")
     */
    public function observAction(Request $request)
    {
    	$observation = new Observation();
    	$user = $this->getUser();
    	$form = $this->get('form.factory')->create(ObservationType::class , $observation);

    	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
    		$em = $this->getDoctrine()->getManager();

    		$observation->setUser($user);
    		$em->persist($observation);

    		$picture = $observation->getPicture();
    		if ($picture !== null)
    		{
    			$picture->setAlt($observation->getTaxref()->getNomVern());
    			$em->persist($picture);
    		}

    		$em->flush();

    		$request->getSession()->getFlashBag()->add('info', 'Votre observation a bien été enregistrée.');
    		return $this->redirectToRoute('oc_platform_homepage');
    	}

    	return $this->render('OCPlatformBundle:Default:observ.html.twig', array(
    		'form' => $form->createView()
    		));
    }

	/**
     * @Route("/blog", name="oc_platform_blog")
     */
	public function blogAction()
	{
		$em = $this->getDoctrine()->getManager();

		$articles = $em->getRepository('OCPlatformBundle:Article')->findAll();

		return $this->render('OCPlatformBundle:Default:blog.html.twig', array(
			'articles' => $articles,
			));
	}

	/**
     * @Route("/blog/creation", name="oc_platform_creation")
     */
	public function creationAction(Request $request)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

			$article = new Article();
			$form   = $this->get('form.factory')->create(ArticleType::class, $article);

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

				$article->setUser( $this->getUser());

				$em = $this->getDoctrine()->getManager();
				$em->persist($article);
				$em->flush();

				$request->getSession()->getFlashBag()->add('info', 'Votre article a bien été enregistrée.');

			}

			return $this->render('OCPlatformBundle:Default:creation.html.twig', array(
				'form' => $form->createView(),
				));
		}

		return $this->redirectToRoute('oc_platform_homepage');
	}

	/**
     * @Route("/blog/edition/{id}", name="oc_platform_edition")
     */
	public function editionAction(Request $request,article $article, $id)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

			$form   = $this->get('form.factory')->create(ArticleType::class, $article);

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

				$em = $this->getDoctrine()->getManager();
				$em->flush();

				$request->getSession()->getFlashBag()->add('info', 'Votre commentaire a bien été enregistrée.');

			}

			return $this->render('OCPlatformBundle:Default:edition.html.twig', array(
				'form' => $form->createView(),
				));
		}
		return $this->redirectToRoute('oc_platform_homepage');
	}

	/**
     * @Route("/blog/article/{id}", name="oc_platform_article")
     */
	public function articleAction(Request $request, article $article, $id)
	{
		$comment = new Comment();
		$form   = $this->get('form.factory')->create(CommentType::class, $comment);

		$em = $this->getDoctrine()->getManager();

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

			$comment->setUser($this->getUser());
			$comment->setArticle($article);
			$em->persist($comment);
			$em->flush();
			
			// to clear the form
			$comment = new Comment();
			$form   = $this->get('form.factory')->create(CommentType::class, $comment);
		}

		$comments = $em->getRepository('OCPlatformBundle:Comment')->findBY(array('article' => $article),array('id' => 'desc')); 

		return $this->render('OCPlatformBundle:Default:article.html.twig', array(
			'article' => $article,
			'form' => $form->createView(),
			'comments' => $comments,
			));
	}

	/**
     * @Route("/blog/comment/{id}", name="oc_platform_signalComment")
     */
	public function signalCommentAction(Comment $comment, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$comment->setWarning(true);
		$em->flush();

		$request->getSession()->getFlashBag()->add('info', 'Le commentaire a été signalé.');

		return $this->redirectToRoute('oc_platform_article', array('id' => $comment->getArticle()->getId()));

	}

}
