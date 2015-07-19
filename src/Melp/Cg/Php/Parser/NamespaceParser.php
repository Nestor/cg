<?php

namespace Melp\Cg\Php\Parser;

use Melp\Cg\Common\ParserException;
use Melp\Cg\Php\Node;
use Melp\Cg\Common\ScannerInterface;

class NamespaceParser extends Parser
{
    public function __construct()
    {
        parent::__construct();

        $this->parsers[]= new UseParser();
        $this->parsers[]= new DocCommentParser();
        $this->parsers[]= new ClassParser();
        $this->parsers[]= new FunctionParser();
        $this->parsers[]= new CommentParser();
        $this->parsers[]= new ConstParser();

        // This is a hack to pick up any slack the above parsers did not pick up
        // It is line based and is only here to pick up on some cases such as require_once statements
        // or trigger_error calls.
        $this->parsers[]= new SlackParser();
    }


    public function match(ScannerInterface $scanner)
    {
        return $scanner->match('namespace ');
    }


    public function parse(ScannerInterface $scanner)
    {
        $node = new Node\Namespacex();

        $scanner->expect('namespace ');
        $scanner->skip();

        $node['name'] = $scanner->expectr(self::FQCN)[0];

        if ($scanner->match(';', true)) {
            $node['single'] = true;
        }

        $this->subparse($scanner, $node);

        return $node;
    }
}