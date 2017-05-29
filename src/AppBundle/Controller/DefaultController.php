<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/page", name="hotel-listing")
     */
    public function pageAction(Request $request)
    {
        return $this->render('default/hotel-listing.html.twig');
    }

    /**
     * @Route("/pelling", name="pelling-hotel")
     */
    public function hotel1Action(Request $request)
    {
        return $this->render(':default:pelling-hotel.html.twig');
    }

    /**
     * @Route("/lachung", name="lachung-hotel")
     */
    public function hotel2Action(Request $request)
    {
        return $this->render(':default:lachung-hotel.html.twig');
    }

    /**
     * @Route("/namchi", name="namchi-hotel")
     */
    public function hotel3Action(Request $request)
    {
        return $this->render(':default:namchi-hotel.html.twig');
    }


}
