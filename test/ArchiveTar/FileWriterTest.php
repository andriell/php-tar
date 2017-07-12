<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 12.07.2017
 * Time: 15:22
 */

namespace ArchiveTar;


class FileWriterTest extends \PHPUnit_Framework_TestCase
{
    public function test1()
    {
        echo 'Please try open file ' . __DIR__ . '/test.tar';
        $stringWriter = new FileWriter(__DIR__ . '/test.tar');
        $tar = new Tar($stringWriter);
        $tar->addFile('test1.txt', 'Test String 1', strtotime('2000-01-01 00:00:00'));
        $tar->addFile('test2.txt', 'Test String 2', strtotime('2000-01-01 00:00:00'));
        $stringWriter->close();

    }
}