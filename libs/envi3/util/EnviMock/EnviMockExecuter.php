<?php
/**
 * モック内部の実行クラス
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
 * @doc_ignore
 */


/**
 * モック内部の実行クラス
 *
 *
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
 * @doc_ignore
 */
class EnviMockExecuter
{
    private $class_name;
    private $method_name;
    private $arguments;

    /**
     * +-- モックメソッドの実行本体
     *
     * @access      public
     * @param       string $aa
     * @param       string $method_name
     * @param       array $arguments
     * @return      mixed
     */
    public function execute($class_name, $method_name, $arguments, $_this)
    {
        $this->class_name  = $class_name;
        $this->method_name = $method_name;
        $this->arguments   = $arguments;
        if ($this->getContainer('is_should_receive')) {
            $this->setProcess();
            $execute_count = $this->incrementExecuteCount();
            $this->maxExecutionLimitedCheck($execute_count);
            $this->argumentsCheck($execute_count);
        }
        if ($this->getContainer('no_bypass', false)) {
            return $this->mockEditor()->executeDefaultMethod($this->method_name, $_this, $arguments);
        } elseif ($this->getContainer('return_is_throw', false)) {
            // exception
            if (is_string($this->getContainer('return_values'))) {
                throw new $this->getContainer('return_values');
            } else {
                throw $this->getContainer('return_values');
            }
        } elseif ($this->getContainer('return_is_augment', false)) {
            // 引数
            return isset($augments[$this->getContainer('return_values')]) ? $augments[$this->getContainer('return_values')] : NULL;
        } elseif ($this->getContainer('return_is_augment_all', false)) {
            // 引数
            return $augments;
        } elseif ($this->getContainer('return_is_callback', false)) {
            // 関数の実行
            return call_user_func_array($this->getContainer('return_values'), $arguments);
        } elseif ($this->getContainer('return_is_consecutive', false)) {
            // consecutive
            $map = $this->getContainer('return_values');
            $maxkey = count($map) - 1;
            $key = $execute_count%$maxkey;
            return $map[$key];
        } elseif ($this->getContainer('return_is_map', false)) {
            // map
            $map = $this->getContainer('return_values');
            foreach ($map as $val) {
                if ($arguments === $val['arguments']) {
                    return $val['return_value'];
                }
            }
            return NULL;
        }
        return $this->getContainer('return_values', NULL);
    }
    /* ----------------------------------------- */


    /**
     * +-- Assertion毎に毎回実行される
     *
     * @access      public
     * @param       any $class_name
     * @param       any $method_name
     * @return      void
     */
    public function assertionExecuteAfter($class_name, $method_name)
    {
        $this->class_name  = $class_name;
        $this->method_name = $method_name;
        if (!$this->getContainer('is_should_receive')) {
            return;
        }
        $this->minExecutionLimitedCheck($this->getExecuteCount());
        if (!$this->getContainer('execution_count_pooling', false)) {
            $this->setExecuteCount(0);
        }
        if (!$this->getContainer('is_auto_recycle', false)) {
            $this->setContainer('is_should_receive', false);
            // スタブされたメソッドを元に戻す
            if ($this->mockEditor()->isStab($method_name) && $this->getContainer('is_auto_restore', false)) {
                $this->mockEditor()->restoreMethod($method_name);
            }
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- 最大実行回数制限の確認
     *
     * @access      private
     * @param       integer $execute_count 今の実行回数
     * @return      boolean
     */
    private function maxExecutionLimitedCheck($execute_count)
    {
        $times_check = $this->getContainer('max_limit_times');
        if ($times_check === false) {
            return true;
        } elseif ($times_check >= $execute_count) {
            return true;
        }
        $e = new EnviMockMaxExecutionCountException;
        $e->setLimitClass($this->class_name);
        $e->setLimitMethod($this->method_name);
        $e->setExecutionCount($execute_count);
        $e->setTimes($times_check);
        throw $e;
    }
    /* ----------------------------------------- */


    /**
     * +-- 最小実行回数制限の確認
     *
     * @access      private
     * @param       integer $execute_count 今の実行回数
     * @return      boolean
     */
    private function minExecutionLimitedCheck($execute_count)
    {
        $times_check = $this->getContainer('min_limit_times');
        if ($times_check === false) {
            return true;
        } elseif ($times_check <= $execute_count) {
            return true;
        }
        $e = new EnviMockMinExecutionCountException;
        $e->setLimitClass($this->class_name);
        $e->setLimitMethod($this->method_name);
        $e->setExecutionCount($execute_count);
        $e->setTimes($times_check);
        throw $e;
    }
    /* ----------------------------------------- */

    private function argumentsCheck($execute_count)
    {
        $with_by_times = $this->getContainer('with_by_times', array());
        $error = array();
        if (isset($with_by_times[$execute_count])) {
            if ($with_by_times[$execute_count] === false) {
                return true;
            }
            if ($with_by_times[$execute_count] === $this->arguments) {
                return true;
            }
            $error = $with_by_times[$execute_count];
        } else {
            $with = $this->getContainer('with', false);
            if ($with === false) {
                return true;
            }elseif ($with === $this->arguments) {
                return true;
            }
            $error = $with;
        }

        $e = new EnviMockArgumentException;
        $e->setLimitClass($this->class_name);
        $e->setLimitMethod($this->method_name);
        $e->setExecutionCount($execute_count);
        $e->setArgument(array($this->arguments, $error));
        throw $e;
    }

    private function incrementExecuteCount()
    {
        $res = $this->getExecuteCount() + 1;
        $this->setExecuteCount($res);
        return $res;
    }


    private function getExecuteCount()
    {
        return $this->getContainer('execute_count', 0);
    }

    private function &mockEditor()
    {
        return EnviMockContainer::singleton()->getEditor($this->class_name, $this->method_name);
    }


    private function setExecuteCount($n)
    {
        return $this->setContainer('execute_count', $n);
    }

    private function setContainer($setter_key, $setter_value)
    {
        EnviMockContainer::singleton()->setAttribute($this->class_name, $this->method_name, $setter_key, $setter_value);
    }

    private function getContainer($setter_key, $default_value = false)
    {
        return EnviMockContainer::singleton()->getAttribute($this->class_name, $this->method_name, $setter_key, $default_value);
    }

    private function setProcess()
    {
        EnviMockContainer::singleton()->setProcess(
            $this->class_name,
            $this->method_name,
            $this->arguments
        );
    }
}

