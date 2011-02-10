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
        $page = $this->dm->getRepository('Liip\HackdayBundle\Document\Page')->find('/'.$path);

        if ($page === null) {
            // TODO: this is not a nice way to display errors...
            return new \Symfony\Component\HttpFoundation\Response("Page not found '/$path'");
        }

        $node = $this->jackalope->getSession()->getNode($path);
        $data = array(
            'path' => $path,
            'doctrine_node' => $page,
        );

        return $this->render('HackdayBundle:Default:index.html.twig', array('data'=>$data));
    }

    /**
     * render the document identified by path
     */
    public function contentAction($data)
    {
        return $this->render('HackdayBundle:Default:document.html.twig', array('data'=>$data));
    }

    /**
     * render a list of children of the node identified by path
     */
    public function childlistAction($data)
    {
        $children = \Liip\HackdayBundle\Helper\PhpcrWalker::getChildList($this->dm, $this->jackalope->getSession(), $data['path']);
        return $this->render('HackdayBundle:Default:childlist.html.twig', array('path'=>$data['path'], 'children'=>$children));
    }
}
