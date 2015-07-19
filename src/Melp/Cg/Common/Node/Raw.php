<?php

namespace Melp\Cg\Common\Node;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\Node;

class Raw extends Node
{
    public function __construct($code = '', $ignoreIndent = false)
    {
        parent::__construct();

        $this['code']= $code;
        $this['ignoreIndent'] = $ignoreIndent;
    }

    public function write(BufferInterface $buffer)
    {
        if ($this['ignoreIndent']) {
            $buffer->disableIndent();
        }
        $buffer->append($this['code']);
        if ($this['ignoreIndent']) {
            $buffer->enableIndent();
        }
    }
}