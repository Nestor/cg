<?php

namespace Melp\Cg\Common;

use Melp\Cg\Common\Node\Raw;

class Scanner implements ScannerInterface
{
    public function __construct($data = '')
    {
        $this->offset = 0;
        $this->data = $data;
    }


    public function skip()
    {
        $start = $this->offset;
        while (ctype_space($this->data[$this->offset])) {
            $this->offset ++;
            if ($this->eof()) {
                break;
            }
        }
        return [$start, $this->offset];
    }


    private function validate()
    {
        if ($this->offset >= strlen($this->data)) {
            return false;
        }
        return true;
    }


    public function eof()
    {
        return $this->offset >= strlen($this->data);
    }

    public function match($pattern, $advance = false)
    {
        return $this->matchr('#' . preg_quote($pattern, '#') . '#A', $advance);
    }

    public function matchr($pattern, $advance = false)
    {
        if (preg_match($pattern, $this->data, $m, 0, $this->offset)) {
            if ($advance) {
                $this->offset += strlen($m[0]);
            }
            return $m;
        }
        return false;
    }

    /**
     * @param string $str
     * @return self
     */
    public function expect($str)
    {
        if (!($m = $this->match($str, true))) {
            throw new ParserException($this, "Unexpected data, expected {$str}");
        }
        return $m;
    }
    /**
     * @param string $str
     * @return self
     */
    public function expectr($regex)
    {
        if (!($m = $this->matchr($regex, true))) {
            throw new ParserException($this, "Unexpected data, expected data matching {$regex}");
        }
        return $m;
    }

    public function pos()
    {
        return $this->offset;
    }

    public function debugInfo($message)
    {
        $lines = explode("\n", $this->data);
        list($line, $column) = $this->line();

        $data = '';
        for ($i = max(0, $line -1); $i <= min($line +1, count($lines) -1); $i ++) {
            $data .= sprintf("% 3d. %s\n", $i +1, rtrim($lines[$i]));
            if ($i == $line) {
                $data .= '    ' . str_repeat(' ', $column) . '^--------- ' . $message . "\n";
            }
        }
        return $data;
    }

    private function line()
    {
        $line = 0;
        $column = 0;
        for ($i = $this->offset; $i >= 0; $i --) {
            if ($this->data[$i] === "\n") {
                $line ++;
            } elseif ($line === 0) {
                $column ++;
            }
        }

        return array($line, $column);
    }


    public function scanUntil(array $list)
    {
        $stack = array();
        $start = $this->offset;
        while (!in_array($this->data[$this->offset], $list)) {
            $this->offset ++;
        }
        return substr($this->data, $start, $this->offset - $start);
    }

    public function block()
    {
        $type = $this->data[$this->offset -1];
        $this->skip();
        list(,$indent) = $this->line();
        switch ($type) {
            case '{':
                $paren = '}';
                break;
            case '(':
                $paren = ')';
                break;
            case '[':
                $paren = ']';
                break;
            default:
                throw new ScannerException($this, "Unknown paren type {$type}");
        }
        $start = $this->offset;
        $depth = 0;
        do {
            if ($this->data[$this->offset] === $type) {
                $depth ++;
            }
            if ($this->data[$this->offset] === $paren) {
                if (0 === $depth) {
                    break;
                }
                $depth --;
            }
            if (!$this->validate()) {
                $this->offset = $start;
                throw new ParserException($this, "could not find paren for '$type'");
            }
            $this->offset ++;
        } while (true);
        return rtrim(preg_replace('/^ {' . $indent . '}/m', '', substr($this->data, $start, $this->offset - $start)));
    }
}