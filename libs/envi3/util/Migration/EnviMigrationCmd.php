<?php
/**
 *
 *
 * PHP versions 5
 *
 *
 *
 * @category   フレームワーク基礎処理
 * @package    DB
 * @subpackage Migration
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 3.4.0
 * @doc_ignore
 */
/**
 *
 *
 * PHP versions 5
 *
 *
 *
 * @category   フレームワーク基礎処理
 * @package    DB
 * @subpackage Migration
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 3.4.0
 * @doc_ignore
 */
class EnviMigrationCmd
{
    protected $current_work_dir;
    protected $project_dir;
    protected $db_dir;
    protected $migration_dir;
    protected $migration_class_files;
    protected $env;
    protected $migration_status;
    protected $migration_file;
    protected $app_key;

    public function __construct($current_work_dir)
    {
        global $argv;
        // アプリキー
        $this->app_key = $argv[2];
        $this->current_work_dir = $current_work_dir;

        // project dir
        $this->project_dir = $current_work_dir;
        while (!is_file($this->project_dir.'envi.prj') && strlen($this->project_dir) > 2) {
            $this->project_dir = dirname($this->project_dir).DIRECTORY_SEPARATOR;
        }

        $this->db_dir = $this->project_dir.'db'.DIRECTORY_SEPARATOR;
        $this->migration_dir = $this->project_dir.'db'.DIRECTORY_SEPARATOR.'migrate'.DIRECTORY_SEPARATOR;

        $this->migration_class_files = glob($this->migration_dir.$this->app_key.'_*.php');

        sort($this->migration_class_files);

        $this->env = trim(file_get_contents($this->db_dir.'env'));
        foreach ($argv as $k => $arg) {
            if ($k < 2) {
                continue;
            }
            switch (true) {
                case (strpos($arg, 'env:') !== false):
                    list(, $this->env) = explode(':', $arg);
                    break;
            }
        }

        $this->migration_file = $this->db_dir.'envi_migration_'.$this->app_key.'_'.$this->env.'.php';
        $this->migration_status = array('last_version' => '0', 'executed' => array());
        if (is_file($this->migration_file)) {
            $this->migration_status = include_once $this->migration_file;
        }
    }

    public function getMigrationList()
    {
        $res = array();
        foreach ($this->migration_class_files as $migration_class_file) {
            if (in_array($migration_class_file, $this->migration_status['executed']) ) {
                continue;
            }
            $res[] = $migration_class_file;
        }
        return $res;
    }


    public function getRollbackList()
    {
        $res = array();
        $migration_class_files = $this->migration_class_files;
        rsort($migration_class_files);
        foreach ($migration_class_files as $migration_class_file) {
            list($app, $version, $migration_class) = explode('_', substr(basename($migration_class_file), 0, -4), 3);
            if ($version > $this->migration_status['last_version']) {
                continue;
            }
            $res[] = $migration_class_file;
        }
        return $res;
    }
    public function getMigrationStatus()
    {
        return $this->migration_status;
    }

    public function setMigrationStatus($setter)
    {
        $this->migration_status = $setter;
    }

    public function saveMigrationStatus()
    {
        if (!isOption('--dry_run')) {
            file_put_contents($this->migration_file, "<?php\n return ".var_export($this->migration_status, true).';');
        }
    }



    /**
     * +-- マイグレーションを一つ戻します
     *
     * @access      public
     * @return      boolean
     */
    public function executeRollback()
    {
        $migration = $this->getMigrationStatus();
        if (count($migration['executed']) === 0) {
            return false;
        }

        $migration_class_file = array_pop($migration['executed']);

        list($app, $version, $migration_class) = explode('_', substr(basename($migration_class_file), 0, -4), 3);
        echo $migration_class_file,"\n";
        include $migration_class_file;
        $class_name = $app.'_'.$migration_class;
        $obj = new $class_name;
        $obj->env = $this->env;
        // ダウン
        $obj->is_up = false;

        try{
            $obj->DBI()->beginTransaction();
            $obj->safeChange();
            $obj->safeDown();
            $obj->DBI()->commit();
        } catch (exception $e) {
            $obj->DBI()->rollback();
            echo $e->getMessage(),"\n","db:rollback roll back";
            return;
        }


        $obj->change();
        $obj->down();

        // バージョンを戻す
        if (count($migration['executed']) === 0) {
            // 実行履歴がゼロになった場合
            $migration['last_version'] = 0;
        } else {
            $migration_class_file = $migration['executed'][count($migration['executed']) - 1];
            $app = $this->app_key;
            list($version, $migration_class) = explode('_', substr(basename($migration_class_file), strlen($app) + 1, -4));
            $migration['last_version'] = $version < $migration['last_version'] ? $version : $migration['last_version'];
        }

        $this->setMigrationStatus($migration);
        $this->saveMigrationStatus();
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- Downを実行する
     *
     * @access      public
     * @param       var_text $count OPTIONAL:1
     * @return      void
     */
    public function executeDown($count = 1)
    {
        while ($count--) {
            $res = $this->executeRollback();
            if (!$res) {
                return;
            }
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- すべてのマイグレーションを実行します
     *
     *
     * @access      public
     * @param       integer $count OPTIONAL:NULL
     * @return      void
     */
    public function executeMigrate($count = NULL)
    {
        $migration = $this->getMigrationStatus();
        foreach ($this->getMigrationList() as $migration_class_file) {
            $app = $this->app_key;
            list($version, $migration_class) = explode('_', substr(basename($migration_class_file), strlen($app) + 1, -4), 2);
            echo $migration_class_file,"\n";
            include $migration_class_file;
            $class_name = $app.'_'.$migration_class;
            $obj = new $class_name;
            $obj->env = $this->env;
            try{
                $obj->DBI()->beginTransaction();
                $obj->safeChange();
                $obj->safeUp();
                $obj->DBI()->commit();
            } catch (exception $e) {
                $obj->DBI()->rollback();
                echo $e->getMessage(),"\n","db:migrate roll back";
                return;
            }

            $obj->change();
            $obj->up();
            $migration['last_version'] = $version > $migration['last_version'] ? $version : $migration['last_version'];
            $migration['executed'][]   = $migration_class_file;
            $this->setMigrationStatus($migration);
            $this->saveMigrationStatus();
            if ($count === NULL) {
                // 通常migration
                continue;
            }
            if (--$count <= 0) {
                // UPの処理
                return;
            }
        }
    }
    /* ----------------------------------------- */




    /**
     * +-- マイグレーション履歴を表示します
     *
     * @access      public
     * @param       integer $count OPTIONAL:5
     * @return      void
     */
    public function executeHistory($count = 5)
    {
        $migration = $this->getMigrationStatus();
        while ($count--) {
            $migration_class_file = array_pop($migration['executed']);
            $app = $this->app_key;
            list($version, $migration_class) = explode('_', substr(basename($migration_class_file), strlen($app) + 1, -4), 2);
            echo $version,":",$migration_class,"\n";
        }
    }
    /* ----------------------------------------- */



    /**
     * +-- マイグレーション履歴を表示します
     *
     * @access      public
     * @param       integer $count OPTIONAL:5
     * @return      void
     */
    public function executeNew($count = 5)
    {
        $migration = $this->getMigrationList();
        while ($count--) {
            $migration_class_file = array_shift($migration);
            $app = $this->app_key;
            list($version, $migration_class) = explode('_', substr(basename($migration_class_file), strlen($app) + 1, -4), 2);
            echo $version,":",$migration_class,"\n";
        }
    }
    /* ----------------------------------------- */




    /**
     * +-- カーソルだけを一つあげます
     *
     * @access      public
     * @return      void
     */
    public function executeCursorUp()
    {
        $migration = $this->getMigrationStatus();
        foreach ($this->getMigrationList() as $migration_class_file) {
            $app = $this->app_key;
            list($version, $migration_class) = explode('_', substr(basename($migration_class_file), strlen($app) + 1, -4), 2);
            echo $migration_class_file,"\n";
            include $migration_class_file;
            $class_name = $app.'_'.$migration_class;
            $obj = new $class_name;
            $obj->env = $this->env;
            $migration['last_version'] = $version > $migration['last_version'] ? $version : $migration['last_version'];
            $migration['executed'][]   = $migration_class_file;
            $this->setMigrationStatus($migration);
            $this->saveMigrationStatus();
            return;
        }
    }
    /* ----------------------------------------- */


    /**
     * +-- カーソルだけを一つ下げます
     *
     * @access      public
     * @return      void
     */
    public function executeCursorDown()
    {
        $migration = $this->getMigrationStatus();
        if (count($migration['executed']) === 0) {
            return false;
        }
        $migration_class_file = array_pop($migration['executed']);

        $app = $this->app_key;
        list($version, $migration_class) = explode('_', substr(basename($migration_class_file), strlen($app) + 1, -4), 2);
        echo $migration_class_file,"\n";
        include $migration_class_file;
        $class_name = $app.'_'.$migration_class;
        $obj = new $class_name;
        $obj->env = $this->env;
        // ダウン
        $obj->is_up = false;

        // バージョンを戻す
        if (count($migration['executed']) === 0) {
            // 実行履歴がゼロになった場合
            $migration['last_version'] = 0;
        } else {
            $migration_class_file = $migration['executed'][count($migration['executed']) - 1];
            list($app, $version, $migration_class) = explode('_', substr(basename($migration_class_file), 0, -4));
            $migration['last_version'] = $version < $migration['last_version'] ? $version : $migration['last_version'];
        }

        $this->setMigrationStatus($migration);
        $this->saveMigrationStatus();
    }
    /* ----------------------------------------- */
}