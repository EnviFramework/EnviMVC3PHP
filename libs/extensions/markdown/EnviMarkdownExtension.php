<?php
/**
 * MarkdownExtraを使用するためのエクステンションクラス
 *
 *
 * Markdown拡張である、MarkdownExtra形式で記述されたテキストを、HTMLにコンパイルするエクステンションです。
 *
 * 詳細は、

 * https://michelf.ca/projects/php-markdown/extra/
 *
 * を参照して下さい。
 *
 * インストール・設定
 * --------------------------------------------------
 * envi install-extension {app_key} {DI設定ファイル} markdown
 *
 * コマンドでインストール出来ます。
 *
 *
 * PHP versions 5
 *
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage MarkdownExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
*/

if (!class_exists('\Michelf\Markdown', false)) {
    require dirname(__FILE__).DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'Michelf'.DIRECTORY_SEPARATOR.'Michelf'.DIRECTORY_SEPARATOR.'MarkdownExtra.inc.php';
}
use \Michelf\Markdown, \Michelf\SmartyPants,\Michelf\MarkdownExtra;


/**
 *  MarkdownExtraを使用するためのエクステンション
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage MarkdownExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class EnviMarkdownExtension
{
    private $system_conf;

    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @param       array $system_conf コンフィグ
     * @return      void
     */
    public function __construct(array $system_conf)
    {
        $system_conf['predef_urls']    = isset($system_conf['predef_urls']) && is_array($system_conf['predef_urls']) ? $system_conf['predef_urls'] : array();
        $system_conf['predef_titles']  = isset($system_conf['predef_titles']) && is_array($system_conf['predef_titles']) ? $system_conf['predef_titles'] : array();
        $system_conf['predef_abbr']    = isset($system_conf['predef_abbr']) && is_array($system_conf['predef_abbr']) ? $system_conf['predef_abbr'] : array();
        $this->system_conf = $system_conf;
    }
    /* ----------------------------------------- */


    /**
     * +-- ファイルを指定してコンパイルする
     *
     * @access      public
     * @param       string $file_path ファイルパス
     * @param       string $compile_id コンパイルID OPTIONAL:NULL
     * @param       string $extra エクストラフラグ OPTIONAL:NULL
     * @return      string
     */
    public function compileFile($file_path, $compile_id = NULL, $extra = NULL)
    {
        if (!is_file($file_path)) {
            throw exception('not file : '.$file_path);
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
        $out = $this->transformFile($file_path, $extra);
        $this->saveCache($cache_path, $out);
        return $out;
    }
    /* ----------------------------------------- */

    /**
     * +-- 文字列を指定してコンパイルする
     *
     * @access      public
     * @param       string $string コンパイルする文字列
     * @param       string $compile_id コンパイルID OPTIONAL:NULL
     * @param       string $extra エクストラフラグ OPTIONAL:NULL
     * @return      string
     */
    public function compile($string, $compile_id, $extra = NULL)
    {
        // cpu負荷節約
        $system_conf = $this->system_conf;

        $compile_id .= '_'.$system_conf['file_version'];
        $cache_path = $system_conf['is_compile_cache'] ? $this->makeCachePath($compile_id) : NULL;
        $is_compile = $this->isCompile($cache_path);
        if (!$is_compile) {
            return file_get_contents($cache_path);
        }
        $out = $this->transform($string, $extra);
        $this->saveCache($cache_path, $out);
        return $out;
    }
    /* ----------------------------------------- */


    /**
     * +-- transformを実行する
     *
     * @access      public
     * @param       string $text 変換する文字列
     * @param       string $extra OPTIONAL:NULL
     * @return      string
     */
    public function transform($text, $extra = NULL)
    {
        $extra = $extra === NULL ? $this->system_conf['use_extra'] : $extra;
        if ($extra) {
            return $this->getMarkdownExtra()->transform($text);
        }
        return $this->getMarkDown()->transform($text);
    }
    /* ----------------------------------------- */

    /**
     * +-- ファイルからtransformを実行する
     *
     * @access      public
     * @param       string $file_path 変換するファイルのパス
     * @param       string $extra OPTIONAL:NULL
     * @return      string
     */
    public function transformFile($file_path, $extra = NULL)
    {
        if (!is_file($file_path)) {
            throw exception('not file : '.$file_path);
        }
        return $this->transform(file_get_contents($file_path), $extra);
    }
    /* ----------------------------------------- */


    public function getMarkDown()
    {
        static $parser;
        if ($parser) {
            return $parser;
        }
        $parser = new Markdown;
        $this->settingParser($parser);
        return $parser;
    }


    public function getMarkdownExtra()
    {
        static $parser;
        if ($parser) {
            return $parser;
        }
        $parser = new MarkdownExtra;
        $this->settingParser($parser, true);
        return $parser;
    }

    private function settingParser(&$parser, $use_extra = false)
    {
        // cpu負荷節約
        $system_conf = $this->system_conf;
        $parser->empty_element_suffix = $system_conf['empty_element_suffix'];
        $parser->tab_width = $system_conf['tab_width'];
        $parser->no_markup  = $system_conf['no_markup'];
        $parser->no_entities  = $system_conf['no_entities'];
        $parser->predef_urls = $system_conf['predef_urls'];
        $parser->predef_titles = $system_conf['predef_titles'];
        if (!$use_extra) {
            return;
        }
        $parser->fn_id_prefix = $system_conf['fn_id_prefix'];
        $parser->fn_link_title = $system_conf['fn_link_title'];
        $parser->fn_backlink_title = $system_conf['fn_backlink_title'];
        $parser->fn_link_class = $system_conf['fn_link_class'];
        $parser->fn_backlink_class = $system_conf['fn_backlink_class'];
        $parser->code_class_prefix = $system_conf['code_class_prefix'];
        $parser->code_attr_on_pre   = isset($system_conf['code_attr_on_pre']) ? $system_conf['code_attr_on_pre'] : false;
        $parser->predef_abbr = $system_conf['predef_abbr'];
    }


    private function makeCachePath($compile_id)
    {
        return $this->system_conf['cache_path'].DIRECTORY_SEPARATOR.'mark_down_cache_'.$compile_id.'_'.ENVI_ENV.'.html.envicc';
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

