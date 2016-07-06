<?php
require 'aira.php';

class AiraTest extends \PHPUnit_Framework_TestCase
{
    function testAdd()
    {
        Aira::addSuccess('INVALID_TEST', '測試。', 404);
    }

    function testAddSuccess()
    {
        Aira::addSuccess('TEST', '測試。', 200);
    }
}
?>