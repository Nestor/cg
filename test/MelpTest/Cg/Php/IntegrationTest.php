<?php

namespace MelpTest\Cg\Php;

use Melp\Cg\Common\Buffer;
use Melp\Cg\Common\NodeInterface;
use Melp\Cg\Php\Parser;

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
    public function testRoundtrip($in)
    {
        return;

        $buffer = new Buffer();
        $parser = new Parser\File(file_get_contents($in));

        $originalContents = file_get_contents($in);
        $buffer->append($parser->parse($originalContents));
        $this->assertEquals($originalContents, (string)$buffer);
    }


    public function getTestCases()
    {
        $cases = array();
        foreach (new \RegexIterator(new \DirectoryIterator(__DIR__ . '/../../../assets/'), '/\.php$/') as $file) {
            if (is_file($out = ($file->getPath() . '/' . $file->getBasename('.php') . '.txt'))) {
                $cases[]= array($file->getPathname(), $out);
            }
        }

        return $cases;
    }
}