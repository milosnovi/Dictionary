<?php

namespace Dictionary\DictionaryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

	/**
	 * @Route("/", name="_home")
	 * @Template("DictionaryBundle:Default:home.html.twig")
	 */
	public function indexAction()
	{
		return [];
	}

}
