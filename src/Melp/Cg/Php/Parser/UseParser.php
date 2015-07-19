<?php

namespace Melp\Cg\Php\Parser;

use Melp\Cg\Common\ParserException;
use Melp\Cg\Php\Node;
use Melp\Cg\Common\ScannerInterface;

class UseParser extends Parser
{
    public function match(ScannerInterface $scanner)
    {
        return $scanner->match('use ');
    }


    public function parse(ScannerInterface $scanner)
    {
        $node = new Node\Usex();

        $scanner->expect('use ');
        $scanner->skip();
        $node['name'] = $scanner->matchr(self::FQCN, true)[0];

        $scanner->skip();
        if ($scanner->match('as', true)) {
            $scanner->skip();
            $node['as'] = $scanner->expectr(self::NAME, true)[0];
        }
        if (!$scanner->match(';', true)) {
            throw new ParserException($scanner, "Expanded use statements are not yet supported");
        }
        return $node;
    }
}