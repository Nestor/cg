<?php
namespace Melp\Cg\Php\Parser;


use Melp\Cg\Common\Node\Raw;
use Melp\Cg\Common\ScannerInterface;
use Melp\Cg\Php\Node\Arg;
use Melp\Cg\Php\Node\Method;
use Melp\Cg\Php\Node\Property;

class MethodParser extends Parser
{
    private $pattern = '#((?:(?:public|private|protected|static|abstract) )*)function\s+#A';

    public function match(ScannerInterface $scanner)
    {
        return $scanner->matchr($this->pattern);
    }

    public function parse(ScannerInterface $scanner)
    {
        $node = new Method();

        $node['attr'] = array_filter(preg_split('/\s+/', $scanner->expectr($this->pattern)[1]));
        $node['name'] = $scanner->expectr(self::NAME, true)[0];
        $scanner->skip();
        $scanner->expect('(');
        $scanner->skip();
        while (!$scanner->match(')', true)) {
            $arg = new Arg($scanner->expectr(self::VARNAME)[1]);
            $scanner->skip();

            if ($scanner->match('=', true)) {
                $arg['default'] = $scanner->scanUntil(array(',', ')'));
            }
            $node->appendChild($arg);
            $scanner->skip();
            if ($scanner->match(',', true)) {
                continue;
            }
        }
        $scanner->skip();
        $scanner->expect('{');
        $node->appendChild(new Raw($scanner->block()));
        $scanner->expect('}');
        return $node;
    }
}