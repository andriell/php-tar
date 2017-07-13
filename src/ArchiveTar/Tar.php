<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 12.07.2017
 * Time: 15:07
 */

namespace ArchiveTar;

class Tar
{
    private $writer;

    public function __construct(Writer &$writer)
    {
        $this->writer = $writer;
    }

    private function writeHeader($name, $dataSize, $perms, $uid, $gid, $mTime, $typeFlag = '0')
    {
        $dataSize = sprintf('%11u ', decoct($dataSize));
        $perms = sprintf('%6s ', $perms);
        $uid = sprintf('%6s ', DecOct($uid));
        $gid = sprintf('%6s ', DecOct($gid));
        $mTime = sprintf('%11s ', DecOct($mTime));

        $magic = sprintf('%5s ', 'ustar');
        $version = $linkName = $userName = $groupName = $devMajor = $devMinor = $prefix = '';
        $binaryDataFirst = pack('a100a8a8a8a12a12', $name, $perms, $uid, $gid, $dataSize, $mTime);
        $binaryDataLast = pack('a1a100a6a2a32a32a8a8a155a12', $typeFlag, $linkName, $magic, $version, $userName, $groupName, $devMajor, $devMinor, $prefix, '');

        //<editor-fold desc='Header checksum'>
        $checksum = 0;
        for ($i = 0; $i < 148; $i++) {
            $checksum += ord(substr($binaryDataFirst, $i, 1));
        }
        for ($i = 148; $i < 156; $i++) {
            $checksum += ord(' ');
        }
        for ($i = 156, $j = 0; $i < 512; $i++, $j++) {
            $checksum += ord(substr($binaryDataLast, $j, 1));
        }
        $checksum = sprintf('%6s ', decoct($checksum));
        $checksum = pack('a8', $checksum);
        //</editor-fold>

        $this->writer->write($binaryDataFirst);
        $this->writer->write($checksum);
        $this->writer->write($binaryDataLast);
    }

    private function writeEnd($dataSize)
    {
        $l512 = $dataSize % 512;
        if ($l512 != 0) {
            $this->writer->write(pack('a' . (512 - $l512), ''));
        }
    }

    function addBigFile($filePath, $fileName = null, $stepSize = 102400)
    {
        if (empty($fileName)) {
            $fileName = basename($fileName);
        }
        $info = stat($filePath);
        $this->writeHeader($fileName, $info[7], fileperms($filePath), $info[4], $info[5], $info[9]);

        $file = fopen($filePath, 'r');
        while ($data = fgets($file, $stepSize) !== false) {
            $this->writer->write($data);
        }
        fclose($file);

        $this->writeEnd($info[7]);
    }

    function addFile($fileName, $data, $time = null, $perm = 100766, $uid = 1, $gid = 1)
    {
        if (empty($time)) {
            $time = time();
        }
        $dataSize = mb_strlen($data, '8bit');
        $this->writeHeader($fileName, $dataSize, $perm, $uid, $gid, $time);

        $this->writer->write($data);

        $this->writeEnd($dataSize);
    }

    public function close()
    {
        $this->writer->write(pack('a' . 1024, ''));
        $this->writer->close();
    }
}

