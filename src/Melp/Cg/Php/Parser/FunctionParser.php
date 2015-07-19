<?php

namespace Melp\Cg\Php\Parser;

use Melp\Cg\Common\Node\Raw;
use Melp\Cg\Common\NodeInterface;
use Melp\Cg\Common\ScannerInterface;
use Melp\Cg\Php\Node\Arg;
use Melp\Cg\Php\Node\Functionx;
use Melp\Cg\Php\Node\Method;
use Melp\Cg\Php\Node\Property;

class FunctionParser extends Parser
{
    private $pattern = '#function\s+#A';

    public function match(ScannerInterface $scanner)
    {
        return $scanner->matchr($this->pattern);
    }

    public function parse(ScannerInterface $scanner)
    {
        $scanner->expectr($this->pattern);
        $node = $this->parseFunc($scanner, new Functionx());
        return $node;
    }


    /**
     * @param ScannerInterface $scanner
     * @param $node
     * @return mixed
     */
    protected function parseFunc(ScannerInterface $scanner, NodeInterface $node)
    {
        if ($scanner->match('&', true)) {
            $node['byref'] = true;
        }
        $node['name'] = $scanner->expectr(Parser::NAME, true)[0];
        $scanner->skip();
        $scanner->expect('(');
        $scanner->skip();
        while (!$scanner->match(')', true)) {
            $arg = new Arg();
            if ($typehint = $scanner->matchr(self::TYPENAME, true)[0]) {
                $arg['typehint']= $typehint;
            }
            $scanner->skip();
            if ($scanner->match('&', true)) {
                $arg['byref'] = true;
            }
            $arg['name']= $scanner->expectr(self::VARNAME)[1];
            $scanner->skip();

            if ($scanner->match('=', true)) {
                $scanner->skip();
                $arg['default'] = $scanner->scanUntil(array(',', ')'), '(');
            }
            $node->appendChild($arg);
            $scanner->skip();
            if ($scanner->match(',', true)) {
                $scanner->skip();
                continue;
            }
        }
        $scanner->skip();
        if ($scanner->match(';', true)) {
            $node['abstract'] = true;
        } else {
            $scanner->expect('{');
            $node->appendChild(new Raw($scanner->block(), true));
            $scanner->expect('}');
        }
        return $node;
    }
}