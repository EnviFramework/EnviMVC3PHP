<?php
/**
 * @package Envi3
 * @subpackage
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */


/**
 * @package Envi3
 * @subpackage View基底クラス
 * @abstract
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
abstract class Envi_ViewBase
{
    public $renderer;


    public function __construct()
    {
    }

    /**
     * @abstract
     */
    public function initialize()
    {
        return true;
    }

    /**
     * @abstract
     */
    public function execute()
    {
        return true;
    }


    /**
     * @abstract
     */
    public function setRenderer()
    {
    }
}
