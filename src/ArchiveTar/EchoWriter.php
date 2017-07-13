<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 12.07.2017
 * Time: 15:11
 */

namespace ArchiveTar;


class EchoWriter implements Writer
{
    public function write($dataStr)
    {
        echo $dataStr;
    }

    public function close()
    {
    }
}