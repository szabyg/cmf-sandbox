<?php

namespace Liip\HackdayBundle\Helper;

use PHPCR\SessionInterface;

class PhpcrWalker
{
    /**
     * return an array of all child nodes of the node at path
     * key are names and values the doctrine models for those nodes
     */
    public static function getChildList($dm, SessionInterface $session, $path) {
        $phpcrnode = $session->getNode($path);
        $children = array();
        foreach($phpcrnode as $child) {
            $name = $child->getName();
            $children[$path . '/' . $name] = $dm->getRepository('Liip\HackdayBundle\Document\Page')->find("$path/$name");
        }

        return $children;
    }
}