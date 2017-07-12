<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 12.07.2017
 * Time: 15:22
 */

namespace ArchiveTar;


class StringGzWriterTest extends \PHPUnit_Framework_TestCase
{
    public function test1()
    {
        $str1 = '1f8b080000000000020b2b492d2ed12ba92861a021303430303733536050000143341acc36565030373036363234313532000a98999b1829301830d001941697241629308c5410028c7f85e092a2ccbc748651300a46c128180523070000ada8386400080000';
        $stringWriter = new StringGzWriter();
        $tar = new Tar($stringWriter);
        $tar->addFile('test.txt', 'Test String', strtotime('2000-01-01 00:00:00'));
        $tar->close();
        $str2 = $stringWriter->getDate(9, FORCE_GZIP);
        $this->assertEquals($str1, bin2hex($str2));
    }
}