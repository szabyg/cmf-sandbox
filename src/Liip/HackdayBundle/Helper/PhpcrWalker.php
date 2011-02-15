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
            $childPath = $name;
            if ($path) {
                $childPath = $path . '/' . $childPath;
            }
            $children[$childPath] = $dm->getRepository('Liip\HackdayBundle\Document\Page')->find("$path/$name");
        }

        return $children;
    }

    /**
     * return an array of all parent nodes, starting with root to the node at path, without that node itself
     * key are names and values the doctrine models for those nodes
     */
    public static function getParents($dm, SessionInterface $session, $path, $page = null) {
        $phpcrnode = $session->getNode($path);

        if ($phpcrnode->getDepth() < 1) {
            return array();
        }

        $parents = array();
        $i = 0; //start at first element
        while(($node = $phpcrnode->getAncestor($i++)) != $phpcrnode) {
            $name = $node->getName();
            $childPath = substr($node->getPath(), 1);
            $parents[$childPath] = $dm->getRepository('Liip\HackdayBundle\Document\Page')->find($node->getPath());
        }

        return $parents;
    }
}