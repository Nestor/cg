<?php

namespace Melp\Cg\Common;

class Buffer implements BufferInterface
{
    private $buffer = '';
    private $indent = array();

    public function append($str)
    {
        if ($str instanceof NodeInterface) {
            $str->write($this);
        } else {
            for ($i = 0; $i < strlen($str); $i ++) {
                if (count($this->indent) && $this->isEol()) {
                    $this->buffer .= join('', $this->indent);
                }
                $this->buffer .= $str{$i};
            }
        }
        return $this;
    }

    public function appendl($str = '')
    {
        return $this->append($str . PHP_EOL);
    }

    public function nl()
    {
        if (!$this->isEol()) {
            $this->appendl();
        }
        return $this;
    }

    public function indent($str = '    ')
    {
        $this->indent[]= $str;
        return $this;
    }

    public function outdent()
    {
        array_pop($this->indent);
        return $this;
    }


    public function __toString()
    {
        return $this->buffer;
    }

    /**
     * @return bool
     */
    protected function isEol()
    {
        return $this->buffer[strlen($this->buffer) - 1] === "\n";
    }
}