<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swift_Message;

use OC\PlatformBundle\Entity\Article;
use OC\PlatformBundle\Entity\ArticlePicture;
use OC\PlatformBundle\Entity\User;
use OC\PlatformBundle\Form\ArticleType;
use OC\PlatformBundle\Entity\Comment;
use OC\PlatformBundle\Form\CommentType;
use OC\PlatformBundle\Form\ContactType;
use OC\PlatformBundle\Entity\Observation;
use OC\PlatformBundle\Form\ObservationType;
use OC\PlatformBundle\Entity\Taxref;
use OC\PlatformBundle\Form\TaxrefType;
use OC\PlatformBundle\Entity\Search;
use OC\PlatformBundle\Form\SearchType;


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
     * @Route("/consultation", name="oc_platform_consultation")
     */
    public function consultAction(Request $request)
    {
        $search = new Taxref();
        $form = $this->get('form.factory')->create(TaxrefType::class, $search);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $id = $search->getNomVern()->getId();
            $em = $this->getDoctrine()->getManager();
            $bird = $em->getRepository('OCPlatformBundle:Taxref')->findOneBy(array('id' => $id));
            $observs = $em->getRepository('OCPlatformBundle:Observation')->getObservsValidated($id);
            $observsToValid = $em->getRepository('OCPlatformBundle:Observation')->getObservsToValid($id);

            if ($this->get('security.authorization_checker')->isGranted('ROLE_NATURALIST')) {
                return $this->render('OCPlatformBundle:Default:consult.html.twig', array(
                    'form' => $form->createView(),
                    'bird' => $bird,
                    'observs' => $observs,
                    'observsToValid' => $observsToValid
                ));
            } else {
                $coords = array();
                foreach ($observs as $observ) {
                    $obsId = $observ->getId();
                    $coordinates = $em->getRepository('OCPlatformBundle:Observation')->getLocations($obsId);
                    $lat = $coordinates[0]['latitude'] + 0.05;
                    $lng = $coordinates[0]['longitude'] + 0.05;
                    array_push($coords, [$lat, $lng]);
                }
                return $this->render('OCPlatformBundle:Default:consult.html.twig', array(
                    'form' => $form->createView(),
                    'bird' => $bird,
                    'observs' => $observs,
                    'observsToValid' => $observsToValid,
                    'coords' => $coords
                ));
            }
        }

    	return $this->render('OCPlatformBundle:Default:consult.html.twig', array(
    		'form' => $form->createView(),
    	));
    }

    /**
     * @Route("/consult/{id}", name="oc_platform_single_consult")
     */
    public function consultSingleAction($id)
    {
    	$em = $this->getDoctrine()->getManager();

    	$observation = $em->getRepository('OCPlatformBundle:Observation')->find($id);

        if ($this->get('security.authorization_checker')->isGranted('ROLE_NATURALIST')) {
            return $this->render('OCPlatformBundle:Default:singleObserv.html.twig', array(
                'observation' => $observation
            ));
        } else {
            $coordinates = $em->getRepository('OCPlatformBundle:Observation')->getLocations($id);
            $lat = $coordinates[0]['latitude'] + 0.05;
            $lng = $coordinates[0]['longitude'] + 0.05;
            $coords = [$lat, $lng];

            return $this->render('OCPlatformBundle:Default:singleObserv.html.twig', array(
                'observation' => $observation,
                'coords' => $coords
            ));
        }
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
    		if ($picture !== null) {
    			$picture->setAlt($observation->getTaxref()->getNomVern());
    			$em->persist($picture);
    		}

    		if ($this->get('security.authorization_checker')->isGranted('ROLE_NATURALIST')) {

    			$observation->setValidated(true);
    			$em->flush();
    			$request->getSession()->getFlashBag()->add('info', 'Votre observation a bien été enregistrée.');

    		} else {
    			$observation->setValidated(false);
    			$em->flush();
    			$request->getSession()->getFlashBag()->add('info', 'Votre observation a bien été enregistrée mais doit être validée par un naturaliste.');
    		}

    		$observation = new Observation();
    		$form = $this->get('form.factory')->create(ObservationType::class , $observation);

    		return $this->render('OCPlatformBundle:Default:observ.html.twig', array(
    			'form' => $form->createView()
    		));
    	}

    	return $this->render('OCPlatformBundle:Default:observ.html.twig', array(
    		'form' => $form->createView()
    	));
    }

    /**
     * @Route("/observation/valid/{id}", name="oc_platform_observValidation")
     */
    public function validObservAction(Request $request, Observation $observation, $id)
    {
    	$em = $this->getDoctrine()->getManager();

    	$observation->setValidated(true);
    	$em->flush();

    	$request->getSession()->getFlashBag()->add('info', 'L\'observation a bien été validée.');

    	return $this->redirectToRoute('oc_platform_single_consult', array('id' => $id));

    }

    /**
     * @Route("/observation/suppr/{id}", name="oc_platform_observSuppression")
     */
    public function supprObservAction(Request $request, Observation $observation, $id)
    {
    	$em = $this->getDoctrine()->getManager();

    	$em->remove($observation);
    	$em->flush();

    	$request->getSession()->getFlashBag()->add('info', 'L\'observation a bien été suprimée.');

    	return $this->redirectToRoute('oc_platform_homepage');

    }

	/**
     * @Route("/actualites", name="oc_platform_blog")
     */
	public function blogAction(Request $request)
	{

		$search = new Search();
		$form   = $this->get('form.factory')->create(SearchType::class, $search);

		$em = $this->getDoctrine()->getManager();

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

			$content = $search->getContent();

			$articles = $em->getRepository('OCPlatformBundle:Article')->complexFind($content);

			$search = new Search();
			$form   = $this->get('form.factory')->create(SearchType::class, $search);

		} 
		else {
			$articles = $em->getRepository('OCPlatformBundle:Article')->classicFind();
		}

		return $this->render('OCPlatformBundle:Default:blog.html.twig', array(
			'articles' => $articles,
			'form' => $form->createView(),
		));
	}

	/**
     * @Route("/actualites/creation", name="oc_platform_creation")
     */
	public function creationAction(Request $request)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

			$article = new Article();
			$form   = $this->get('form.factory')->create(ArticleType::class, $article);

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

				$em = $this->getDoctrine()->getManager();
				$article->setUser( $this->getUser());
				$em->persist($article);
				
				$articlePicture = $article->getArticlePicture();
				if ($articlePicture !== null)
				{
					$articlePicture->setAlt($article->getTitle());
					$articlePicture->setArticle($article);
					$articlePicture->setRandom(rand());
					$em->persist($articlePicture);
				}
				
				$em->flush();

				$request->getSession()->getFlashBag()->add('info', 'Votre article a bien été enregistrée.');

				$article = new Article();
				$form   = $this->get('form.factory')->create(ArticleType::class, $article);

			}

			return $this->render('OCPlatformBundle:Default:creation.html.twig', array(
				'form' => $form->createView(),
			));
		}

		return $this->redirectToRoute('oc_platform_homepage');
	}

	/**
     * @Route("/actualites/edition/{id}", name="oc_platform_edition")
     */
	public function editionAction(Request $request, Article $article, $id)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

			$form   = $this->get('form.factory')->create(ArticleType::class, $article);

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

				
				$em = $this->getDoctrine()->getManager();
				$articlePicture = $article->getArticlePicture();

				if ($articlePicture !== null)
				{
					$articlePicture->setRandom(rand());
					$articlePicture->setAlt($article->getTitle());
					$articlePicture->setArticle($article);
					$em->persist($articlePicture);
				}

				$em->flush();

				$request->getSession()->getFlashBag()->add('info', 'Votre article a bien été enregistrée.');

			}

			return $this->render('OCPlatformBundle:Default:edition.html.twig', array(
				'form' => $form->createView(),
				'article' => $article
			));
		}
		return $this->redirectToRoute('oc_platform_homepage');
	}

	/**
     * @Route("/actualites/article/{id}", name="oc_platform_article")
     */
	public function articleAction(Request $request, Article $article, $id)
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
     * @Route("/actualites/comment/{id}", name="oc_platform_signalComment")
     */
	public function signalCommentAction(Request $request, Comment $comment, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$comment->setWarning(true);
		$em->flush();

		$request->getSession()->getFlashBag()->add('info', 'Le commentaire a été signalé.');

		return $this->redirectToRoute('oc_platform_article', array('id' => $comment->getArticle()->getId()));

	}

	/**
     * @Route("/actualites/suppression/{id}", name="oc_platform_suppression")
     */
	public function suppressionAction(Request $request, Article $article, $id)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			
			$em = $this->getDoctrine()->getManager();

			$em->remove($article);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', "L'article a bien été supprimer");

			return $this->redirectToRoute('fos_user_profile_show');
		}
		return $this->redirectToRoute('oc_platform_homepage');

	}

	/**
     * @Route("/actualites/commentValidation/{id}", name="oc_platform_commentValidation")
     */
	public function commentValidationAction(Request $request, Comment $comment, $id)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			
			$em = $this->getDoctrine()->getManager();

			$comment->setWarning(false);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', "Le commentaire a bien été validé");

			return $this->redirectToRoute('fos_user_profile_show');
		}

		return $this->redirectToRoute('oc_platform_homepage');

	}

	/**
     * @Route("/actualites/commentSuppression/{id}", name="oc_platform_commentSuppression")
     */
	public function commentSuppressionAction(Request $request, Comment $comment, $id)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			
			$em = $this->getDoctrine()->getManager();

			$em->remove($comment);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', "Le commentaire a bien été supprimé");

			return $this->redirectToRoute('fos_user_profile_show');
		}

		return $this->redirectToRoute('oc_platform_homepage');

	}

	/**
     * @Route("/actualites/pictureSuppression/{id}/{articleId}", name="oc_platform_pictureSuppression")
     */
	public function pictureSuppressionAction(Request $request, ArticlePicture $articlePicture, $id, $articleId)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			
			$em = $this->getDoctrine()->getManager();

			$em->remove($articlePicture);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', "L'image à été supprimé");

			return $this->redirectToRoute('oc_platform_edition',  array('id' => $articleId));
		}

		return $this->redirectToRoute('oc_platform_homepage');

	}

	/**
     * @Route("/Qui-sommes-nous", name="oc_platform_qsn")
     */
	public function qsnAction()
	{
		return $this->render('OCPlatformBundle:Default:qsn.html.twig');
	}

    /**
     * @Route("/contact", name="oc_platform_contact")
     */
    public function contactAction(Request $request)
    {
        $form = $this->get('form.factory')->create(ContactType::class);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $post = $request->request->get('oc_platformbundle_contact_form');
            $message = new Swift_Message();
            $message->setSubject('Nouveau message pour "Nos amis les oiseaux"')
            ->setFrom(array('fabrice.loubier@gmail.com' => 'nao.fr'))
                ->setTo('ocr@loubier.fr')
                ->setContentType('text/html')
                ->setCharset('utf-8')
                ->setBody(
                    $this->renderView('OCPlatformBundle:Default:email.html.twig',
                        array('post' => $post)));
            $this->get('mailer')->send($message);

            $form = $this->get('form.factory')->create(ContactType::class);

            $request->getSession()->getFlashBag()->add('info', 'Votre message a bien été envoyé.');
            return $this->render('OCPlatformBundle:Default:contact.html.twig', array(
                'form' => $form->createView(),
            ));
        }

        return $this->render('OCPlatformBundle:Default:contact.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}
