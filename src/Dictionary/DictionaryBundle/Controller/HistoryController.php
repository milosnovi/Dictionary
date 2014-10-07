<?php

namespace Dictionary\DictionaryBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HistoryController extends Controller
{
	/**
	 * @param Request $request
	 * @return array
	 *
	 * @Route("/history/clear", name="clear_history")
	 * @Template()
	 */
    public function clearHistoryAction(Request $request)
    {

    }

}
