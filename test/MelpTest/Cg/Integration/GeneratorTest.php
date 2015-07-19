<?php

namespace MelpTest\Cg\Integration;

use Melp\Cg\Common\Buffer;
use Melp\Cg\Common\NodeInterface;
use Melp\Cg\Common\Scanner;
use Melp\Cg\Php\Parser;
use RecursiveIteratorIterator;

class GeneratorTest extends AbstractIntegrationTest
{
    protected $assetDir = 'generator';

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


    public function getTestCases()
    {
        $cases = array();
        foreach ($this->getFileIterator() as $file) {
            if (is_file($out = ($file->getPath() . '/' . $file->getBasename('.php') . '.txt'))) {
                $cases[] = array($file->getPathname(), $out);
            }
        }

        return $cases;
    }
}