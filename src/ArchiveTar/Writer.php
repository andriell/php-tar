<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 12.07.2017
 * Time: 15:07
 */

namespace ArchiveTar;


interface Writer
{
    public function write($dataStr);
    public function close();
}