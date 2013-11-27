<?php
/**
 * �e�X�g�̃x�[�X�N���X
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */

define('APPLICATION_BASE', dirname(__FILE__).DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR);
define('APP_BASE', dirname(__FILE__).DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'ut'.DIRECTORY_SEPARATOR);
define('T_ENVI_BASE', dirname(__FILE__).DIRECTORY_SEPARATOR.'../../envi3/');

/**
 * �e�X�g�̃x�[�X�N���X
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */
class testCaseBase extends EnviTestCase
{

    /**
     * +-- �R���X�g���N�^
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }
    /* ----------------------------------------- */

    /**
     * +-- ������
     *
     * @access public
     * @return void
     */
    public function initialize()
    {
    }
    /* ----------------------------------------- */


    /**
     * +-- �I������������
     *
     * @access public
     * @return void
     */
    public function shutdown()
    {
    }
    /* ----------------------------------------- */


}

