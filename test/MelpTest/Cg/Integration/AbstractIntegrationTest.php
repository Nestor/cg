<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 7/19/15
 * Time: 6:41 PM
 */

namespace MelpTest\Cg\Integration;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

abstract class AbstractIntegrationTest extends \PHPUnit_Framework_TestCase
{
    protected $assetDir = null;

    /**
     * @return \RegexIterator
     */
    protected function getFileIterator()
    {
        return new RegexIterator(
            new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    __DIR__ . '/../../../assets/' . $this->assetDir
                )
            ),
            '/\.php$/'
        );
    }
}