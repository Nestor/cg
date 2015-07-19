<?php


namespace Melp\Cg\Common;


interface VisitorInterface
{
    public function visit(NodeInterface $node);
}