<?php

namespace Liip\HackdayBundle\Admin;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Symfony\Component\Form\EmailField;
use Symfony\Component\Form\CheckboxField;

class PageForm extends Form
{
    protected function configure()
    {
        $this->add(new TextField('title', array(
            'max_length' => 100,
        )));
        $this->add(new TextareaField('content'));
    }
}
