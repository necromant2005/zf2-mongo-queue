<?php
// Ensure ZF is on the include path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(__DIR__ . '/../library'),
    realpath(__DIR__ . '/../../zf2/library'),
    get_include_path(),
)));

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Zend/Queue/Adapter.php';
require_once 'Zend/Queue/Adapter/AbstractAdapter.php';
require_once 'Zend/Queue/Adapter/Mongo.php';

