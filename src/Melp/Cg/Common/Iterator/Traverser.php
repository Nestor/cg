<?php

namespace Melp\Cg\Common\Iterator;

use Melp\Cg\Common\NodeInterface;
use Melp\Cg\Common\VisitorInterface;

class Traverser
{
    /**
     * @var NodeInterface
     */
    protected $root;

    /**
     * @var VisitorInterface[]
     */
    protected $visitors = [];


    public function __construct(\Melp\Cg\Common\NodeInterface $root)
    {
        $this->root = $root;
    }


    public function addVisitor(VisitorInterface $visitor)
    {
        $this->visitors[]= $visitor;

        return $this;
    }


    public function traverse()
    {
        foreach (new \RecursiveIteratorIterator(new NodeIterator(array($this->root)), \RecursiveIteratorIterator::SELF_FIRST) as $node) {
            foreach ($this->visitors as $visitor) {
                $visitor->visit($node);
            }
        }

        return $this->root;
    }
}