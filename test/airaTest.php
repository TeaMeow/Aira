<?php
require 'aira.php';

define('UNIT_TESTING', true);

class AiraTest extends \PHPUnit_Framework_TestCase
{
    function testAdd()
    {
        Aira::add('INVALID_TEST', '測試。', 404);
    }

    function testAddSuccess()
    {
        Aira::addSuccess('TEST', '測試。', 200);
    }

    function testEndOrSuccess()
    {
        Aira::endOrSuccess('TEST');
    }

    function testError()
    {
        Aira::error('INVALID_TEST');
    }

    function testEmptyError()
    {
        Aira::error('NEP');
    }

    function testErrorWithExtraData()
    {
        Aira::error('TEST', ['foo' => 'bar']);
    }

    function testSuccess()
    {
        Aira::success('TEST');
    }

    function testSuccessWithExtraData()
    {
        Aira::success('TEST', ['foo' => 'bar']);
    }

    function testEmptySuccess()
    {
        Aira::success('NEP');
    }

    function testTheStart()
    {
        Aira::theStart();
    }

    function testTheEnd()
    {
        Aira::theEnd();
    }

    function testEndHere()
    {
        Aira::endHere('INVALID_TEST');
    }

    function testAlive()
    {
        Aira::alive();
    }

    function testSetErrorHandler()
    {
        Aira::setErrorHandler(function()
        {
        });

        Aira::error('NEP');
    }

    function testSetSuccessHandler()
    {
        Aira::setSuccessHandler(function()
        {
        });

        Aira::success('NEP');
    }
}
?>