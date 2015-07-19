<?php
namespace Melp\Cg\Common;


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
    protected function subparse(ScannerInterface $scanner, $node)
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