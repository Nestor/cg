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
        $filter = function($str) {
            $str = preg_replace('/\s+$/m', '', $str);
            $str = preg_replace('/^$/m', '', $str);
            return $str;
        };

        $this->assertEquals($filter($originalContents), $filter((string)$buffer));
    }


    public function getTestCases()
    {
        $ret = array();
        foreach (file(__DIR__ . '/../../../../failures.txt') as $file) {
            $ret[]= array(trim($file));
        }
        return $ret;
//        return $ret;
//        return array(
//            array('/home/gerard/work/cg/test/MelpTest/Cg/Integration/../../../assets/parser/symfony/src/Symfony/Component/Form/Extension/Csrf/CsrfProvider/CsrfProviderAdapter.php')
//        );

        $cases = array();
        foreach ($this->getFileIterator() as $file) {
            $cases[] = array($file);
        }

        return $cases;
    }
}