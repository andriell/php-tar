# php-tarSimple tar writer# Example 1Write tar gz to file    $stringWriter = new FileGzWriter(__DIR__ . '/test.tar.gz');    $tar = new Tar($stringWriter);    $tar->addFile('test1.txt', 'Test String 1');    $tar->addFile('test2.txt', 'Test String 2');    $stringWriter->close();# Example 2Write tar gz to string    $stringWriter = new StringWriter();    $tar = new Tar($stringWriter);    $tar->addFile('test1.txt', 'Test String 1');    $tar->addFile('test2.txt', 'Test String 2');    $tarString = $stringWriter->getDate();