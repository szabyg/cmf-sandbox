<?php

namespace Liip\HackdayBundle\Document;

/**
 * @phpcr:Document(alias="page")
 */
class Page
{
    /**
     * @validation:NotBlank
     * @phpcr:String()
     */
    public $name;

    /**
     * @validation:NotBlank
     * @phpcr:String()
     */
    public $title;

    /**
     * @phpcr:String()
     */
    public $content;

}
