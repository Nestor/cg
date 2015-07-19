<?php

namespace Melp\Cg\Common;

use Exception;

class ParserException extends \UnexpectedValueException
{
    public function __construct(ScannerInterface $scanner, $message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct(
            sprintf("Parser exception\n\n%s\n", $scanner->debugInfo($message)),
            $code,
            $previous
        );
    }

}