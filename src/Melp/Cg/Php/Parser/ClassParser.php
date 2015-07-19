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

        $this->parsers[] = new UseParser();
        $this->parsers[] = new DocCommentParser();
        $this->parsers[] = new PropertyParser();
        $this->parsers[] = new MethodParser();
        $this->parsers[] = new ConstParser();
        $this->parsers[] = new CommentParser();
    }


    public function match(ScannerInterface $scanner)
    {
        return $scanner->matchr($this->pattern);
    }


    public function parse(ScannerInterface $scanner)
    {
        $node = new Node\Classx();

        $prelude = $scanner->expectr($this->pattern);
        $node['attr'] = array_filter(preg_split('/\s+/', $prelude[1]));
        $node['type'] = $prelude[2];
        $scanner->skip();
        $node['name'] = $scanner->expectr(self::NAME, true)[0];
        $scanner->skip();

        // even though traits, classes and interface have slightly different rules for this,
        // we don't check for that.
        foreach (array('extends', 'implements') as $attribution) {
            if ($scanner->match($attribution, true)) {
                $list = [];
                $scanner->skip();
                do {
                    $scanner->skip();
                    $list[] = $scanner->expectr(self::FQCN)[0];
                    $scanner->skip();
                } while ($scanner->match(',', true));
                $node[$attribution] = $list;
                $scanner->skip();
            }
        }
        $scanner->skip();
        $scanner->expect('{', true);
        $this->subparse($scanner, $node);
        $scanner->expect('}', true);

        return $node;
    }
}