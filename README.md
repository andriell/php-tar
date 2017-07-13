# php-tarTar / tar.gz writer. You can use it to work with large files without creating temporary files# Example 1Add a large file to standard output    $echoWriter = new EchoWriter();    $tar = new Tar($echoWriter);    $tar->addBigFile('big_file.avi');    $tar->addBigFile('big_file2.avi', 'new/file/name.avi');    $tar->close();# Example 2Write tar gz to file    $stringWriter = new FileGzWriter(__DIR__ . '/test.tar.gz');    $tar = new Tar($stringWriter);    $tar->addFile('test1.txt', 'Test String 1');    $tar->addFile('test2.txt', 'Test String 2');    $tar->close();    # Example 3Write tar to file    $stringWriter = new FileWriter(__DIR__ . '/test.tar');    $tar = new Tar($stringWriter);    $tar->addFile('test1.txt', 'Test String 1');    $tar->addFile('test2.txt', 'Test String 2');    $tar->close();# Example 4Write tar gz to string    $stringWriter = new StringGzWriter();    $tar = new Tar($stringWriter);    $tar->addFile('test1.txt', 'Test String 1');    $tar->addFile('test2.txt', 'Test String 2');    $tar->close();    $tarString = $stringWriter->getDate();    # Example 5Write tar to string    $stringWriter = new StringWriter();    $tar = new Tar($stringWriter);    $tar->addFile('test1.txt', 'Test String 1');    $tar->addFile('test2.txt', 'Test String 2');    $tar->close();    $tarString = $stringWriter->getDate();