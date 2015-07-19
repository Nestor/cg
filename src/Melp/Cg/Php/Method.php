<?php

namespace Melp\Cg\Php;

use Melp\Cg\Common\BufferInterface;

class Method extends Functionx
{
    public function write(BufferInterface $buffer)
    {
        foreach ($this->attributes['attr'] as $name) {
            $buffer->append($name . ' ');
        }
        parent::write($buffer);
    }
}