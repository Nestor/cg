<?php

namespace Melp\Cg\Common;

interface BufferInterface
{
    /**
     * @param string $str
     * @return self
     */
    public function append($str);

    /**
     * @param string $str
     * @return self
     */
    public function appendl($str = '');

    /**
     * @param string $str
     * @return self
     */
    public function indent($num = 1);

    /**
     * @param string $str
     * @return self
     */
    public function outdent($num = 1);

    /**
     * @param string $str
     * @return self
     */
    public function __toString();
}