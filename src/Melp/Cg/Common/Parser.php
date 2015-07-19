<?php

class Parser
{
    public function __construct($data)
    {

    }


    public function register(ParserInterface $parser)
    {
        $this->parsers[]= $parser;
    }
}