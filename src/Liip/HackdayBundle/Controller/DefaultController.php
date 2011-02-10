<?php

namespace Liip\HackdayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @var \Bundle\DoctrinePHPCRBundle\JackalopeLoader
     */
    protected $jackalope = null;

    /**
     * @var \Doctrine\ODM\PHPCR\DocumentManager
     */
    protected $dm = null;

    public function __construct($container, $jackalope, $dm)
    {
        $this->setContainer($container);
        $this->jackalope = $jackalope;
        $this->dm = $dm;
    }

    public function indexAction($path)
    {
        return $this->render('HackdayBundle:Default:index.html.twig', array('path'=>$path));
    }

    /**
     * render the document identified by path
     */
    public function contentAction($path)
    {
        return $this->render('HackdayBundle:Default:document.html.twig', array('path'=>$path));
    }

    /**
     * render a list of children of the node identified by path
     */
    public function childlistAction($path)
    {
        return $this->render('HackdayBundle:Default:childlist.html.twig', array('path'=>$path));
    }
}
