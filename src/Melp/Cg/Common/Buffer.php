<?php

namespace Melp\Cg\Common;

class Buffer implements BufferInterface
{
    private $buffer = '';
    private $indentSize = 0;
    private $indentChar = "    ";

    public function append($str)
    {
        if ($str instanceof NodeInterface) {
            $str->write($this);
        } else {
            for ($i = 0; $i < strlen($str); $i ++) {
                if ($this->indentSize) {
                    if ($this->isEol()) {
                        $this->buffer .= str_repeat($this->indentChar, $this->indentSize);
                    }
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

    public function indent($num = 1)
    {
        $this->indentSize += $num;
        return $this;
    }

    public function outdent($num = 1)
    {
        $this->indentSize -= $num;
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