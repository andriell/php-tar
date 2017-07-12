<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 12.07.2017
 * Time: 15:11
 */

namespace ArchiveTar;


class StringWriter implements Writer
{
    private $date;

    public function write($dataStr)
    {
        $this->date .= $dataStr;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return $this->date;
    }

    public function close()
    {
    }
}