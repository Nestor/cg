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
        $node['name'] = $scanner->expectr(Parser::NAME, true)[0];
        $scanner->skip();
        $scanner->expect('(');
        $scanner->skip();
        while (!$scanner->match(')', true)) {
            $arg = new Arg($scanner->expectr(Parser::VARNAME)[1]);
            $scanner->skip();

            if ($scanner->match('=', true)) {
                $arg['default'] = $scanner->scanUntil(array(',', ')'));
            }
            $node->appendChild($arg);
            $scanner->skip();
            if ($scanner->match(',', true)) {
                $scanner->skip();
                continue;
            }
        }
        $scanner->skip();
        $scanner->expect('{');
        $node->appendChild(new Raw($scanner->block()));
        $scanner->expect('}');
        return $node;
    }
}