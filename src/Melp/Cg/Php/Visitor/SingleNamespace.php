<?php

namespace Melp\Cg\Php\Visitor;

use Melp\Cg\Common\NodeInterface;
use Melp\Cg\Common\VisitorInterface;
use Melp\Cg\Php\Node\File;
use Melp\Cg\Php\Node\Namespacex;

/**
 * Marks a namespace 'single' if it is the only namespace declaration in a file.
 */
class SingleNamespace implements VisitorInterface
{
    public function visit(NodeInterface $n)
    {
        if ($n instanceof File) {
            $namespaces = array();
            foreach ($n->childNodes as $child) {
                if ($child instanceof Namespacex) {
                    $namespaces[]= $child;
                }
            }
            if (1 === count($namespaces)) {
                $namespaces[0]['single'] = true;
            }
        }
    }
}