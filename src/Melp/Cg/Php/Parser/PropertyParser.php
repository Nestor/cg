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
            $node['default']= $scanner->expectr('#([^;]+);#A', true)[1];
        } else {
            $scanner->expect(';', true);
        }
        return $node;
    }
}