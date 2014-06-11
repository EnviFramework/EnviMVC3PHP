<?php
/**
 *
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */


/**
 *
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */
class EnviValidatorTest extends testCaseBase
{
    /**
     * +-- 初期化
     *
     * @access public
     * @return void
     */
    public function initialize()
    {
        include_once dirname(__FILE__).'/../../../envi3/EnviValidator.php';
        include_once dirname(__FILE__).'/../../../envi3/EnviRequest.php';
        $this->free();
    }
    /* ----------------------------------------- */
    // +-- Upper Version 3.3.1
    public function equalTest()
    {
        $res = validator()->validation('equal', 'foo', 'foo');
        $this->assertTrue($res);
        $res = validator()->validation('equal', 'foo', 'bar');
        $this->assertFalse($res);
        $res = validator()->validation('equal', '', NULL);
        $this->assertTrue($res);
    }


    public function notequalTest()
    {
        $res = validator()->validation('notequal', 'foo', 'foo');
        $this->assertFalse($res);
        $res = validator()->validation('notequal', 'foo', 'bar');
        $this->assertTrue($res);
        $res = validator()->validation('notequal', '', NULL);
        $this->assertTrue($res);
    }

    public function xdigitTest()
    {
        $res = validator()->validation('xdigit', '1234567890abcdef', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('xdigit', '1234567890abcdefg', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('xdigit', '123.456', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('xdigit', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('xdigit', '', NULL);
        $this->assertTrue($res);
    }


    public function digitTest()
    {
        $res = validator()->validation('digit', '1234567890', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('digit', '123456789a0', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('digit', '123.456', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('digit', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('digit', '', NULL);
        $this->assertTrue($res);
    }


    public function cntrlTest()
    {
        $res = validator()->validation('cntrl', "\r\n", NULL);
        $this->assertTrue($res);
        $res = validator()->validation('cntrl', '123456789a0', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('cntrl', '123.456', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('cntrl', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('cntrl', '', NULL);
        $this->assertTrue($res);
    }

    public function graphTest()
    {
        $res = validator()->validation('graph', '123456789asdfa', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('graph', '!', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('graph', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('graph', '   ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('graph', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('graph', '', NULL);
        $this->assertTrue($res);
    }

    public function lowerTest()
    {
        $res = validator()->validation('lower', 'asdafghjkl', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('lower', '132456879', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('lower', 'A', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('lower', '!', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('lower', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('lower', '   ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('lower', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('lower', '', NULL);
        $this->assertTrue($res);
    }
    public function upperTest()
    {
        $res = validator()->validation('upper', 'ASDAFGHJKL', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('upper', '132456879', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('upper', 'a', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('upper', '!', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('upper', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('upper', '   ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('upper', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('upper', '', NULL);
        $this->assertTrue($res);
    }

    public function printTest()
    {
        $res = validator()->validation('print', '123456789asdfa', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('print', '!', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('print', '   ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('print', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('print', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('print', '', NULL);
        $this->assertTrue($res);
    }


    public function punctTest()
    {
        $res = validator()->validation('punct', '!', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('punct', '123456789asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('punct', '   ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('punct', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('punct', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('punct', '', NULL);
        $this->assertTrue($res);
    }

    public function spaceTest()
    {
        $res = validator()->validation('space', '!', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('space', '123456789asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('space', '   ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('space', "\r\n", NULL);
        $this->assertTrue($res);
        $res = validator()->validation('space', '　', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('space', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('equal', '', NULL);
        $this->assertTrue($res);
    }


    public function notxdigitTest()
    {
        $res = validator()->validation('notxdigit', '1234567890abcdef', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('notxdigit', '1234567890abcdefg', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('notxdigit', '123.456', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('notxdigit', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('notxdigit', '', NULL);
        $this->assertTrue($res);
    }


    public function withoutdigitTest()
    {
        $res = validator()->validation('withoutdigit', '1234567890', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutdigit', '123456789a0', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutdigit', '123.456', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutdigit', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutdigit', '', NULL);
        $this->assertTrue($res);
    }


    public function withoutcntrlTest()
    {
        $res = validator()->validation('withoutcntrl', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutcntrl', '123456789a0', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutcntrl', '123.456', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutcntrl', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutcntrl', '', NULL);
        $this->assertTrue($res);
    }

    public function withoutgraphTest()
    {
        $res = validator()->validation('withoutgraph', '123456789asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutgraph', '!', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutgraph', "\r\n", NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutgraph', '   ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutgraph', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutgraph', '', NULL);
        $this->assertTrue($res);
    }

    public function withoutlowerTest()
    {
        $res = validator()->validation('withoutlower', 'asdafghjkl', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutlower', '132456879', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutlower', 'A', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutlower', '!', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutlower', "\r\n", NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutlower', '   ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutlower', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutlower', '', NULL);
        $this->assertTrue($res);
    }
    public function withoutupperTest()
    {
        $res = validator()->validation('withoutupper', 'ASDAFGHJKL', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutupper', '132456879', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutupper', 'a', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutupper', '!', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutupper', "\r\n", NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutupper', '   ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutupper', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutupper', '', NULL);
        $this->assertTrue($res);
    }

    public function withoutprintTest()
    {
        $res = validator()->validation('withoutprint', '123456789asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutprint', '!', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutprint', '   ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutprint', "\r\n", NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutprint', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutprint', '', NULL);
        $this->assertTrue($res);
    }


    public function withoutpunctTest()
    {
        $res = validator()->validation('withoutpunct', '!', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutpunct', '123456789asdfa', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutpunct', '   ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutpunct', "\r\n", NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutpunct', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutpunct', '', NULL);
        $this->assertTrue($res);
    }

    public function withoutspacespaceTest()
    {
        $res = validator()->validation('withoutspace', '!', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutspace', '123456789asdfa', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutspace', '   ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutspace', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutspace', '　', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutspace', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutspace', '', NULL);
        $this->assertTrue($res);
    }



    public function withoutalphabetTest()
    {

        $res = validator()->validation('withoutalphabet', '!', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutalphabet', '123456789', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutalphabet', 'asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutalphabet', '123456789asdfa', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutalphabet', '123456789ASDFA', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutalphabet', '   ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutalphabet', "\r\n", NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutalphabet', '　', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutalphabet', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutalphabet', '', NULL);
        $this->assertTrue($res);
    }

    public function withoutalphabetornumberTest()
    {
        $res = validator()->validation('withoutalphabetornumber', '!', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutalphabetornumber', '123456789', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutalphabetornumber', 'asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutalphabetornumber', '123456789asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutalphabetornumber', '123456789ASDFA', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutalphabetornumber', '   ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutalphabetornumber', "\r\n", NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutalphabetornumber', '　', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('withoutalphabetornumber', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('withoutalphabetornumber', '', NULL);
        $this->assertTrue($res);
    }

    /* ----------------------------------------- */



    public function numberTest()
    {

        $res = validator()->validation('number', '!', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('number', '123456789', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('number', '12345.6789', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('number', '0', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('number', 'asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('number', '123456789asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('number', '123456789ASDFA', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('number', '   ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('number', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('number', '　', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('number', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('number', '', NULL);
        $this->assertTrue($res);
    }


    public function naturalnumberTest()
    {
        $res = validator()->validation('naturalnumber', '!', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('naturalnumber', '123456789', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('naturalnumber', '12345.6789', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('naturalnumber', '0', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('naturalnumber', 'asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('naturalnumber', '123456789asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('naturalnumber', '123456789ASDFA', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('naturalnumber', '   ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('naturalnumber', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('naturalnumber', '　', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('naturalnumber', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('naturalnumber', '', NULL);
        $this->assertTrue($res);
    }


    public function integerTest()
    {
        $res = validator()->validation('integer', '!', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('integer', '123456789', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('integer', '-123456789', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('integer', '1234.56789', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('integer', 'asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('integer', '123456789asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('integer', '123456789ASDFA', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('integer', '   ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('integer', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('integer', '　', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('integer', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('integer', '', NULL);
        $this->assertTrue($res);
    }

    public function numbermaxTest()
    {
        $res = validator()->validation('numbermax', '10', '10');
        $this->assertTrue($res);
        $res = validator()->validation('numbermax', '9', '10');
        $this->assertTrue($res);
        $res = validator()->validation('numbermax', '11', '10');
        $this->assertFalse($res);
        $res = validator()->validation('numbermax', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('numbermax', '', NULL);
        $this->assertTrue($res);
    }
    public function numberminTest()
    {
        $res = validator()->validation('numbermin', '10', '10');
        $this->assertTrue($res);
        $res = validator()->validation('numbermin', '9', '10');
        $this->assertFalse($res);
        $res = validator()->validation('numbermin', '11', '10');
        $this->assertTrue($res);
        $res = validator()->validation('numbermin', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('numbermin', '', NULL);
        $this->assertTrue($res);
    }

    public function alphabetTest()
    {

        $res = validator()->validation('alphabet', '!', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabet', '123456789', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabet', 'asdfa', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('alphabet', '123456789asdfa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabet', '123456789ASDFA', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabet', '   ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabet', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabet', '　', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabet', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabet', '', NULL);
        $this->assertTrue($res);
    }

    public function alphabetornumberTest()
    {
        $res = validator()->validation('alphabetornumber', '!', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabetornumber', '123456789', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('alphabetornumber', 'asdfa', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('alphabetornumber', '123456789asdfa', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('alphabetornumber', '123456789ASDFA', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('alphabetornumber', '   ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabetornumber', "\r\n", NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabetornumber', '　', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabetornumber', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('alphabetornumber', '', NULL);
        $this->assertTrue($res);
    }


    public function romeTest()
    {
        $res = validator()->validation('rome', '!', false);
        $this->assertTrue($res);
        $res = validator()->validation('rome', '123456789', false);
        $this->assertTrue($res);
        $res = validator()->validation('rome', 'asdfa', false);
        $this->assertTrue($res);
        $res = validator()->validation('rome', '123456789asdfa', false);
        $this->assertTrue($res);
        $res = validator()->validation('rome', '123456789ASDFA', false);
        $this->assertTrue($res);
        $res = validator()->validation('rome', '   ', false);
        $this->assertFalse($res);
        $res = validator()->validation('rome', "\r\n", false);
        $this->assertFalse($res);
        $res = validator()->validation('rome', '　', false);
        $this->assertFalse($res);


        $res = validator()->validation('rome', '！', true);
        $this->assertTrue($res);
        $res = validator()->validation('rome', '１２３４５６６７８９', true);
        $this->assertTrue($res);
        $res = validator()->validation('rome', 'ａｂｄａ', true);
        $this->assertTrue($res);
        $res = validator()->validation('rome', '１２３ａｓｄｆ', true);
        $this->assertTrue($res);
        $res = validator()->validation('rome', '１２３ＡＳＤＦ', true);
        $this->assertTrue($res);
        $res = validator()->validation('rome', '!', true);
        $this->assertTrue($res);
        $res = validator()->validation('rome', '123456789', true);
        $this->assertTrue($res);
        $res = validator()->validation('rome', 'asdfa', true);
        $this->assertTrue($res);
        $res = validator()->validation('rome', '123456789asdfa', true);
        $this->assertTrue($res);
        $res = validator()->validation('rome', '123456789ASDFA', true);
        $this->assertTrue($res);
        $res = validator()->validation('rome', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('rome', '', NULL);
        $this->assertTrue($res);
    }

    public function maxwidthTest()
    {
        $res = validator()->validation('maxwidth', '123456789a', 10);
        $this->assertTrue($res);
        $res = validator()->validation('maxwidth', 'あいうえお', 10);
        $this->assertTrue($res);
        $res = validator()->validation('maxwidth', '123456780', 10);
        $this->assertTrue($res);
        $res = validator()->validation('maxwidth', '123456789ab', 10);
        $this->assertFalse($res);
        $res = validator()->validation('maxwidth', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('maxwidth', '', NULL);
        $this->assertTrue($res);
    }

    public function minwidthTest()
    {
        $res = validator()->validation('minwidth', '123456789a', 10);
        $this->assertTrue($res);
        $res = validator()->validation('minwidth', '123456780', 10);
        $this->assertFalse($res);
        $res = validator()->validation('minwidth', '123456789ab', 10);
        $this->assertTrue($res);
        $res = validator()->validation('minwidth', 'あいうえ', 10);
        $this->assertFalse($res);
        $res = validator()->validation('minwidth', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('minwidth', '', NULL);
        $this->assertTrue($res);
    }
    public function blankTest()
    {
        $res = validator()->validation('blank', '', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('blank', NULL, NULL);
        $this->assertTrue($res);
        $res = validator()->validation('blank', '0', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('blank', '    ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('blank', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('blank', array('foo' => ''), NULL);
        $this->assertTrue($res);
    }
    public function noblankTest()
    {
        $res = validator()->validation('noblank', '', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('noblank', NULL, NULL);
        $this->assertFalse($res);
        $res = validator()->validation('noblank', '0', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('noblank', '    ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('noblank', array('foo' => 'bar'), NULL);
        $this->assertTrue($res);
        $res = validator()->validation('noblank', array('foo' => ''), NULL);
        $this->assertFalse($res);
    }
    public function nosubmitTest()
    {
        $res = validator()->validation('nosubmit', '', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('nosubmit', NULL, NULL);
        $this->assertTrue($res);
        $res = validator()->validation('nosubmit', false, NULL);
        $this->assertFalse($res);
        $res = validator()->validation('nosubmit', '0', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('nosubmit', '    ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('nosubmit', array('foo' => 'bar'), NULL);
        $this->assertTrue($res);
    }



    public function encodingTest()
    {
        $res = validator()->validation('encoding', '123456789あいうえお', 'UTF-8');
        $this->assertTrue($res);
        $res = validator()->validation('encoding', '123456789あいうえお', 'EUC-JP');
        $this->assertFalse($res);
        $res = validator()->validation('encoding', array('foo' => '123456789あいうえお'), 'UTF-8');
        $this->assertTrue($res);
        $res = validator()->validation('encoding', array('foo' => '123456789あいうえお'), 'EUC-JP');
        $this->assertFalse($res);
        $res = validator()->validation('encoding', '', NULL);
        $this->assertTrue($res);
    }


    public function notagsTest()
    {
        $res = validator()->validation('notags', '123456789あいうえお', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('notags', '123456789あいうえお<br />', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('notags', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('notags', '', NULL);
        $this->assertTrue($res);
    }


    public function dependTest()
    {
        $res = validator()->validation('depend', '123456789あいうえお', false);
        $this->assertTrue($res);
        $res = validator()->validation('depend', '123456789あいうえお①', false);
        $this->assertFalse($res);
        $res = validator()->validation('depend', array('foo' => 'bar'), false);
        $this->assertFalse($res);
        $res = validator()->validation('depend', '123456789あいうえお', true);
        $this->assertTrue($res);
        $res = validator()->validation('depend', '123456789あいうえお①', true);
        $this->assertFalse($res);
        $res = validator()->validation('depend', array('foo' => 'bar'), true);
        $this->assertFalse($res);
        $res = validator()->validation('depend', '', NULL);
        $this->assertTrue($res);
    }



    public function mailformatTest()
    {
        $res = validator()->validation('mailformat', 'akito-artisan@five-foxes.com,akito-artisan@example.com', false);
        $this->assertTrue($res);
        $res = validator()->validation('mailformat', '123456789あいうえお①', false);
        $this->assertFalse($res);
        $res = validator()->validation('mailformat', array('foo' => 'bar'), false);
        $this->assertFalse($res);


        $res = validator()->validation('mailformat', 'akito-artisan@five-foxes.com,akito-artisan@example.com', true);
        $this->assertTrue($res);
        $res = validator()->validation('mailformat', '123456789あいうえお①', true);
        $this->assertFalse($res);
        $res = validator()->validation('mailformat', array('foo' => 'bar'), true);
        $this->assertFalse($res);
        $res = validator()->validation('mailformat', '', NULL);
        $this->assertTrue($res);
    }


    public function mailsimpleTest()
    {
        $res = validator()->validation('mailsimple', 'akito-artisan@five-foxes.com', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('mailsimple', 'akito-artisan@five-foxes.com,akito-artisan@example.com', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('mailsimple', '123456789あいうえお①', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('mailsimple', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);


        $res = validator()->validation('mailsimple', 'akito-artisan@five-foxes.com', true);
        $this->assertTrue($res);
        $res = validator()->validation('mailsimple', 'akito-artisan@five-foxes.com,akito-artisan@example.com', true);
        $this->assertFalse($res);
        $res = validator()->validation('mailsimple', '123456789あいうえお①', true);
        $this->assertFalse($res);
        $res = validator()->validation('mailsimple', array('foo' => 'bar'), true);
        $this->assertFalse($res);
        $res = validator()->validation('mailsimple', '', NULL);
        $this->assertTrue($res);
    }

    public function mailTest()
    {
        $res = validator()->validation('mail', 'akito-artisan@five-foxes.com', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('mail', 'akito-artisan@example.com.aaa', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('mail', '123456789あいうえお①', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('mail', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('mail', '', NULL);
        $this->assertTrue($res);
    }


    public function hiraganaTest()
    {
        $res = validator()->validation('hiragana', 'あいうえおかきくけこがぎぐげごしゃしゅしょ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('hiragana', 'カ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('hiragana', 'あいうえおかきくけこがぎぐげごしゃしゅしょ', true);
        $this->assertTrue($res);
        $res = validator()->validation('hiragana', 'カ', true);
        $this->assertTrue($res);
        $res = validator()->validation('hiragana', 'abcd', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('hiragana', '132456', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('hiragana', 'ー', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('hiragana', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);

    }




    public function katakanaTest()
    {
        $res = validator()->validation('katakana', 'アイウエオカキクケゴガギグゲゴシャシュショ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('katakana', 'あ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('katakana', 'アイウエオカキクケゴガギグゲゴシャシュショ', true);
        $this->assertTrue($res);
        $res = validator()->validation('katakana', 'あ', true);
        $this->assertTrue($res);
        $res = validator()->validation('katakana', 'abcd', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('katakana', '132456', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('katakana', 'ー', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('katakana', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);

    }




    public function hfuriganaTest()
    {
        $res = validator()->validation('hfurigana', 'あいうえおかきくけこがぎぐげごしゃしゅしょ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('hfurigana', 'カ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('hfurigana', 'あいうえおかきくけこがぎぐげごしゃしゅしょ', true);
        $this->assertTrue($res);
        $res = validator()->validation('hfurigana', 'カ', true);
        $this->assertTrue($res);
        $res = validator()->validation('hfurigana', 'abcd', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('hfurigana', '132456', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('hfurigana', 'ー', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('hfurigana', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);

    }




    public function kfuriganaTest()
    {
        $res = validator()->validation('kfurigana', 'アイウエオカキクケゴガギグゲゴシャシュショ', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('kfurigana', 'あ', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('kfurigana', 'アイウエオカキクケゴガギグゲゴシャシュショ', true);
        $this->assertTrue($res);
        $res = validator()->validation('kfurigana', 'あ', true);
        $this->assertTrue($res);
        $res = validator()->validation('kfurigana', 'abcd', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('kfurigana', '132456', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('kfurigana', 'ー', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('kfurigana', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);

    }



    public function urlformatTest()
    {
        $res = validator()->validation('urlformat', 'http://www.enviphp.net/', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('url', 'ｈｔｔｐ：／／ｗｗｗ．ｅｎｖｉｐｈｐ．ｎｅｔ／', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('url', 'ｈｔｔｐ：／／ｗｗｗ．ｅｎｖｉｐｈｐ．ｎｅｔ／', true);
        $this->assertTrue($res);
        $res = validator()->validation('urlformat', 'http://www.enviphp.net/c/man/v3/install#install-top-easy', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('urlformat', 'http://www.enviphp.net/c/man/v3/', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('urlformat', 'http://www.enviphp.net/c/man/v3/core', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('urlformat', '132456', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('urlformat', 'www.enviphp.net/c/man/v3/', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('urlformat', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);

    }




    public function urlTest()
    {
        $res = validator()->validation('url', 'http://www.enviphp.net/', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('url', 'ｈｔｔｐ：／／ｗｗｗ．ｅｎｖｉｐｈｐ．ｎｅｔ／', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('url', 'ｈｔｔｐ：／／ｗｗｗ．ｅｎｖｉｐｈｐ．ｎｅｔ／', true);
        $this->assertTrue($res);
        $res = validator()->validation('url', 'http://www.enviphp.net/c/man/v3/install#install-top-easy', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('url', 'http://www.enviphp.net/c/man/v3/', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('url', 'http://www.enviphp.net/c/man/v3/core', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('url', '132456', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('url', 'www.enviphp.net/c/man/v3/', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('url', 'http://www.enviphp.net.aaaa/', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('url', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);

    }


    public function telephoneTest()
    {
        $res = validator()->validation('telephone', '123-456-789', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('telephone', '+83-123-456-789', NULL);
        $this->assertTrue($res);

        $res = validator()->validation('telephone', '１２３－４５６－７８９', true);
        $this->assertTrue($res);
        $res = validator()->validation('telephone', '＋８３-１２３－４５６－７８９', true);
        $this->assertTrue($res);

        $res = validator()->validation('telephone', '１２３－４５６－７８９', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('telephone', '＋８３-１２３－４５６－７８９', NULL);
        $this->assertFalse($res);


        $res = validator()->validation('telephone', '+83123456789', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('telephone', '123456789', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('telephone', '12345+6789', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('telephone', '12345abcd', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('telephone', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);

    }


    public function postcodeformatTest()
    {
        $res = validator()->validation('postcodeformat', '123-4567', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('postcodeformat', '１２３－４５６７', true);
        $this->assertTrue($res);
        $res = validator()->validation('postcodeformat', '１２３－４５６７', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('postcodeformat', '1234567', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('postcodeformat', '123-456-789', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('postcodeformat', '+83-123-456-789', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('postcodeformat', '+83123456789', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('postcodeformat', '123456789', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('postcodeformat', '12345+6789', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('postcodeformat', '12345abcd', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('postcodeformat', array('foo' => 'bar'), NULL);
        $this->assertFalse($res);

    }


    public function whitelistTest()
    {
        $res = validator()->validation('whitelist', 'aaa', array('aaa', 'bbb', 'ccc'));
        $this->assertTrue($res);
        $res = validator()->validation('whitelist', 'bbb', array('aaa', 'bbb', 'ccc'));
        $this->assertTrue($res);
        $res = validator()->validation('whitelist', 'ccc', array('aaa', 'bbb', 'ccc'));
        $this->assertTrue($res);
        $res = validator()->validation('whitelist', 'ddd', array('aaa', 'bbb', 'ccc'));
        $this->assertFalse($res);
        $res = validator()->validation('whitelist', array('foo' => 'bar'),  array('aaa', 'bbb', 'ccc'));
        $this->assertFalse($res);

    }




    public function dateTest()
    {
        $res = validator()->validation('date', '1983-01-29', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('date', '1983-1-29', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('date', '1983-1-1', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('date', '1983-1-01', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('date', '1983-01-32', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('date', '19830129', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('date', '19830132', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('date', '1983/01/29', NULL);
        $this->assertTrue($res);
        $res = validator()->validation('date', '1983/01/32', NULL);
        $this->assertFalse($res);
        $res = validator()->validation('date', array('year' => '1983', 'month' => '01', 'day' => '29'),  array('year' => 'year', 'month' => 'month', 'day' => 'day'));
        $this->assertTrue($res);
        $res = validator()->validation('date', array('year' => '1983', 'month' => '01', 'Day' => '29'),  array('year' => 'year', 'month' => 'month', 'day' => 'day'));
        $this->assertFalse($res);
        $e = null;
        try{
            $res = validator()->validation('date', array('year' => '1983', 'month' => '01', 'day' => '29'),  array('month' => 'month', 'day' => 'day'));
        } catch (exception $e) {

        }
        $this->assertInstanceOf('EnviException', $e);
    }





    public function timeTest()
    {
        $res = validator()->validation('time', '12:06:24', validator::HOUR_TO_SECOND);
        $this->assertTrue($res);
        $res = validator()->validation('time', '12:06', validator::HOUR_TO_MINUTE);
        $this->assertTrue($res);
        $res = validator()->validation('time', '12', validator::HOUR_ONLY);
        $this->assertTrue($res);
        $res = validator()->validation('time', '120624', validator::HOUR_TO_SECOND);
        $this->assertTrue($res);
        $res = validator()->validation('time', '1206', validator::HOUR_TO_MINUTE);
        $this->assertTrue($res);
        $res = validator()->validation('time', '12', validator::HOUR_ONLY);
        $this->assertTrue($res);
        $res = validator()->validation('time', '12:0624', validator::HOUR_TO_SECOND);
        $this->assertFalse($res);


        $res = validator()->validation('time', '25:06:24', validator::HOUR_TO_SECOND);
        $this->assertFalse($res);
        $res = validator()->validation('time', '25:06', validator::HOUR_TO_MINUTE);
        $this->assertFalse($res);
        $res = validator()->validation('time', '25', validator::HOUR_ONLY);
        $this->assertFalse($res);

        $res = validator()->validation('time', '250624', validator::HOUR_TO_SECOND);
        $this->assertFalse($res);
        $res = validator()->validation('time', '2506', validator::HOUR_TO_MINUTE);
        $this->assertFalse($res);
        $res = validator()->validation('time', '25', validator::HOUR_ONLY);
        $this->assertFalse($res);

        $res = validator()->validation('time', array('hour' => '12', 'minute' => '01', 'second' => '29'),  array('hour' => 'hour', 'minute' => 'minute', 'second' => 'second'));
        $this->assertTrue($res);
        $res = validator()->validation('time', array('hour' => '12', 'minute' => '01', 'second' => '90'),  array('hour' => 'year', 'minute' => 'minute', 'second' => 'second'));
        $this->assertFalse($res);
        $e = null;
        try{
            $res = validator()->validation('time', array('hour' => '12', 'minute' => '01', 'second' => '29'),  array('hour' => 'hour', 'second' => 'second'));
        } catch (exception $e) {

        }
        $this->assertInstanceOf('EnviException', $e);


        $e = null;
        try{
            $res = validator()->validation('time', '25', 123);
            $this->assertFalse($res);
        } catch (exception $e) {

        }
        $this->assertInstanceOf('EnviException', $e);
    }


    public function maxbrTest()
    {
        $res = validator()->validation('maxbr', "aaa\naaaaa", 10);
        $this->assertTrue($res);
        $res = validator()->validation("maxbr", "aaa\naaa\naaa\naaa\naaa\naaa\naaa\naaa\naaa\naaa", 10);
        $this->assertTrue($res);
        $res = validator()->validation("maxbr", "aaa\naaa\naaa\n", 2);
        $this->assertFalse($res);


        $res = validator()->validation('maxbr', array('foo' => 'bar'), 10);
        $this->assertFalse($res);
    }

    public function minbrTest()
    {
        $res = validator()->validation('minbr', "aaa\naaaaa", 10);
        $this->assertFalse($res);
        $res = validator()->validation("minbr", "aaa\naaa\naaa\naaa\naaa\naaa\naaa\naaa\naaa\naaa", 10);
        $this->assertTrue($res);
        $res = validator()->validation("minbr", "aaa\naaa\naaa\n", 2);
        $this->assertTrue($res);
        $res = validator()->validation('minbr', array('foo' => 'bar'), 10);
        $this->assertFalse($res);
    }



    public function maxlenTest()
    {
        $res = validator()->validation('maxlen', "aaa", 10);
        $this->assertTrue($res);
        $res = validator()->validation("maxlen", "aaaaaaaaaa", 10);
        $this->assertTrue($res);
        $res = validator()->validation("maxlen", "aaaaaaaaaaa", 10);
        $this->assertFalse($res);


        $res = validator()->validation('maxlen', array('foo' => 'bar'), 10);
        $this->assertFalse($res);
    }

    public function minlenTest()
    {
        $res = validator()->validation('minlen', "aaa", 10);
        $this->assertFalse($res);
        $res = validator()->validation("minlen", "aaaaaaaaaa", 10);
        $this->assertTrue($res);
        $res = validator()->validation("minlen", "aaaaaaaaaaa", 10);
        $this->assertTrue($res);
        $res = validator()->validation('minlen', array('foo' => 'bar'), 10);
        $this->assertFalse($res);
    }


    public function eregTest()
    {
        $res = validator()->validation('ereg', "aaa", 'aaa');
        $this->assertTrue($res);
        $res = validator()->validation('ereg', "aaa", 'baaa');
        $this->assertFalse($res);
        $res = validator()->validation('ereg', array('foo' => 'bar'), 'aaa');
        $this->assertFalse($res);
    }

    public function pregTest()
    {
        $res = validator()->validation('preg', "aaa", '/aaa/');
        $this->assertTrue($res);
        $res = validator()->validation('preg', "aaa", '/baaa/');
        $this->assertFalse($res);
        $res = validator()->validation('preg', array('foo' => 'bar'), 'aaa');
        $this->assertFalse($res);
    }

    public function fileTest()
    {
        $res = validator()->validation('file', __FILE__, NULL);
        $this->assertTrue($res);
        $res = validator()->validation('file', __FUNCTION__, NULL);
        $this->assertFalse($res);
        $res = validator()->validation('file', array('foo' => 'bar'), 10);
        $this->assertFalse($res);
    }

    public function dirpathTest()
    {
        $res = validator()->validation('dirpath', dirname(__FILE__), dirname(dirname(__FILE__)));
        $this->assertTrue($res);
        $res = validator()->validation('dirpath', __FILE__, dirname(dirname(__FILE__)));
        $this->assertFalse($res);
        $res = validator()->validation('dirpath', array('foo' => 'bar'), dirname(dirname(__FILE__)));
        $this->assertFalse($res);
    }

    public function arrayTest()
    {
        $res = validator()->validation('array', array('aaaaa'), NULL);
        $this->assertTrue($res);
        $res = validator()->validation('array', 'aaaaa', NULL);
        $this->assertFalse($res);
    }


    public function arraykeyexistsTest()
    {
        $res = validator()->validation('arraykeyexists', array('aaaaa' => 'aaaaa'), 'aaaaa');
        $this->assertTrue($res);
        $res = validator()->validation('arraykeyexists', array('aaaaa' => 'aaaaa'), 'bbbbb');
        $this->assertFalse($res);
        $res = validator()->validation('arraykeyexists', array('aaaaa' => 'aaaaa'), array('aaaaa'));
        $this->assertTrue($res);
        $res = validator()->validation('arraykeyexists', array('aaaaa' => 'aaaaa'), array('aaaaa', 'bbbbb'));
        $this->assertFalse($res);
        $res = validator()->validation('arraykeyexists', 'aaaaa', 'bbbbb');
        $this->assertFalse($res);
    }

    public function arraynumberTest()
    {
        $res = validator()->validation('arraynumber', array('123456', '123456', '123456', ), NULL);
        $this->assertTrue($res);
        $res = validator()->validation('arraynumber', array('123456', '123456', '1aaaa23456', ), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('arraynumber', 'aaaaa', NULL);
        $this->assertFalse($res);
    }
    public function arrayuniqueTest()
    {
        $res = validator()->validation('arrayunique', array('123456', '1234567', '1234568', '', '', ), true);
        $this->assertTrue($res);

        $res = validator()->validation('arrayunique', array('123456', '1234567', '1234568', ), true);
        $this->assertTrue($res);
        $res = validator()->validation('arrayunique', array('123456', '123456', '1aaaa23456', ), true);
        $this->assertFalse($res);

        $res = validator()->validation('arrayunique', array('123456', '1234567', '1234568', '', '', ), false);
        $this->assertFalse($res);
        $res = validator()->validation('arrayunique', 'aaaaa', true);
        $this->assertFalse($res);
    }

    public function arraynumbermaxTest()
    {
        $res = validator()->validation('arraynumbermax', array('123456', '123456', '123456', ), '999999');
        $this->assertTrue($res);
        $res = validator()->validation('arraynumbermax', array('123456', '123456', '123456', ), '123');
        $this->assertFalse($res);
        $res = validator()->validation('arraynumbermax', array('123456', '123456', '1aaaa23456', ), '999999');
        $this->assertFalse($res);
        $res = validator()->validation('arraynumbermax', 'aaaaa', '999999');
        $this->assertFalse($res);
    }

    public function arraynumberminTest()
    {
        $res = validator()->validation('arraynumbermin', array('123456', '123456', '123456', ), '999999');
        $this->assertFalse($res);
        $res = validator()->validation('arraynumbermin', array('123456', '123456', '123456', ), '123');
        $this->assertTrue($res);
        $res = validator()->validation('arraynumbermin', array('123456', '123456', '1aaaa23456', ), '999999');
        $this->assertFalse($res);
        $res = validator()->validation('arraynumbermin', 'aaaaa', '999999');
        $this->assertFalse($res);
    }

    public function arraycountmaxTest()
    {
        $res = validator()->validation('arraycountmax', array('123456', '123456', '123456', ), 3);
        $this->assertTrue($res);
        $res = validator()->validation('arraycountmax', array('123456', '123456', '123456', ), 2);
        $this->assertFalse($res);
        $res = validator()->validation('arraycountmax', 'aaaaa', '999999');
        $this->assertFalse($res);
    }

    public function arraycountminTest()
    {
        $res = validator()->validation('arraycountmin', array('123456', '123456', '123456', ), 3);
        $this->assertTrue($res);
        $res = validator()->validation('arraycountmin', array('123456', '123456', '123456', ), 2);
        $this->assertTrue($res);
        $res = validator()->validation('arraycountmin', 'aaaaa', '999999');
        $this->assertFalse($res);
    }

    public function notarrayTest()
    {
        $res = validator()->validation('notarray', array('aaaaa'), NULL);
        $this->assertFalse($res);
        $res = validator()->validation('notarray', 'aaaaa', NULL);
        $this->assertTrue($res);
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @test
     */
    public function _getValidationData()
    {
        $_POST['aaaa'] = ' test ';
        $_GET['aaa'] = ' test ';
        $res = $this->call(validator(), '_getValidationData', array('aaaa', true, true));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('aaa', true, false));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('aaa', true, true));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);

        $res = $this->call(validator(), '_getValidationData', array('aaaa', true, validator::METHOD_POST|validator::METHOD_GET));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('aaaa', true, validator::METHOD_POST));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('aaaa', true, validator::METHOD_GET));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);

        $res = $this->call(validator(), '_getValidationData', array('aaa', true, validator::METHOD_GET));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('aaa', true, validator::METHOD_POST|validator::METHOD_GET));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('aaa', true, validator::METHOD_POST));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);

        $_POST['bbbb']['cccc'] = ' test ';
        $_GET['dddd']['dddd']  = ' test ';
        $_GET['ffff']['asdf']['0']  = ' test ';
        $_GET['ffff']['asdf']['1']  = ' test ';
        $_GET['ffff']['ffffff'] = array();
        $res = $this->call(validator(), '_getValidationData', array('bbbb[cccc]', true, true));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('dddd[dddd]', true, false));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('dddd[dddd]', true, true));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);

        $res = $this->call(validator(), '_getValidationData', array('bbbb[cccc]', true, validator::METHOD_POST|validator::METHOD_GET));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('bbbb[cccc]', true, validator::METHOD_POST));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('bbbb[cccc]', true, validator::METHOD_GET));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);

        $res = $this->call(validator(), '_getValidationData', array('dddd[dddd]', true, validator::METHOD_GET));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('dddd[dddd]', true, validator::METHOD_POST|validator::METHOD_GET));
        $this->assertEquals($res, 'test');

        $res = $this->call(validator(), '_getValidationData', array('dddd[dddd]', true, validator::METHOD_POST));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);

        $res = $this->call(validator(), '_getValidationData', array('dddd[dddd]', true, validator::METHOD_POST));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);

        $res = $this->call(validator(), '_getValidationData', array('ffff[asdf][0]', true, validator::METHOD_POST));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);
        $res = $this->call(validator(), '_getValidationData', array('ffff[asdf][1]', true, validator::METHOD_POST));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);
        $res = $this->call(validator(), '_getValidationData', array('ffff[asdf][2]', true, validator::METHOD_POST));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);
        $res = $this->call(validator(), '_getValidationData', array('ffff[asdfa][2]', true, validator::METHOD_POST));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);


        $res = $this->call(validator(), '_getValidationData', array('ffff[asdf][0]', true, validator::METHOD_GET));
        $this->assertEquals($res, 'test');
        $res = $this->call(validator(), '_getValidationData', array('ffff[asdf][1]', true, validator::METHOD_GET));
        $this->assertEquals($res, 'test');
        $res = $this->call(validator(), '_getValidationData', array('ffff[asdf][2]', true, validator::METHOD_GET));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);
        $res = $this->call(validator(), '_getValidationData', array('ffff[asdfa][2]', true, validator::METHOD_GET));
        $this->assertNotEquals($res, 'test');
        $this->assertEquals($res, false);

        $res = $this->call(validator(), '_getValidationData', array('ffff[asdf]', true, validator::METHOD_GET));

        $res = $this->call(validator(), '_getValidationData', array('ffff[ffffff]', true, validator::METHOD_GET));
        $this->assertEquals($res, array());
   }
   /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @return      void
     * @test
     */
    public function _trimmer()
    {
        $res = array();
        $res = $this->call(validator(), '_trimmer', array($res));
        $this->assertEquals($res, array());
        $res = '  test';
        $res = $this->call(validator(), '_trimmer', array($res));
        $this->assertEquals($res, 'test');
        $res = array('  test');
        $res = $this->call(validator(), '_trimmer', array($res));
        $this->assertEquals($res, array('test'));
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @test
     */
    public function registerValidators()
    {
        $validator = clone validator();
        $validator->registerValidators('simple_function', 'registerSample');
        $res = $validator->registerValidators('simple_function', 'registerSample');
        $this->assertEquals($res, 'registerSample');

        $validator->registerValidators('simple_method', array($this, 'registerSample'), 'エラーメッセージ登録');
        $res = $validator->registerValidators('simple_method', array($this, 'registerSample'));
        $this->assertArray($res);
        $validator->registerValidators('simple_closure', function ($data, $param) {return true;});
        $res = $validator->registerValidators('simple_closure', 'registerSample');
        $this->assertInstanceOf('Closure', $res);

        $e = null;
        try{
            $validator->registerValidators('simple_function2', 'registerSample2');
        } catch (exception $e) {
        }
        $this->assertInstanceOf('EnviException', $e);

        $res = $validator->validation('simple_function', array('123456', '123456', '123456', ), '999999');
        $this->assertTrue($res);

        $res = $validator->validation('simple_method', array('123456', '123456', '123456', ), '999999');
        $this->assertFalse($res);

        $res = $validator->validation('simple_closure', array('123456', '123456', '123456', ), '999999');
        $this->assertTrue($res);


        return $validator;
    }

    public function registerSample($data, $param)
    {
        return false;
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @test
     * @depends     registerValidators
     */
    public function setChainFormat($validator)
    {
        $res = $validator->setChainFormat('registers', 'simple_function', 'AUTO', true, false);
        $this->assertArray($res);
        $res = $validator->setChainFormat('registers', 'simple_closure', '2', true, false);
        $this->assertArray($res);

        return $validator;
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @test
     * @depends     setChainFormat
     */
    public function autoPrepare($validator)
    {
        $_POST['id'] = '13456';
        $_POST['name'] = 'あいうえお';
        $_POST['subject'] = 'sage';
        $_POST['passwd'] = '123456789aaa';


        $validator->autoPrepare('id', 'noblank', true, false, validator::METHOD_POST);
        $validation_setting = $validator->getValidationSetting('id');
        $this->assertArray($validation_setting);
        $this->assertArrayHasKey('form', $validation_setting);
        $this->assertEquals($validation_setting['form'], 'id');
        $this->assertArrayHasKey('data', $validation_setting);
        $this->assertEquals($validation_setting['data'], '13456');
        $this->assertArrayHasKey('EnviValidator', $validation_setting);
        $this->assertArrayHasKey(0, $validation_setting['EnviValidator']);
        $this->assertArrayHasKey('noblank', $validation_setting['EnviValidator'][0]);
        $this->assertArrayHasKey('mode', $validation_setting['EnviValidator'][0]['noblank']);
        $this->assertEquals($validation_setting['EnviValidator'][0]['noblank']['mode'], false);
        $this->assertArrayHasKey('chain', $validation_setting['EnviValidator'][0]['noblank']);
        $this->assertEquals($validation_setting['EnviValidator'][0]['noblank']['chain'], true);


        $validator->autoPrepare(array('name' => '名前'), 'noblank', true, false, validator::METHOD_POST);
        $validation_setting = $validator->getValidationSetting('name');
        $this->assertArray($validation_setting);
        $this->assertArrayHasKey('form', $validation_setting);
        $this->assertEquals($validation_setting['form'], '名前');
        $this->assertArrayHasKey('data', $validation_setting);
        $this->assertEquals($validation_setting['data'], 'あいうえお');
        $this->assertArrayHasKey('EnviValidator', $validation_setting);
        $this->assertArrayHasKey(0, $validation_setting['EnviValidator']);
        $this->assertArrayHasKey('noblank', $validation_setting['EnviValidator'][0]);
        $this->assertArrayHasKey('mode', $validation_setting['EnviValidator'][0]['noblank']);
        $this->assertEquals($validation_setting['EnviValidator'][0]['noblank']['mode'], false);
        $this->assertArrayHasKey('chain', $validation_setting['EnviValidator'][0]['noblank']);
        $this->assertEquals($validation_setting['EnviValidator'][0]['noblank']['chain'], true);



        $validator->autoPrepare('subject', 'noblank', true, false, validator::METHOD_POST|validator::METHOD_GET);
        $validation_setting = $validator->getValidationSetting('subject');
        $this->assertEquals($validation_setting['data'], 'sage');


        $this->assertArray($validation_setting);
        $validator->autoPrepare(array('body' => '本文'), 'notarray', true, false, validator::METHOD_POST);
        $validation_setting = $validator->getValidationSetting('body');
        $this->assertEquals($validation_setting['data'], false);
        $this->assertArray($validation_setting);
        $this->assertArray($validation_setting);

        $validator->autoPrepare(array('passwd' => 'パスワード'), $validator->getChainFormat('registers'), true, false, validator::METHOD_POST);
        $validation_setting = $validator->getValidationSetting('body');
        $this->assertEquals($validation_setting['data'], false);
        $this->assertArray($validation_setting);

        $e = null;
        try{
            $validator->autoPrepare(array('passwd2' => 'パスワード2'), 'hogehoge', true, false, validator::METHOD_POST);;
        } catch (exception $e) {
        }
        $this->assertInstanceOf('EnviException', $e);


        return $validator;
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @depends     autoPrepare
     * @test
     */
    public function chain($validator)
    {
        $_POST['email'] = 'aaaaap@example.jp';
        $validator->chain('id', 'maxwidth', false, 10);
        $validation_setting = $validator->getValidationSetting('id');
        $this->assertArrayHasKey(1, $validation_setting['EnviValidator']);
        $this->assertArrayHasKey('maxwidth', $validation_setting['EnviValidator'][1]);
        $this->assertArrayHasKey('mode', $validation_setting['EnviValidator'][1]['maxwidth']);
        $this->assertEquals($validation_setting['EnviValidator'][1]['maxwidth']['mode'], 10);
        $this->assertArrayHasKey('chain', $validation_setting['EnviValidator'][1]['maxwidth']);
        $this->assertEquals($validation_setting['EnviValidator'][1]['maxwidth']['chain'], false);

        $validator->chain(array('id' => 'id'), 'naturalnumber', true);
        $validation_setting = $validator->getValidationSetting('id');
         $this->assertEquals($validation_setting['EnviValidator'][2]['naturalnumber']['chain'], true);

        $validator->chain(array('email' => 'E-mail'), 'noblank', true);
        $validation_setting = $validator->getValidationSetting('email');
        $this->assertArrayHasKey(0, $validation_setting['EnviValidator']);

        return $validator;
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @depends     chain
     * @test
     */
    public function executeAll($validator)
    {
        $res = array();
        $res['success'] = $validator->executeAll();
        $this->assertArray($res);
        $validator->chain('body', 'noblank', true);
        $res['error'] = $validator->executeAll();
        $this->assertInstanceOf('ValidatorError', $res['error']);
        $this->assertNotInstanceOf('Error', $res['error']);
        $validator->unchain('body', 'noblank');
        return $res;
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @depends     chain
     * @test
     */
    public function execute($validator)
    {
        $res = $validator->execute(array('id' => 'id'));
        $this->assertFalse(validator()->isError($res));
        $res = $validator->execute('name');
        $this->assertFalse(validator()->isError($res));
        $res = $validator->chain('body', 'noblank', false);
        $this->assertFalse(validator()->isError($res));
        $res = $validator->execute('body');
        $this->assertTrue(validator()->isError($res));
        $e = null;
        try{
            $validator->execute(array('id', 'name'));
        } catch (exception $e) {
        }
        $this->assertInstanceOf('EnviException', $e);
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @depends     executeAll
     * @test
     */
    public function isError($res_array)
    {
        $this->assertTrue(validator()->isError($res_array['error']));
        $this->assertFalse(validator()->isError($res_array['success']));
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @depends     chain
     * @test
     */
    public function unchain($validator)
    {
        $validation_setting = $validator->getValidationSetting('body');
        $validator->unchain('body', 'noblank');
        $validation_setting2 = $validator->getValidationSetting('body');
        $this->assertNotEquals($validation_setting, $validation_setting2);
        $validation_setting = $validator->getValidationSetting('body');
        $validator->unchain('body', 'noblank');
        $validation_setting2 = $validator->getValidationSetting('body');
        $this->assertEquals($validation_setting, $validation_setting2);
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @depends     chain
     * @test
     */
    public function freeTest($validator)
    {
        $validator->free();
        $error = $validator->error();
        $e = null;
        try{
            $validator->execute('id');
        } catch (exception $e) {
        }
        $this->assertInstanceOf('EnviException', $e);
        $validator->setErrorObject($error);
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @test
     */
    public function setEmptyFormData()
    {
        $validator = validator();
        $validator->setEmptyFormData(123456);
        $validator->free();
        $validator->autoPrepare(array('body2' => '本文'), 'blank', true, false, validator::METHOD_POST);
        $validation_setting = $validator->getValidationSetting('body2');
        $this->assertEquals($validation_setting['data'], 123456);
        $this->assertArray($validation_setting);
        $validator->setEmptyFormData(false);
        $validator->execute('body2');
    }

    /**
     * +-- 終了処理
     *
     * @access public
     * @return void
     */
    public function shutdown()
    {
        $_POST = array();
        $_GET  = array();
    }
}

function registerSample($data, $param)
{
    return true;
}