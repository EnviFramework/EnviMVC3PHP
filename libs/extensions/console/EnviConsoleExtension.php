<?php
/**
 * コンソールログを使用するためのエクステンションクラス
 *
 * console()->log('fooo');
 *
 * で、ブラウザのコンソールに、ログを出力できるようになるエクステンションです。
 *
 *
 * インストール・設定
 * --------------------------------------------------
 * envi install-extension {app_key} {DI設定ファイル} console
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
 * @subpackage ConsoleExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
*/

/**
 * コンソールログを使用するためのエクステンションクラス
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage ConsoleExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class EnviConsoleExtension
{
    public $template_dir;
    public $system_console_config;
    public $system_conf;
    protected $is_use = false;
    protected $user_log_dir;

    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @param       array $system_conf 設定
     * @return      void
     */
    public function __construct(array $system_conf)
    {
        $this->system_console_config = Envi()->getConfiguration('LOGGER', 'console');
        $this->system_conf = $system_conf;
        $this->template_dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR;
        if (!isset($_COOKIE[$this->system_console_config['value_log_get_key']])) {
            return;
        }

        $this->user_log_dir = realpath($this->system_console_config['value_log_dir'].DIRECTORY_SEPARATOR.$_COOKIE[$this->system_console_config['value_log_get_key']]).DIRECTORY_SEPARATOR;
        if (strpos($this->user_log_dir, $this->system_console_config['value_log_dir']) !== 0) {
            return;
        }

        $this->is_use = true;
    }
    /* ----------------------------------------- */

    /**
     * +-- Jsonを作成する
     *
     * @access      public
     * @param       boolean $clean_log 出力後ログを自動削除するかどうか
     * @return      void
     */
    public function makeJson($clean_log = false)
    {
        if (!$this->is_use) {
            return;
        }
        header('Content-Type: text/javascript');
        if (is_file($this->user_log_dir.'console.log')) {
            echo 'var console= ['.join(',', file($this->user_log_dir.'console.log')).'];';
            if ($clean_log) {
                @unlink($this->user_log_dir.'console.log');
            }
        }
        if (is_file($this->user_log_dir.'system.log')) {
            echo 'var system= ['.join(',', file($this->user_log_dir.'system.log')).'];';
            if ($clean_log) {
                @unlink($this->user_log_dir.'system.log');
            }
        }
        if (is_file($this->user_log_dir.'query.log')) {
            echo 'var query= ['.join(',', file($this->user_log_dir.'query.log')).'];';
            if ($clean_log) {
                @unlink($this->user_log_dir.'query.log');
            }
        }
        if (is_file($this->user_log_dir.'included_files.log')) {
            echo 'var included_files= ['.join(',', file($this->user_log_dir.'included_files.log')).'];';
            if ($clean_log) {
                @unlink($this->user_log_dir.'included_files.log');
            }
        }
        if ($clean_log) {
            setcookie($this->system_console_config['value_log_get_key'], '-', time()+36000, '/');
            rmdir($this->user_log_dir);
        }
        return;
    }
    /* ----------------------------------------- */

    /**
     * +-- コンソールログをブラウザコンソールログに出力する
     *
     * @access      public
     * @param       boolean $clean_log 出力後ログを自動削除するかどうか
     * @return      void
     */
    public function makeConsoleLogJs($clean_log = false)
    {
        if (!$this->is_use) {
            return;
        }
        header('Content-Type: text/javascript');
        if (is_file($this->user_log_dir.'console.log')) {
            echo 'console.log("================ console.log ================");'."\n";
            foreach (file($this->user_log_dir.'console.log') as $item) {
                $item = trim($item);
                $tmp = json_decode($item, true);
                if (!isset($tmp['log_mode']) || $tmp['log_mode'] === 'log') {
                    echo 'console.log('.$item.');'."\n";
                } elseif ($tmp['log_mode'] === 'error') {
                    echo 'console.error('.$item.');'."\n";
                } elseif ($tmp['log_mode'] === 'info') {
                    echo 'console.info('.$item.');'."\n";
                } elseif ($tmp['log_mode'] === 'warn') {
                    echo 'console.warn('.$item.');'."\n";
                } else {
                    echo 'console.log('.$item.');'."\n";
                }
            }
            if ($clean_log) {
                @unlink($this->user_log_dir.'console.log');
            }
        }
        if (is_file($this->user_log_dir.'system.log')) {
            echo 'console.log("================ system.log ================");'."\n";
            foreach (file($this->user_log_dir.'system.log') as $item) {
                $item = trim($item);
                $tmp = json_decode($item, true);
                if (!isset($tmp['log_mode']) || $tmp['log_mode'] === 'log') {
                    echo 'console.log('.$item.');'."\n";
                } elseif ($tmp['log_mode'] === 'error') {
                    echo 'console.error('.$item.');'."\n";
                } elseif ($tmp['log_mode'] === 'info') {
                    echo 'console.info('.$item.');'."\n";
                } elseif ($tmp['log_mode'] === 'warn') {
                    echo 'console.warn('.$item.');'."\n";
                } else {
                    echo 'console.log('.$item.');'."\n";
                }
            }
            if ($clean_log) {
                @unlink($this->user_log_dir.'system.log');
            }
        }
        if (is_file($this->user_log_dir.'query.log')) {
            echo 'console.log("================ query.log ================");'."\n";
            $ql = file($this->user_log_dir.'query.log');
            // 数が多い場合はまとめる
            if (count($ql) > $this->system_conf['query_log_bulk']) {
                echo 'console.log(['.join(',', $ql).']);'."\n";
            } else {
                foreach ($ql as $item) {
                    $item = trim($item);
                    echo 'console.log('.$item.');'."\n";
                }
                if ($clean_log) {
                    @unlink($this->user_log_dir.'query.log');
                }
            }
            unset($ql);
        }
        if (is_file($this->user_log_dir.'included_files.log')) {
            echo 'console.log("================ included_files.log ================");'."\n";
            foreach (file($this->user_log_dir.'included_files.log') as $item) {
                $item = trim($item);
                echo 'console.log('.$item.');'."\n";
            }
            if ($clean_log) {
                @unlink($this->user_log_dir.'included_files.log');
            }
        }
        if ($clean_log) {
            setcookie($this->system_console_config['value_log_get_key'], '-', time()+36000, '/');
            rmdir($this->user_log_dir);
        }
        return;
    }
    /* ----------------------------------------- */

}
