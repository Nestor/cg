<?php

namespace Melp\Cg\Php\Parser;

use Melp\Cg\Common\Node\Raw;
use Melp\Cg\Common\ScannerInterface;

class SlackParser extends Parser
{
    public function match(ScannerInterface $scanner)
    {
        // any slack can be picked up here.
        return !$scanner->eof();
    }


    public function parse(ScannerInterface $scanner)
    {
        return new Raw("\n" . $scanner->expectr('/.*/mA')[0] . "\n");
    }
}