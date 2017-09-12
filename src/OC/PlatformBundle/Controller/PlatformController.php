<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use OC\PlatformBundle\Entity\Article;
use OC\PlatformBundle\Entity\User;
use OC\PlatformBundle\Form\ArticleType;

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
     * @Route("/creation", name="oc_platform_creation")
     */
	public function creationAction(Request $request)
	{
		$article = new Article();
		$form   = $this->get('form.factory')->create(ArticleType::class, $article);

		if ($request->isMethod('POST')) {
			
			$form->handleRequest($request);

			if ($form->isValid()) {

				$article->setUser( $this->getUser());

				$em = $this->getDoctrine()->getManager();
				$em->persist($article);
				$em->flush();
			}
		}

		return $this->render('OCPlatformBundle:Default:creation.html.twig', array(
			'form' => $form->createView(),
			));
	}

	/**
     * @Route("/edition/{id}", name="oc_platform_edition")
     */
	public function editionAction(Request $request,article $article, $id)
	{
		
		$form   = $this->get('form.factory')->create(ArticleType::class, $article);

		if ($request->isMethod('POST')) {
			
			$form->handleRequest($request);

			if ($form->isValid()) {

				$em = $this->getDoctrine()->getManager();
				$em->flush();
			}
		}

		return $this->render('OCPlatformBundle:Default:edition.html.twig', array(
			'form' => $form->createView(),
			));
	}

	/**
     * @Route("/article/{id}", name="oc_platform_article")
     */
	public function articleAction(article $article, $id)
	{

		return $this->render('OCPlatformBundle:Default:article.html.twig', array(
			'article' => $article
			));
	}
}
