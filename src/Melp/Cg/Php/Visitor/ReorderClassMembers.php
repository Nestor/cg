<?php

namespace Melp\Cg\Php\Visitor;

use Melp\Cg\Common\NodeInterface;
use Melp\Cg\Common\VisitorInterface;
use Melp\Cg\Php\Node\Classx;

/**
 * Reorders the members of a class
 */
class ReorderClassMembers implements VisitorInterface
{
    public function visit(NodeInterface $node)
    {
        if ($node instanceof Classx) {
            // TODO
        }
    }
}