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

    function addFile($fileName, $data, $time = null, $perm = 100766)
    {
        if (empty($time)) {
            $time = time();
        }
        $uid = sprintf('%6s ', decoct(1));
        $gid = sprintf('%6s ', decoct(1));
        $perms = sprintf('%6s ', $perm);
        $mTime = sprintf('%11s ', decoct($time));

        $typeFlag = '0';
        $dataSize = mb_strlen($data, '8bit');;

        $sizeStr = sprintf('%11u ', decoct($dataSize));
        $magic = sprintf('%5s ', 'ustar');
        $version = $linkName = $userName = $groupName = $devMajor = $devMinor = $prefix = '';
        $binary_data_first = pack('a100a8a8a8a12a12', $fileName, $perms, $uid, $gid, $sizeStr, $mTime);
        $binary_data_last = pack('a1a100a6a2a32a32a8a8a155a12', $typeFlag, $linkName, $magic, $version, $userName, $groupName, $devMajor, $devMinor, $prefix, '');

        // считаем контрольную сумму заголовка
        $checksum = 0;
        for ($i = 0; $i < 148; $i++) {
            $checksum += ord(substr($binary_data_first, $i, 1));
        }
        for ($i = 148; $i < 156; $i++) {
            $checksum += ord(' ');
        }
        for ($i = 156, $j = 0; $i < 512; $i++, $j++) {
            $checksum += ord(substr($binary_data_last, $j, 1));
        }
        $checksum = sprintf('%6s ', decoct($checksum));
        $binary_data = pack('a8', $checksum);

        $this->writer->write($binary_data_first);
        $this->writer->write($binary_data);
        $this->writer->write($binary_data_last);
        $this->writer->write($data);
        $l512 = $dataSize % 512;
        if ($l512 != 0) {
            $this->writer->write(pack('a' . (512 - $l512), ''));
        }
    }

    public function close() {
        $this->writer->write(pack('a' . 1024, ''));
        $this->writer->close();
    }
}

