<?php
/**
 * PropelPDO風のオブジェクトを作成するベースクラス
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
 * PropelPDO風のオブジェクトを作成するベースクラス
 *
 * @abstract
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class Base%%class_name%% extends OrMapBase
{

    protected $default_instance_name = '%%instance_name%%';

    /**
     * +-- コンストラクタ
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->table_name = '%%table_name%%';
        $this->pkeys      = array(%%pkeys%%);
        $this->_is_modify = true;
        $this->_from_hydrate = %%default_array%%;
        $this->to_save       = %%default_array%%;
    }
    /* ----------------------------------------- */


%%getter_setter%%

%%enable_magic%%

}