<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 12.07.2017
 * Time: 15:11
 */

namespace ArchiveTar;


class StringGzWriter implements Writer
{
    private $date;

    public function write($dataStr)
    {
        $this->date .= $dataStr;
    }

    /**
     * @param int $level
     * @param int $encodingMode
     * @return string
     */
    public function getDate($level = 9, $encodingMode = FORCE_GZIP)
    {
        return gzencode($this->date, $level, $encodingMode);
    }

    /**
     * @return string
     */
    function __toString()
    {
        return gzencode($this->date);
    }

    public function close()
    {
    }
}