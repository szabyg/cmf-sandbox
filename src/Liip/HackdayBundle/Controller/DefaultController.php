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
        $node = $this->jackalope->getSession()->getNode($path);
        $props = $node->getPropertiesValues();
        $page = $this->dm->getRepository('Liip\HackdayBundle\Document\Page')->find('/'.$path);
        $props_for_twig = array(
            'primaryType' => $props['jcr:primaryType'],
            '_doctrine_alias' => $props['_doctrine_alias'],
        );
        return $this->render('HackdayBundle:Default:document.html.twig', array('path'=>$path, 'page' => $page, 'props' => $props_for_twig));
    }

    /**
     * render a list of children of the node identified by path
     */
    public function childlistAction($path)
    {
        //$article = $this->dm->getRepository('Liip\HackdayBundle\Document\Page')->find('/'.$path);
        $phpcrnode = $this->jackalope->getSession()->getNode($path);
        $children = array();
        foreach($phpcrnode as $child) {
            $children[] = $child->getName();
        }
        return $this->render('HackdayBundle:Default:childlist.html.twig', array('children'=>$children));
    }
}
