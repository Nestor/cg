<?php

namespace Melp\Cg\Common\Iterator;

use Melp\Cg\Common\NodeInterface;
use Melp\Cg\Common\VisitorInterface;

class Traverser
{
    /**
     * @var VisitorInterface[]
     */
    protected $visitors = [];


    public function __construct()
    {
    }


    public function addVisitor(VisitorInterface $visitor)
    {
        $this->visitors[]= $visitor;

        return $this;
    }


    public function traverse(\Melp\Cg\Common\NodeInterface $root)
    {
        foreach (new \RecursiveIteratorIterator(new NodeIterator(array($root)), \RecursiveIteratorIterator::SELF_FIRST) as $node) {
            foreach ($this->visitors as $visitor) {
                $visitor->visit($node);
            }
        }

        return $root;
    }
}