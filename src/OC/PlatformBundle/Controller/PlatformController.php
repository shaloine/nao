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
     * @Route("/blog/edition/{id}", name="oc_platform_edition")
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
     * @Route("/blog/article/{id}", name="oc_platform_article")
     */
	public function articleAction(article $article, $id)
	{

		return $this->render('OCPlatformBundle:Default:article.html.twig', array(
			'article' => $article
			));
	}
}
