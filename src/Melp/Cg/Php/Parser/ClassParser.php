<?php

namespace Melp\Cg\Php\Parser;

use Melp\Cg\Common\ParserException;
use Melp\Cg\Php\Node;
use Melp\Cg\Common\ScannerInterface;

class ClassParser extends Parser
{
    private $pattern = '#(?:(final|abstract) )?(class|interface|trait) #A';

    public function __construct()
    {
        parent::__construct();

        $this->parsers[]= new DocCommentParser();
        $this->parsers[]= new PropertyParser();
        $this->parsers[]= new MethodParser();
    }


    public function match(ScannerInterface $scanner)
    {
        return $scanner->matchr($this->pattern);
    }


    public function parse(ScannerInterface $scanner)
    {
        $node = new Node\Classx();

        $scanner->expectr($this->pattern);
        $scanner->skip();
        $node['name']= $scanner->expectr(self::NAME, true)[0];
        $scanner->skip();
        $scanner->expect('{', true);
        $this->subparse($scanner, $node);
        $scanner->expect('}', true);

        return $node;
    }
}