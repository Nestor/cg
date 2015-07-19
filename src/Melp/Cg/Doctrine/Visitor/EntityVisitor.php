<?php

namespace Melp\Cg\Doctrine\Visitor;

use Melp\Cg\Common\Node\Raw;
use Melp\Cg\Common\NodeInterface;
use Melp\Cg\Doctrine\Node\Entity;
use Melp\Cg\Php\Node\DocComment;
use Melp\Cg\Php\Node\Namespacex;

class EntityVisitor implements \Melp\Cg\Common\VisitorInterface
{
    public function visit(NodeInterface $node)
    {
        if ($node instanceof Namespacex) {
            for ($i = count($node->childNodes) -1; $i >= 0; $i --) {
                if ($node->childNodes[$i] instanceof Entity) {
                    if ($node->childNodes[$i -1] instanceof DocComment) {
                        trigger_error('Not implemented yet: changing existing doccomments');
                    } else {
                        $docComment = new DocComment();
                        $docComment->appendChild(new Raw("@ORM\\Entity\n"));
                        array_splice($node->childNodes, $i, 0, array($docComment));
                    }
                }
            }
        }
    }
}