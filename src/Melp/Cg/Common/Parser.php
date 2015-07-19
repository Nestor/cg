<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 7/19/15
 * Time: 12:25 PM
 */


class Parser
{
    public function register($parser)
    {
        $this->parsers[]= $parser;
    }
}