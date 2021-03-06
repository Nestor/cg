<?php

namespace Melp\Cg\Php\Node;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\Node;
use Melp\Cg\Common\Node\Raw;

class DocComment extends Node
{
    public function write(BufferInterface $buffer)
    {
        if (count($this->childNodes) === 1 && $this->childNodes[0] instanceof Raw && $this->childNodes[0]['ignoreIndent']) {
            $buffer->append('/**')->append($this->childNodes[0])->appendl('*/');
        } else {
            $buffer
                ->appendl('/**')
                ->indent(' * ');
            foreach ($this->attributes as $key => $value) {
                if (!is_array($value)) {
                    $value = array($value);
                }

                foreach ($value as $v) {
                    $buffer->appendl('@' . $key . ' ' . $v);
                }
            }

            foreach ($this->childNodes as $child) {
                $buffer->append($child);
            }
            $buffer
                ->outdent()
                ->appendl(' */');
        }
    }
}