<?php

namespace MelpTest\Cg\Php;

use Melp\Cg\Common\Buffer;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getTestCases
     */
    public function test($in, $out)
    {
        $buffer = new Buffer();

        $in->write($buffer);
        $this->assertEquals(file_get_contents($out), (string)$buffer);

    }


    public function getTestCases()
    {
        $cases = array();
        foreach (new \RegexIterator(new \DirectoryIterator(__DIR__ . '/../../../assets/'), '/\.php$/') as $file) {
            if (is_file($out = ($file->getPath() . '/' . $file->getBasename('.php') . '.txt'))) {
                $cases[]= array(require_once $file->getPathname(), $out);
            }
        }

        return $cases;
    }
}