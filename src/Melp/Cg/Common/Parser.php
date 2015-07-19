<?php
namespace Melp\Cg\Common;


use Melp\Cg\Common\Node\Raw;
use Melp\Cg\Php\Node\Arg;
use Melp\Cg\Php\Parser\MethodParser;

abstract class Parser implements ParserInterface
{
    /**
     * @var ParserInterface[]
     */
    protected $parsers;

    public function __construct()
    {
        $this->parsers = [];
    }

    /**
     * @param ScannerInterface $scanner
     * @param $node
     */
    protected function subparse(ScannerInterface $scanner, NodeInterface $node)
    {
        while (!$scanner->eof()) {
            $scanner->skip();
            foreach ($this->parsers as $parser) {
                if ($parser->match($scanner)) {
                    $node->appendChild($parser->parse($scanner));
                    continue 2;
                }
            }

            break;
        }
    }
}