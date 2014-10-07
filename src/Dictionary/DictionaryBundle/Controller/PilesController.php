<?php

namespace Dictionary\DictionaryBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PilesController extends Controller
{
	/**
	 * @param Request $request
	 * @return array
	 *
	 * @Route("/pile", name="move_2_piles")
	 * @Template()
	 */
    public function move2pilesAction(Request $request)
    {

    }

}
