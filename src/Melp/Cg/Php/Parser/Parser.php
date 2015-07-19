<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 7/19/15
 * Time: 3:03 PM
 */
namespace Melp\Cg\Php\Parser;

use Melp\Cg\Common\Parser as BaseParser;

abstract class Parser extends BaseParser
{
    const FQCN = '#[a-zA-Z][a-zA-Z0-9_]*(\\\\[a-zA-Z][a-zA-Z0-9_]*)*#A';
    const NAME = '#[a-zA-Z][a-zA-Z0-9_]*#A';
    const VARNAME = '#\$([a-zA-Z][a-zA-Z0-9_]*)#A';
}