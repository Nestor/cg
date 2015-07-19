<?php
namespace Melp\Cg\Php\Parser;


use Melp\Cg\Common\ScannerInterface;
use Melp\Cg\Php\Node\Constx;
use Melp\Cg\Php\Node\Property;

class ConstParser extends Parser
{
    private $pattern = '#const\s+#A';

    public function match(ScannerInterface $scanner)
    {
        return $scanner->matchr($this->pattern);
    }

    /**
     * @param ScannerInterface $scanner
     * @return Constx
     */
    public function parse(ScannerInterface $scanner)
    {
        $node = new Constx();
        $scanner->expectr($this->pattern);
        $node['name'] = $scanner->expectr(self::NAME)[0];
        $scanner->skip();
        $scanner->expect('=');
        $scanner->skip();
        $node['value'] = $scanner->expectr('#([^;]+)#A', true)[1];
        $scanner->expect(';');
        return $node;
    }
}