<?php

namespace MelpTest\Cg\Integration;

use Melp\Cg\Common\Buffer;
use Melp\Cg\Common\NodeInterface;
use Melp\Cg\Common\Scanner;
use Melp\Cg\Php\Parser;
use RecursiveIteratorIterator;

class ParserTest extends AbstractIntegrationTest
{
    protected $assetDir = 'parser';

    /**
     * @dataProvider getTestCases
     */
    public function testRoundtrip($file)
    {
        $originalContents = file_get_contents($file);

        $buffer = new Buffer();
        $parser = new Parser\FileParser();

        $scanner = new Scanner($originalContents);
        $buffer->append($parser->parse($scanner));
        $scanner->assertEof();

        // This filter removes trailing white space and empty lines
        // Some whitespace might be lost in the parsing process. For now, we live with that.
        $filter = function($str) {
            $str = preg_replace('/\s+$/m', '', $str);
            $str = preg_replace('/^$/m', '', $str);
            return $str;
        };

        $this->assertEquals($filter($originalContents), $filter((string)$buffer));
    }


    public function getTestCases()
    {
        if (file_exists($failures = __DIR__ . '/../../../../failures.txt')) {
            $ret = array();
            foreach (file($failures) as $file) {
                $ret[]= array(trim($file));
            }
            return $ret;
        }

        $cases = array();
        foreach ($this->getFileIterator() as $file) {
            $cases[] = array($file);
        }

        return $cases;
    }
}