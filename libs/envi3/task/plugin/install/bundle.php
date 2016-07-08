<?php
/**
 * バンドルプログラム追加タスク
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release v3.4.0.0
 */
umask(0);
if (!isset($argv[3])) {
    eecho('引数が足りません。');
    eecho('envi install-bundle [new|update|delete] {install-bundle config yaml}');
    die;
}
$bundle_mode = $argv[2];
$bundle_yaml = $argv[3];


$install_dir       = realpath(ENVI_BASE_DIR.'..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

// bundle管理ディレクトリ
$bundle_cache_dir  = realpath(ENVI_BASE_DIR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'bundle'.DIRECTORY_SEPARATOR;
if (!is_dir($bundle_cache_dir)) {
    mkdir($bundle_cache_dir);
}

$bundle_temp_file = $bundle_cache_dir.'temp.yml';
file_put_contents($bundle_temp_file, file_get_contents($bundle_yaml));

// SpyCの読み込み
include_once ENVI_BASE_DIR.'spyc.php';
$bundle_config = spyc_load(file_get_contents($bundle_temp_file));


$EnviBundle = new EnviBundle($bundle_cache_dir, $bundle_temp_file, $install_dir);

switch ($bundle_mode) {
    case 'new':
        $EnviBundle->executeNew($bundle_config);
    break;
    case 'update':
        $EnviBundle->executeUpdate($bundle_config);
    break;
    case 'delete':
        $EnviBundle->executeDelete($bundle_config);
    break;
}



class EnviBundle
{
    public $bundle_cache_dir, $bundle_temp_file, $install_dir,$envi_work_dir;
    public function __construct($bundle_cache_dir, $bundle_temp_file, $install_dir)
    {
        $this->bundle_cache_dir = $bundle_cache_dir;
        $this->bundle_temp_file = $bundle_temp_file;
        $this->install_dir      = $install_dir;
        $this->envi_work_dir    = realpath(ENVI_BASE_DIR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'work'.DIRECTORY_SEPARATOR;
        if (!is_dir($this->envi_work_dir)) {
            mkdir($this->envi_work_dir);
        }
    }

    /**
     * +-- mode new
     *
     * @access      public
     * @param  array $bundle_config
     * @return void
     */
    public function executeNew(array $bundle_config)
    {
        switch ($bundle_config['type']) {
            case 'extension':
            $this->extensionInstall($bundle_config);
            break;
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- mode new
     *
     * @access      public
     * @param  array $bundle_config
     * @return void
     */
    public function executeUpdate(array $bundle_config)
    {
        switch ($bundle_config['type']) {
            case 'extension':
            $this->extensionUpdate($bundle_config);
            break;
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- mode new
     *
     * @access      public
     * @param  array $bundle_config
     * @return void
     */
    public function executeDelete(array $bundle_config)
    {
        switch ($bundle_config['type']) {
            case 'extension':
            $this->extensionDelete($bundle_config);
            break;
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- Extensionのインストールを行います
     *
     * @access      public
     * @param  array $bundle_config
     * @return void
     */
    public function extensionInstall(array $bundle_config)
    {
        if (is_file($this->bundle_cache_dir.$bundle_config['name'].'.yml')) {
            die(_('既にBundleされているExtensionパッケージです。envi install-bundle update を試して下さい')."\n");
        }

        $install_dir = $this->install_dir.'extensions'.DIRECTORY_SEPARATOR.$bundle_config['name'].DIRECTORY_SEPARATOR;
        if (is_dir($install_dir) && !$this->yesOrNo('envi install-bundle で管理されていないExtensionパッケージが存在します。上書きしてもよろしいですか？')) {
            die(_('中断')."\n");
        }
        // クリーン
        is_dir($install_dir) && rename($install_dir, $this->envi_work_dir.$bundle_config['name'].'_bundle_new_'.date('Ymdhis'));

        // インストール
        switch ($bundle_config['install']['mode']) {
            case 'git':
            $bundle_config['install']['version'] = $this->gitInstall($bundle_config['install']['clone'], $install_dir, $bundle_config['install']['version']);
            @unlink($install_dir.'.gitignore');
            break;
        }

        // 依存ライブラリ
        if (isset($bundle_config['depend'])) {
            foreach ($bundle_config['depend'] as $key => $depend) {
                switch ($depend['install']['mode']) {
                    case 'git':
                    $bundle_config['depend'][$key]['install']['version'] = $this->gitInstall($depend['install']['clone'], $install_dir.$depend['install']['path'], $depend['install']['version']);
                    break;
                }
            }
        }

        $yaml = Spyc::YAMLDump($bundle_config, 2, 60);
        file_put_contents($this->bundle_cache_dir.$bundle_config['name'].'.yml', $yaml);
    }
    /* ----------------------------------------- */



    /**
     * +-- Extensionの更新を行います
     *
     * @access      public
     * @param  array $bundle_config
     * @return void
     */
    public function extensionUpdate(array $bundle_config)
    {
        if (is_file($this->bundle_cache_dir.$bundle_config['name'].'.yml')) {
            rename($this->bundle_cache_dir.$bundle_config['name'].'.yml', $this->bundle_cache_dir.$bundle_config['name'].'.yml'.date('Ymdhis'));
        }

        $install_dir = $this->install_dir.'extensions'.DIRECTORY_SEPARATOR.$bundle_config['name'].DIRECTORY_SEPARATOR;

        // クリーン
        is_dir($install_dir) && rename($install_dir, $this->envi_work_dir.$bundle_config['name'].'_bundle_update_'.date('Ymdhis'));

        // インストール
        switch ($bundle_config['install']['mode']) {
            case 'git':
            $bundle_config['install']['version'] = $this->gitInstall($bundle_config['install']['clone'], $install_dir, $bundle_config['install']['version']);
            @unlink($install_dir.'.gitignore');
            break;
        }

        // 依存ライブラリ
        if (isset($bundle_config['depend'])) {
            foreach ($bundle_config['depend'] as $key => $depend) {
                switch ($depend['install']['mode']) {
                    case 'git':
                    $bundle_config['depend'][$key]['install']['version'] = $this->gitInstall($depend['install']['clone'], $install_dir.$depend['install']['path'], $depend['install']['version']);
                    break;
                }
            }
        }

        $yaml = Spyc::YAMLDump($bundle_config, 2, 60);
        file_put_contents($this->bundle_cache_dir.$bundle_config['name'].'.yml', $yaml);
    }
    /* ----------------------------------------- */


    /**
     * +-- Extensionの削除を行います
     *
     * @access      public
     * @param  array $bundle_config
     * @return void
     */
    public function extensionDelete(array $bundle_config)
    {
        $install_dir = $this->install_dir.'extensions'.DIRECTORY_SEPARATOR.$bundle_config['name'].DIRECTORY_SEPARATOR;
        if (!is_file($this->bundle_cache_dir.$bundle_config['name'].'.yml') && is_dir($install_dir) && !$this->yesOrNo('envi install-bundle で管理されていないExtensionパッケージですす。削除してもよろしいですか？')) {
            die(_('中断')."\n");
        }
        // クリーン
        is_dir($install_dir) && rename($install_dir, $this->envi_work_dir.$bundle_config['name'].'_bundle_delete_'.date('Ymdhis'));
        is_file($this->bundle_cache_dir.$bundle_config['name'].'.yml') && rename($this->bundle_cache_dir.$bundle_config['name'].'.yml', $this->bundle_cache_dir.$bundle_config['name'].'.yml'.date('Ymdhis'));
    }
    /* ----------------------------------------- */



    /**
     * +-- gitコマンドを利用したインストール
     *
     * @access      public
     * @param  string $repository
     * @param  string $install_dir
     * @param  string $version
     * @return string
     */
    public function gitInstall($repository, $install_dir, $version)
    {
        $cmd = 'git clone --recursive '.$repository.' '.$install_dir;
        cecho($cmd);
        `$cmd`;
        chdir($install_dir);
        $tags = `git for-each-ref --sort=-taggerdate refs/tags`;
        $tags = explode("\n", trim($tags));
        if (count($tags) === 0) {
            return null;
        }
        if ($version === '@new') {
            $last_tag = array_pop($tags);
            mb_ereg('refs/tags/(.*)$', $last_tag, $match);
            $version = $match[1];
        }

        $cmd = 'git checkout '.$version;
        `$cmd`;
        return $version;
    }
    /* ----------------------------------------- */

    /**
     * +-- メッセージ
     *
     * @access      public
     * @param  string $message
     * @return bool
     */
    public function yesOrNo($message)
    {
        $message = _($message);
        echo $message,"\n",'Y/n',"\n";

        while ($text = trim(fgets(STDIN))) {
            switch ($text) {
            case 'Y':
            case 'Yes':
            case 'yes':
            case 'YES':
                return true;
            case 'n':
            case 'N':
            case 'no':
            case 'No':
                return false;
            }

            echo $message,"\n",'Y/n',"\n";
        }
    }
    /* ----------------------------------------- */
}
