<?php
/**
 * @package Envi3
 * @subpackage EnviMVCCore
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 * DI登録されたエクステンションのロード
 *
 * extention()->エクステンション名()<br />
 * でオブジェクトを取得できます。
 *
 * @package Envi3
 * @subpackage EnviMVCCore
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

class extension
{
    private $configuration;
    private $extensions;
    private static $instance;

    /**
     * +-- コンストラクタ
     *
     * @access private
     * @params  $configuration
     * @return void
     */
    private function __construct($configuration)
    {
        $this->configuration = $configuration;
        foreach ($configuration as $name => $v) {
            if (!$v['constant']) {
                continue;
            }
            $class_name = $v['class']['class_name'];
            $this->extensions[$name] = new $class_name(Envi::singleton()->parseYml(basename($v['router']['resource']), dirname($v['router']['resource']).DIRECTORY_SEPARATOR));
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- エクステンションのオブジェクト取得(magicmethod)
     *
     * @access public
     * @params  $name
     * @params  $arguments
     * @return object
     */
    public function __call($name, $arguments)
    {
        if (!isset($this->configuration[$name])) {
            throw new EnviException($name.' extensionが見つかりませんでした');
        }
        $class_name = $this->configuration[$name]['class']['class_name'];

        if (!isset($this->configuration[$name]['class']['singleton']) || !$this->configuration[$name]['class']['singleton']) {
            if (!isset($this->extensions[$name])) {
                include_once $this->configuration[$name]['class']['resource'];
                $this->extensions[$name] = array();
            }
            $c = count($this->extensions[$name]);
            $this->extensions[$name][$c] = $class_name(Envi::singleton()->parseYml(basename($this->configuration[$name]['router']['resource']), dirname($this->configuration[$name]['router']['resource']).DIRECTORY_SEPARATOR));
            return $this->extensions[$name][$c];
        } elseif (!isset($this->extensions[$name])) {
            include_once $this->configuration[$name]['class']['resource'];
            $this->extensions[$name] = new $class_name(Envi::singleton()->parseYml(basename($this->configuration[$name]['router']['resource']), dirname($this->configuration[$name]['router']['resource']).DIRECTORY_SEPARATOR));
        }
        return $this->extensions[$name];
    }
    /* ----------------------------------------- */

    /**
     * +-- メインのAction実行が完了したタイミングで、暗黙的に実行されるMethodを実行
     *
     * @access public
     * @return void
     */
    public function executeLastShutdownMethod()
    {
        foreach ($this->extensions as $name => $val) {
            $shutdownMethod = false;
            if (isset($this->configuration[$name]['class']['lastShutdownMethod'])) {
                $shutdownMethod = $this->configuration[$name]['class']['lastShutdownMethod'];
            }
            if (!$shutdownMethod) {
                continue;
            }
            if (is_array($val)) {
                foreach ($val as $obj) {
                    $obj->$shutdownMethod();
                }
            } else {
                $val->$shutdownMethod();
            }
        }
    }
    /* ----------------------------------------- */

    public static function _singleton($configuration = NULL)
    {
        if (!isset(self::$instance)) {
            self::$instance = new extension($configuration);
        }
        return self::$instance;
    }

}


function extension()
{
    return extension::_singleton();
}