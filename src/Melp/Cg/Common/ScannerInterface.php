<?php

namespace Melp\Cg\Common;

interface ScannerInterface
{
    public function match($str, $advance = false);
    public function matchr($regex, $advance = false);

    /**
     * @param string $str
     * @return self
     */
    public function expect($str);
    public function expectr($regex);

    /**
     * @param string $str
     * @return array
     */
    public function skip();


    public function eof();


    public function pos();


    public function debugInfo($message);

    public function scanUntil(array $list);

    public function block();
}