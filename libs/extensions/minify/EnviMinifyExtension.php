<?php
/**
 * minifyを使用するためのエクステンションクラス
 *
 * CssとJavaScriptをminifyするためのextensionです
 *
 *
 * 内部的には
 *
 * http://www.minifier.org/
 *
 * のライブラリを使用しています。
 *
 *
 * インストール・設定
 * --------------------------------------------------
 * envi install-extension {app_key} {DI設定ファイル} minify
 *
 * コマンドでインストール出来ます。
 *
 *
 *
 *
 * PHP versions 5
 *
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage MinifyExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2015 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
*/

use MatthiasMullie\Minify;

if (!class_exists('Minify', false)) {
    require dirname(__FILE__).DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'minify'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Exception.php';
    require dirname(__FILE__).DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'minify'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Minify.php';
    require dirname(__FILE__).DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'minify'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'CSS.php';
    require dirname(__FILE__).DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'minify'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'JS.php';
}

class EnviMinifyExtensionJs extends Minify\JS
{

    protected $cache_file_name;

    public function fileList()
    {
        return $this->cache_file_name;
    }

    /**
     * Add a file or straight-up code to be minified.
     *
     * @param string $data
     */
    public function addFile($data /* $data = null, ... */)
    {
        // bogus "usage" of parameter $data: scrutinizer warns this variable is
        // not used (we're using func_get_args instead to support overloading),
        // but it still needs to be defined because it makes no sense to have
        // this function without argument :)
        $args = array($data) + func_get_args();

        // this method can be overloaded
        foreach ($args as $data) {
            // redefine var
            $data = (string) $data;
            if (isset($this->cache_file_name[$data])) {
                continue;
            }
            $this->cache_file_name[$data] = $data;

            // load data
            $value = $this->loadFile($data);
            $key = count($this->data);

            // store data
            $this->data[$key] = $value;
        }
    }

    /**
     * Add a file or straight-up code to be minified.
     *
     * @param string $data
     */
    public function addContents($data /* $data = null, ... */)
    {
        // bogus "usage" of parameter $data: scrutinizer warns this variable is
        // not used (we're using func_get_args instead to support overloading),
        // but it still needs to be defined because it makes no sense to have
        // this function without argument :)
        $args = array($data) + func_get_args();

        // this method can be overloaded
        foreach ($args as $value) {
            // redefine var
            $value = (string) $value;

            $key = count($this->data);

            // store data
            $this->data[$key] = $value;
        }
    }

    /**
     * +-- 初期化
     *
     * @access      public
     * @return      void
     */
    public function free()
    {
        $this->data = array();
        $this->cache_file_name = array();
    }
    /* ----------------------------------------- */

    /**
     * Load data.
     *
     * @param  string $data Either a path to a file or the content itself.
     * @return string
     */
    protected function loadFile($data)
    {
        $data = file_get_contents($data);
        // strip BOM, if any
        if (substr($data, 0, 3) == "\xef\xbb\xbf") {
            $data = substr($data, 3);
        }
        return $data;
    }



}
class EnviMinifyExtensionCss extends Minify\CSS
{

    protected $cache_file_name;


    public function fileList()
    {
        return $this->cache_file_name;
    }

    /**
     * Add a file or straight-up code to be minified.
     *
     * @param string $data
     */
    public function addFile($data /* $data = null, ... */)
    {
        // bogus "usage" of parameter $data: scrutinizer warns this variable is
        // not used (we're using func_get_args instead to support overloading),
        // but it still needs to be defined because it makes no sense to have
        // this function without argument :)
        $args = array($data) + func_get_args();

        // this method can be overloaded
        foreach ($args as $data) {
            // redefine var
            $data = (string) $data;
            if (isset($this->cache_file_name[$data])) {
                continue;
            }
            $this->cache_file_name[$data] = $data;

            // load data
            $value = $this->loadFile($data);
            $key = count($this->data);

            // store data
            $this->data[$key] = $value;
        }
    }

    /**
     * Add a file or straight-up code to be minified.
     *
     * @param string $data
     */
    public function addContents($data /* $data = null, ... */)
    {
        // bogus "usage" of parameter $data: scrutinizer warns this variable is
        // not used (we're using func_get_args instead to support overloading),
        // but it still needs to be defined because it makes no sense to have
        // this function without argument :)
        $args = array($data) + func_get_args();

        // this method can be overloaded
        foreach ($args as $value) {
            // redefine var
            $value = (string) $value;

            $key = count($this->data);

            // store data
            $this->data[$key] = $value;
        }
    }

    /**
     * +-- 初期化
     *
     * @access      public
     * @return      void
     */
    public function free()
    {
        $this->data = array();
        $this->cache_file_name = array();
    }
    /* ----------------------------------------- */

    /**
     * Load data.
     *
     * @param  string $data Either a path to a file or the content itself.
     * @return string
     */
    protected function loadFile($data)
    {
        $data = file_get_contents($data);
        // strip BOM, if any
        if (substr($data, 0, 3) == "\xef\xbb\xbf") {
            $data = substr($data, 3);
        }
        return $data;
    }


}



/**
 * minifyを使用するためのエクステンションクラス
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage MinifyExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2015 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class EnviMinifyExtension
{
    private $system_conf;
    private $minify_js;
    private $minify_css;

    private $cache_file_name = array();


    const TYPE_JS = 'minify_js';
    const TYPE_CSS = 'minify_css';

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
        $this->minify_js = new EnviMinifyExtensionJs();
        $this->minify_css = new EnviMinifyExtensionCss();

    }
    /* ----------------------------------------- */

    /**
     * +-- JSのminifyObject取得
     *
     * @access      public
     * @return      EnviMinifyExtensionJs
     */
    public function JS()
    {
        return $this->minify_js;
    }
    /* ----------------------------------------- */

    /**
     * +-- CssのminifyObject取得
     *
     * @access      public
     * @return      EnviMinifyExtensionCss
     */
    public function CSS()
    {
        return $this->minify_css;
    }
    /* ----------------------------------------- */

    /**
     * +-- 初期化
     *
     * @access      public
     * @return      void
     */
    public function free()
    {
        $this->minify_js->free();
        $this->minify_css->free();
    }
    /* ----------------------------------------- */

    /**
     * +-- ファイルをcompileする
     *
     * @access      public
     * @param       var_text $type
     * @param       var_text $compile_name OPTIONAL:NULL
     * @return      string
     */
    public function compile($type, $compile_name = NULL)
    {
        try{
            if ($this->system_conf['is_compile_cache']) {
                $compile_name  = 'minify_';
                $compile_name .= $compile_name ? $compile_name : sha1(join(' ', $this->fileList($type)));
                $compile_name .= '_'.$type;
                $compile_name .= '_'.$this->system_conf['format'];
                if (isset($this->system_conf['file_version'])) {
                    $compile_name .= '_'.$this->system_conf['file_version'];
                }
                $compile_name .= '_'.ENVI_ENV;

                $compile_name .= '.envicc';
            } else {
                $compile_name = false;
            }

            if ($compile_name && !$this->system_conf['is_force_compile'] && is_file($this->system_conf['cache_path'].$compile_name)) {
                return file_get_contents($this->system_conf['cache_path'].$compile_name);
            }


            if ($this->system_conf['format'] === 'compressed') {
                $res = call_user_func_array(array($this->$type, 'gzip'), array(NULL, $this->system_conf['compressed_level']));
            } else {
                $res = call_user_func_array(array($this->$type, 'minify'), array());
            }
            if ($compile_name) {
                file_put_contents($this->system_conf['cache_path'].$compile_name, $res);
            }
            return $res;
        } catch (exception $e) {
            throw new EnviMinifyExtensionException('MinifyCompileError', 0, $e);
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- JSファイルをcompileする
     *
     * @access      public
     * @param       var_text $compile_name OPTIONAL:NULL
     * @return      string
     */
    public function compileJs($compile_name = NULL)
    {
        return $this->compile(self::TYPE_JS, $compile_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- CSSファイルをcompileする
     *
     * @access      public
     * @param       var_text $compile_name OPTIONAL:NULL
     * @return      string
     */
    public function compileCss($compile_name = NULL)
    {
        return $this->compile(self::TYPE_CSS, $compile_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- ファイルを追加する
     *
     * @access      public
     * @param       array $data
     * @param       var_text $type
     * @return      void
     */
    public function addFile(array $data, $type)
    {
        call_user_func_array(array($this->$type, 'addFile'), $data);
    }
    /* ----------------------------------------- */

    /**
     * +-- JSファイルを追加する
     *
     * @access      public
     * @param       var_text $file_path
     * @return      void
     */
    public function addJsFile($file_path)
    {
        $this->addFile(func_get_args(), self::TYPE_JS);
    }
    /* ----------------------------------------- */

    /**
     * +-- CSSファイルを追加する
     *
     * @access      public
     * @param       var_text $file_path
     * @return      void
     */
    public function addCssFile($file_path)
    {
        $this->addFile(func_get_args(), self::TYPE_CSS);
    }
    /* ----------------------------------------- */

    /**
     * +-- ファイルリストを取得する
     *
     * @access      public
     * @param       var_text $type
     * @return      array
     */
    public function fileList($type)
    {
        return call_user_func_array(array($this->$type, 'fileList'), array());
    }
    /* ----------------------------------------- */

    /**
     * +-- JSファイルリストを取得する
     *
     * @access      public
     * @return      array
     */
    public function fileListJs()
    {
        return $this->fileList(self::TYPE_JS);
    }
    /* ----------------------------------------- */

    /**
     * +-- CSSファイルリストを取得する
     *
     * @access      public
     * @return      array
     */
    public function fileListCss()
    {
        return $this->fileList(self::TYPE_CSS);
    }
    /* ----------------------------------------- */

    /**
     * +-- テキストデータを登録する
     *
     * @access      public
     * @param       array $data
     * @param       var_text $type
     * @return      void
     */
    public function addContents(array $data, $type)
    {
        call_user_func_array(array($this->$type, 'addContents'), $data);
    }
    /* ----------------------------------------- */
    /**
     * +-- テキストデータをJSとして登録する
     *
     * @access      public
     * @param       var_text $file_path
     * @return      void
     */
    public function addJsContents($file_path)
    {
        $this->addContents(func_get_args(), self::TYPE_JS);
    }
    /* ----------------------------------------- */

    /**
     * +-- テキストデータをCSSとして登録する
     *
     * @access      public
     * @param       var_text $file_path
     * @return      void
     */
    public function addCssContents($file_path)
    {
        $this->addContents(func_get_args(), self::TYPE_CSS);
    }
    /* ----------------------------------------- */

}

/**
 * EnviMinifyExtension専用の例外
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage MinifyExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2015 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class EnviMinifyExtensionException extends exception
{

}
