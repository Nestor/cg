<?php

namespace Melp\Cg\Php\Parser;

use Melp\Cg\Common\ParserException;
use Melp\Cg\Php\Node;
use Melp\Cg\Common\ScannerInterface;

class FileParser extends NamespaceParser
{
    public function __construct()
    {
        parent::__construct();

        $this->parsers[]= new NamespaceParser();
    }


    public function match(ScannerInterface $scanner)
    {
        return $scanner->match('<?php');
    }


    public function parse(ScannerInterface $scanner)
    {
        $node = new Node\File();
        $scanner->expect('<?php');
        $scanner->skip();

        $this->subparse($scanner, $node);

        return $node;
    }
}