<?php

namespace Melp\Cg\Php\Parser;

use Melp\Cg\Common\Node\Raw;
use Melp\Cg\Common\ParserException;
use Melp\Cg\Php\Node;
use Melp\Cg\Common\ScannerInterface;

class DocCommentParser extends Parser
{
    public function match(ScannerInterface $scanner)
    {
        return $scanner->match('/**');
    }


    public function parse(ScannerInterface $scanner)
    {
        $node = new Node\DocComment();

        $scanner->expect('/**');
        if (!$scanner->matchr('#\s*?\n\s*\*#A')) {
            $node->appendChild(new Raw($scanner->scanUntil(['*/']), true));
        } else {
            $scanner->skip();
            while ($line = $scanner->matchr('#(?!\*/)\* ?((?:.*)?\n)#A', true)) {
                $node->appendChild(new Raw($line[1]));
                $scanner->skip();
            }
        }
        $scanner->expect('*/');
        return $node;
    }
}