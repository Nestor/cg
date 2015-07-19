<?php

namespace Melp\Cg\Common;

interface ParserInterface
{
    public function match(ScannerInterface $scanner);
    public function parse(ScannerInterface $scanner);
}