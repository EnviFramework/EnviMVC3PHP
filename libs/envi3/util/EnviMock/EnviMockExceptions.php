<?php
/**
 * モッククラスの例外一覧
 *
 *
 * PHP versions 5
 *
 *
 * @category   自動テスト
 * @package    テストスタブ
 * @subpackage Mock
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 3.3.3.2
 */


/**
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage UnitTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 * @codeCoverageIgnore
 */
class EnviMockException extends exception
{
}
/* ----------------------------------------- */



/**
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage UnitTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 * @codeCoverageIgnore
 */
class EnviMockExecuteException extends EnviMockException
{
    public $execution_count;
    public $limit_class_name;
    public $limit_method_name;

    public function setExecutionCount($setter)
    {
        $this->execution_count = $setter;
    }
    public function setTimes($setter)
    {
        $this->times = $setter;
    }
    public function setLimitClass($setter)
    {
        $this->limit_class_name = $setter;
    }
    public function setLimitMethod($setter)
    {
        $this->limit_method_name = $setter;
    }
}
/* ----------------------------------------- */

/**
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage UnitTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 * @codeCoverageIgnore
 */
class EnviMockArgumentException extends EnviMockExecuteException
{
    public $argument;
    public function setArgument($setter)
    {
        $this->argument = $setter;
        $this->message = $this->limit_class_name.'::'.$this->limit_method_name.' augments error : '. json_encode($setter[0]) . ' : ' . json_encode($setter[1]);
    }
}
/* ----------------------------------------- */


/**
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage UnitTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 * @codeCoverageIgnore
 */
class EnviMockMaxExecutionCountException extends EnviMockExecuteException
{
    public $times;

    public function setTimes($setter)
    {
        $this->times = $setter;
        $this->message = $this->limit_class_name.'::'.$this->limit_method_name.' max execution count : '.$this->execution_count.' on '.$setter;
    }
}
/* ----------------------------------------- */



/**
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage UnitTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 * @codeCoverageIgnore
 */
class EnviMockMinExecutionCountException extends EnviMockMaxExecutionCountException
{
    public function setTimes($setter)
    {
        $this->times = $setter;
        $this->message = $this->limit_class_name.'::'.$this->limit_method_name.' min execution count : '.$this->execution_count.' on '.$setter;
    }
}
/* ----------------------------------------- */

