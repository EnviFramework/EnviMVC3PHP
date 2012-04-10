<?php
/**
 * @package Envi3
 * @subpackage EnviMVCCore
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */


/**
 * @package Envi3
 * @subpackage EnviMVCCore
 * @abstract
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
abstract class EnviViewBase
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
