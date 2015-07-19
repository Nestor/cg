<?php
namespace Melp\Cg\Php\Parser;

use Melp\Cg\Common\ScannerInterface;
use Melp\Cg\Php\Node\Method;

class MethodParser extends FunctionParser
{
    private $pattern = '#((?:(?:public|private|protected|static|abstract|final) )*)function\s+#A';

    public function match(ScannerInterface $scanner)
    {
        return $scanner->matchr($this->pattern);
    }

    public function parse(ScannerInterface $scanner)
    {
        $node = new Method();
        $node['attr'] = array_filter(preg_split('/\s+/', $scanner->expectr($this->pattern)[1]));
        $node = $this->parseFunc($scanner, $node);
        return $node;
    }
}