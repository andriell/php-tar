<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 12.07.2017
 * Time: 15:08
 */

namespace ArchiveTar;


class FileWriter implements Writer
{
    private $outputFile;

    public function __construct($outputFilePath)
    {
        $this->outputFile = fopen($outputFilePath, 'w+b');;
    }

    public function write($dataStr)
    {
        fwrite($this->outputFile, $dataStr);
    }

    public function close()
    {
        fclose($this->outputFile);
    }
}