<?php

namespace Melp\Cg\Php;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\Node;

class Raw extends Node
{
    public function __construct($code = '')
    {
        parent::__construct();
        $this['code']= $code;
    }

    public function write(BufferInterface $buffer)
    {
        $buffer->append($this['code']);
    }
}