<?php
/**
 * DB����
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

/**
 * DI����Ă΂��N���X
 *
 * @package    Envi3
 * @category   MVC
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class DBInstance
{
    private $_system_conf;
    /**
     * +-- �R���X�g���N�^
     *
     * @access public
     * @param  $config
     * @return void
     */
    public function __construct($config)
    {
        $this->_system_conf = $config;
    }
    /* ----------------------------------------- */

    /**
     * +-- instance�̎擾
     *
     * @access public
     * @param  $db_key
     * @return DBIBase
     */
    public function getInstance($db_key)
    {
        if (!isset($this->_system_conf[$db_key])) {
            throw new EnviException("DB: {$db_key}�����݂��Ă܂���B");
        }
        return DB::getConnection($this->_system_conf[$db_key]['params'], $db_key);
    }
    /* ----------------------------------------- */
}