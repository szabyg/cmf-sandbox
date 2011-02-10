<?php

namespace Liip\HackdayBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        if ($this->jackalope->getSession()->itemExists('/' . $path) === false) {
            throw new NotFoundHttpException("Page not found '/$path'");
        }

        return $this->render('HackdayBundle:Default:index.html.twig', array('path'=>$path));
    }

    /**
     * render the document identified by path
     */
    public function contentAction($path)
    {
        $node = $this->dm->getRepository('Liip\HackdayBundle\Document\Page')->find('/'.$path);
        return $this->render('HackdayBundle:Default:document.html.twig', array('path' => $path, 'node'=>$node));
    }

    /**
     * render a list of children of the node identified by path
     */
    public function childlistAction($path)
    {
        $children = \Liip\HackdayBundle\Helper\PhpcrWalker::getChildList($this->dm, $this->jackalope->getSession(), $path);
        return $this->render('HackdayBundle:Default:childlist.html.twig', array('path'=>$path, 'children'=>$children));
    }
}
