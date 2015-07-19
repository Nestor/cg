<?php
namespace Melp\Cg\Php\Parser;


use Melp\Cg\Common\ScannerInterface;
use Melp\Cg\Php\Node\Property;

class PropertyParser extends Parser
{
    private $pattern = '#((?:(?:public|private|protected|static)\s+)*)(?=\$)#A';

    public function match(ScannerInterface $scanner)
    {
        return $scanner->matchr($this->pattern);
    }

    public function parse(ScannerInterface $scanner)
    {
        $node = new Property();

        $node['attr'] = array_filter(preg_split('/\s+/', $scanner->expectr($this->pattern)[1]));

        $node['name'] = $scanner->expectr(self::VARNAME, true)[1];
        $scanner->skip();
        if ($scanner->match('=', true)) {
            $scanner->skip();
            $node['default']= $scanner->scanUntil([';', ','], '(');
        }

        $scanner->skip();
        while ($scanner->match(',', true)) {
            $scanner->skip();
            // TODO make this undirty.
            $sibling = new Property();
            $sibling['name'] = $scanner->expectr(self::VARNAME, true)[1];
            $scanner->skip();
            if ($scanner->match('=', true)) {
                $scanner->skip();
                $sibling['default']= $scanner->scanUntil([';', ','], '(');
            }
            $node->appendChild($sibling);
        }
        $scanner->expect(';', true);
        return $node;
    }
}