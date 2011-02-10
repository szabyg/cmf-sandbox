<?php

namespace Liip\HackdayBundle\Controller;

use Liip\HackdayBundle\Document\Page;
use Liip\HackdayBundle\Admin\PageForm;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\DataError;
use Symfony\Component\Form\PropertyPath;

use Jackalope\Transport\Davex\HTTPErrorException;

class AdminController extends Controller
{
    /**
     * @var \Bundle\DoctrinePHPCRBundle\JackalopeLoader
     */
    protected $jackalope = null;

    /**
     * @var \Jackalope\Session
     */
    protected $jackalopeSession = null;

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

    public function indexAction()
    {
        return $this->render('HackdayBundle:Admin:index.html.twig');
    }

    public function createAction()
    {
        $page = new Page();
        $form = PageForm::create($this->get('form.context'), 'page');

        // If a POST request, write submitted data into $page
        // and validate it
        $form->bind($this->get('request'), $page);

        // If the form has been submitted and validates...
        if ($form->isValid()) {

            try {
                $this->dm->persist($page, $page->name);
                $this->dm->flush();

                $session = $this->get('request')->getSession();
                $session->setFlash('notice', 'Page created!');

                return $this->redirect($this->generateUrl('admin'));

            } catch (HTTPErrorException $e) {
                
                $path = new PropertyPath('name');
                $form->addError(new DataError('Name already in use.'), $path->getIterator());

            }
        }

        // Display the form
        return $this->render('HackdayBundle:Admin:create.html.twig', array('form' => $form));
    }
}
