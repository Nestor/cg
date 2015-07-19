<?php

namespace MelpTest\Cg\Php;

use Melp\Cg\Common\Buffer;
use Melp\Cg\Common\NodeInterface;
use Melp\Cg\Common\Scanner;
use Melp\Cg\Php\Parser;
use RecursiveIteratorIterator;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getTestCases
     */
    public function testGeneration($in, $out)
    {
        $buffer = new Buffer();
        /** @var NodeInterface $in */
        $node = require_once $in;
        $node->write($buffer);
        $this->assertEquals(file_get_contents($out), (string)$buffer);
    }


    /**
     * @dataProvider getTestCases
     */
    public function testRoundtrip($in, $out)
    {
        $originalContents = file_get_contents($out);

        $buffer = new Buffer();
        $parser = new Parser\FileParser();

        $buffer->append($parser->parse(new Scanner($originalContents)));
        $this->assertEquals($originalContents, (string)$buffer);
    }


    public function getTestCases()
    {
        $cases = array();
        foreach (new \RegexIterator(new RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . '/../../../assets/')), '/\.php$/') as $file) {
            if (is_file($out = ($file->getPath() . '/' . $file->getBasename('.php') . '.txt'))) {
                $cases[]= array($file->getPathname(), $out);
            }
        }

        return $cases;
    }
}