<?php
/**
 *
 *
 *
 * PHP versions 5
 *
 *

 *
 * @category   テスト
 * @package    テスト
 * @subpackage TestCode
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */


/**
 *
 *
 *
 *
 * @category   テスト
 * @package    テスト
 * @subpackage TestCode
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */
class EnviMathTest extends testCaseBase
{
    /**
     * +-- 初期化
     *
     * @access public
     * @return void
     */
    public function initialize()
    {
        include_once dirname(__FILE__).'/../../../envi3/EnviMath.php';
        $this->free();
    }
    /* ----------------------------------------- */

    /**
     * +-- 端数の切り上げ
     *
     * 端数の切り上げ
     *
     * @access public
     * @static
     * @param float $value
     * @return float
     */
    public function ceilTest()
    {
        $this->assertEquals(EnviMath::ceil('2.1'), ceil(2.1));
        $this->assertEquals(EnviMath::ceil('2.2'), ceil(2.2));
        $this->assertEquals(EnviMath::ceil('2.3'), ceil(2.3));
        $this->assertEquals(EnviMath::ceil('2.4'), ceil(2.4));
        $this->assertEquals(EnviMath::ceil('2.5'), ceil(2.5));
        $this->assertEquals(EnviMath::ceil('2.6'), ceil(2.6));
        $this->assertEquals(EnviMath::ceil('2.7'), ceil(2.7));
        $this->assertEquals(EnviMath::ceil('2.8'), ceil(2.8));
        $this->assertEquals(EnviMath::ceil('2.9'), ceil(2.9));
        $this->assertEquals(EnviMath::ceil('2.7'), 3);
    }
    /* ----------------------------------------- */

    /**
     * +-- 端数の切り捨て
     *
     * @access public
     * @static
     * @param float $value
     * @return float
     */
    public function floorTest()
    {
        $this->assertEquals(EnviMath::floor('2.1'), floor(2.1));
        $this->assertEquals(EnviMath::floor('2.2'), floor(2.2));
        $this->assertEquals(EnviMath::floor('2.3'), floor(2.3));
        $this->assertEquals(EnviMath::floor('2.4'), floor(2.4));
        $this->assertEquals(EnviMath::floor('2.5'), floor(2.5));
        $this->assertEquals(EnviMath::floor('2.6'), floor(2.6));
        $this->assertEquals(EnviMath::floor('2.7'), floor(2.7));
        $this->assertEquals(EnviMath::floor('2.8'), floor(2.8));
        $this->assertEquals(EnviMath::floor('2.9'), floor(2.9));
        $this->assertEquals(EnviMath::floor('2.7'), 2);
    }
    /* ----------------------------------------- */


    /**
     * +-- 浮動小数点数を丸める
     *
     * @access public
     * @static
     * @param float $value
     * @param integer $precision OPTIONAL:0
     * @param integer $mode OPTIONAL:PHP_ROUND_HALF_UP
     * @return float
     */
    public function roundTest()
    {
        $this->assertEquals(EnviMath::round('2.1'), round(2.1));
        $this->assertEquals(EnviMath::round('2.2'), round(2.2));
        $this->assertEquals(EnviMath::round('2.3'), round(2.3));
        $this->assertEquals(EnviMath::round('2.4'), round(2.4));
        $this->assertEquals(EnviMath::round('2.5'), round(2.5));
        $this->assertEquals(EnviMath::round('2.6'), round(2.6));
        $this->assertEquals(EnviMath::round('2.7'), round(2.7));
        $this->assertEquals(EnviMath::round('2.8'), round(2.8));
        $this->assertEquals(EnviMath::round('2.9'), round(2.9));
        $this->assertEquals(EnviMath::round('2.7'), 3);
        $this->assertEquals(EnviMath::round('2.4'), 2);
    }
    /* ----------------------------------------- */
    /**
     * +-- 終了処理
     *
     * @access public
     * @return void
     */
    public function shutdown()
    {
    }

}
