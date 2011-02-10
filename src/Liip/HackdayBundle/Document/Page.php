<?php

namespace Liip\HackdayBundle\Document;

/**
 * @phpcr:Document(alias="page")
 */
class Page
{
    /**
     * @validator:NotBlank()
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
