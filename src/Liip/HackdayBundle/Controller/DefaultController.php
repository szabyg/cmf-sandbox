<?php

namespace Liip\HackdayBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Liip\HackdayBundle\Helper\PhpcrWalker;

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

    /**
     * this is a bit hacky: we cache the page but if this service is used for more than one node, this messes up major
     * however, the repository has a bug that prevents the root not from being instantiated more than once
     */
    protected $page;

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

        $this->page = $this->dm->getRepository('Liip\HackdayBundle\Document\Page')->find('/'.$path);

        return $this->render('HackdayBundle:Default:index.html.twig', array('path'=>$path));
    }

    /**
     * render the document identified by path
     */
    public function contentAction($path)
    {
        //$node = $this->dm->getRepository('Liip\HackdayBundle\Document\Page')->find('/'.$path);
        return $this->render('HackdayBundle:Default:document.html.twig', array('path' => $path, 'node'=>$this->page));
    }

    /**
     * render a list of children of the node identified by path
     */
    public function childlistAction($path)
    {
        $children = PhpcrWalker::getChildList($this->dm, $this->jackalope->getSession(), $path);
        return $this->render('HackdayBundle:Default:childlist.html.twig', array('path'=>$path, 'children'=>$children));
    }

    /**
     * render a breadcrumb to the node identified by path
     */
    public function breadcrumbAction($path)
    {
        $parents = PhpcrWalker::getParents($this->dm, $this->jackalope->getSession(), $path, $this->page);
        return $this->render('HackdayBundle:Default:breadcrumb.html.twig', array('path'=>$path, 'parents'=>$parents));
    }


}
