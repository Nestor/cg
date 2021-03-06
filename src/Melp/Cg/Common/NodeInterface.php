<?php

namespace Melp\Cg\Common;

interface NodeInterface extends \Countable
{
    public function write(BufferInterface $buffer);
    public function appendChild(NodeInterface $node);
}