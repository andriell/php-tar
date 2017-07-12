<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 12.07.2017
 * Time: 15:08
 */

namespace ArchiveTar;


class FileGzWriter implements Writer
{
    private $outputFile;

    public function __construct($outputFilePath)
    {
        $this->outputFile = gzopen($outputFilePath, 'wb');;
    }

    public function write($dataStr)
    {
        gzwrite($this->outputFile, $dataStr);
    }

    public function close()
    {
        gzclose($this->outputFile);
    }
}