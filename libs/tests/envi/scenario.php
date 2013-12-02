<?php
/**
 * �e�X�g��Scenario�N���X
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

$scenario_dir = dirname(__FILE__).DIRECTORY_SEPARATOR;
define('ENVI_TEST_YML', basename(dirname(__FILE__)).'.yml');

require_once dirname(__FILE__).'/../../envi3/test/EnviTest.php';
require_once dirname(__FILE__).'/testCaseBase.php';

/**
 * �e�X�g��Scenario�N���X
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
class Scenario extends EnviTestScenario
{
    public static $stack_data;

    /**
     * +-- �f�[�^�X�^�b�N�p
     *
     * @access public
     * @static
     * @param  $k
     * @param  $v
     * @return void
     */
    public static function setAttribute($k, $v)
    {
        self::$stack_data[$k] = $v;
    }
    /* ----------------------------------------- */

    /**
     * +-- �X�^�b�N�����f�[�^���擾����p
     *
     * @access public
     * @static
     * @param  $k
     * @return void
     */
    public static function getAttribute($k)
    {
        return isset(self::$stack_data[$k]) ? self::$stack_data[$k] : NULL;
    }
    /* ----------------------------------------- */

    /**
     * +-- ���s����e�X�g�̔z���Yaml����Ԃ�
     *
     * @access public
     * @return array
     */
    public function execute()
    {
        if (isOption('--auto')) {
            return parent::execute();
        }
        $arr = array();
        if (!isOption('-s')) {
            foreach ($this->system_conf['scenario']['dirs'] as $dir_name) {
                $arr = $this->getTestByDir($dir_name, 1, $arr);
            }
        } else {
            foreach (explode(',', getOption('-s')) as $dir_name) {
                $arr = $this->getTestByDir($this->system_conf['scenario']['dirs'][$dir_name], 1, $arr);
            }
        }
        if (isOption('-t')) {
            $sub_arr = array();
            foreach ($arr as $val) {
                foreach (explode(',', getOption('-t')) as $class_name) {
                    if ($val['class_name'] === $class_name) {
                        $sub_arr[] = $val;
                    }
                }
            }
            return $sub_arr;
        }
        return $arr;
    }
    /* ----------------------------------------- */

}
