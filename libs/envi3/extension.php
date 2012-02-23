<?php
/**
 * @package Envi3
 * @subpackage EnviMVCCore
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 * DI登録されたエクステンションのロード
 *
 * extention()->エクステンション名<br />
 * でオブジェクトを取得できます。
 *
 * @package Envi3
 * @subpackage EnviMVCCore
 * @sinse 0.1
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

    public function __call($name, $arguments)
    {
        if (!isset($this->extensions[$name]) && isset($this->configuration[$name])) {
            $class_name = $this->configuration[$name]['class']['class_name'];
            include_once $this->configuration[$name]['class']['resource'];
            if (!isset($this->configuration[$name]['class']['singleton']) || !$this->configuration[$name]['class']['singleton']) {
                return new $class_name(Envi::singleton()->parseYml(basename($this->configuration[$name]['router']['resource']), dirname($this->configuration[$name]['router']['resource']).DIRECTORY_SEPARATOR));
            }
            $this->extensions[$name] = new $class_name(Envi::singleton()->parseYml(basename($this->configuration[$name]['router']['resource']), dirname($this->configuration[$name]['router']['resource']).DIRECTORY_SEPARATOR));
        } elseif (!isset($this->extensions[$name])) {
            throw new EnviException('extensionが見つかりませんでした');
        }
        return $this->extensions[$name];
    }


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