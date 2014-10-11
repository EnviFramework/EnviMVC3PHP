<?php
/**
 * Lessphpを使用するためのエクステンションクラス
 *
 * CSS拡張のLessコンパイラを使用するためのエクステンションです。
 *
 * http://leafo.net/lessphp
 *
 * を内部的に使用しています。
 *
 *
 * インストール・設定
 * --------------------------------------------------
 * envi install-extension {app_key} {DI設定ファイル} lessphp
 *
 * コマンドでインストール出来ます。
 *
 *
 *
 * PHP versions 5
 *
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage LessphpExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
*/

if (!class_exists('lessc', false)) {
    require dirname(__FILE__).DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'lessphp'.DIRECTORY_SEPARATOR.'lessc.inc.php';
}
/**
 *  Lessphpを使用するためのエクステンション
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage LessphpExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class EnviLessphpExtension
{
    private $system_conf;
    private $less_php;

    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @param       array $system_conf 設定
     * @return      void
     */
    public function __construct(array $system_conf)
    {
        $this->system_conf = $system_conf;
        $this->less_php = new lessc;
        if ($this->system_conf['format'] !== 'default') {
            $this->less_php->setFormatter($this->system_conf['format']);
        }
        if ($this->system_conf['preserve_comments']) {
            $this->less_php->setPreserveComments(true);
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- ファイルを指定してコンパイルする
     *
     * @access      public
     * @param       string $file_path ファイルパス
     * @param       string $compile_id コンパイルID OPTIONAL:NULL
     * @return      string
     */
    public function compileFile($file_path, $compile_id = NULL)
    {
        if (!is_file($file_path)) {
            throw new EnviLessphpExtensionException('not file : '.$file_path);
        }
        // cpu負荷節約
        $system_conf = $this->system_conf;
        if ($compile_id === NULL) {
            $compile_id = basename($file_path);
        }

        $compile_id .= '_'.$system_conf['file_version'];
        $cache_path = $system_conf['is_compile_cache'] ? $this->makeCachePath($compile_id) : NULL;
        $is_compile = $this->isCompile($cache_path);
        if (!$is_compile) {
            return file_get_contents($cache_path);
        }
        $out = $this->less_php->compileFile($file_path);
        $this->saveCache($cache_path, $out);
        return $out;
    }
    /* ----------------------------------------- */

    /**
     * +-- 文字列を指定してコンパイルする
     *
     * @access      public
     * @param       string $string コンパイルするテキスト
     * @param       string $compile_id コンパイルID
     * @param       string $base_file_path ベースファイルパス OPTIONAL:NULL
     * @return      string
     */
    public function compile($string, $compile_id, $base_file_path = NULL)
    {
        // cpu負荷節約
        $system_conf = $this->system_conf;

        $compile_id .= '_'.$system_conf['file_version'];
        $cache_path = $system_conf['is_compile_cache'] ? $this->makeCachePath($compile_id) : NULL;
        $is_compile = $this->isCompile($cache_path);
        if (!$is_compile) {
            return file_get_contents($cache_path);
        }
        $out = $this->less_php->compile($string, $base_file_path);
        $this->saveCache($cache_path, $out);
        return $out;
    }
    /* ----------------------------------------- */

    private function makeCachePath($compile_id)
    {
        return $this->system_conf['cache_path'].DIRECTORY_SEPARATOR.'less_php_cache_'.$compile_id.'_'.ENVI_ENV.'.css.envicc';
    }

    private function isCompile($cache_path)
    {
        // cpu負荷節約
        $system_conf = $this->system_conf;
        $is_compile = false;
        if (!$system_conf['is_compile_cache'] || $system_conf['is_force_compile']) {
            $is_compile = true;
        } elseif ($cache_path !== NULL && !is_file($cache_path)) {
            $is_compile = true;
        }
        return $is_compile;
    }
    private function saveCache($cache_path, $out)
    {
        if ($cache_path !== NULL) {
            file_put_contents($cache_path, $out);
        }
    }
}

/**
 *  EnviLessphpExtension専用の例外
 * *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage LessphpExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class EnviLessphpExtensionException extends exception
{

}