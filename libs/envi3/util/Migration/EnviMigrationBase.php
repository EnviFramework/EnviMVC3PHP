<?php
/**
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
 * @since      File available since Release 3.4.0
 */

/**
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
 * @since      File available since Release 3.4.0
 */
abstract class EnviMigrationBase
{

    protected $databases_yml;
    public $env = 'dev';
    public $is_up = true;

    protected $instance_name = 'default_master';

    protected $driver;
    protected $dbi;


    /**
     * +-- カラムの変更処理を登録するメソッド
     *
     * * changeColumn
     * * changeColumnDefault
     * * dropTable
     * * removeIndex
     *
     * 以外のメソッドであれば、changeメソッドに登録することによって、自動的にロールバックを作成します。
     *
     *
     *
     * @access      public
     * @abstract
     * @return      void
     */
    abstract public function change();
    /* ----------------------------------------- */
    /**
     * +-- columnのバージョンアップを登録するメソッド
     *
     * @access      public
     * @abstract
     * @return      void
     */
    abstract public function up();
    /* ----------------------------------------- */

    /**
     * +-- columnのバージョンダウンを塔録すメソッド
     *
     * @access      public
     * @abstract
     * @return      void
     */
    abstract public function down();
    /* ----------------------------------------- */

    /**
     * +-- EnviDBIを返す
     *
     * @access      public
     * @return      EnviDBIBase
     * @since       3.4.0
     */
    public function &DBI()
    {
        return $this->dbi;
    }
    /* ----------------------------------------- */

    /**
     * +-- ドライランかどうか
     *
     * @access      public
     * @return      boolean
     * @since       3.4.0
     */
    public function isDryRun()
    {
        return isOption('--dry_run');
    }
    /* ----------------------------------------- */

    /**
     * +-- ドライバーを帰す
     *
     * @access      protected
     * @return      EnviMigrationDriversBase
     * @since       3.4.0
     */
    protected function &Driver()
    {
        if ($this->driver instanceof EnviMigrationDriversBase) {
            return $this->driver;
        }
        ob_start();
        include $this->databases_yml;
        $buff      = ob_get_contents();
        ob_end_clean();
        $databases_yml = spyc_load($buff);

        if (!isset($databases_yml[$this->env])) {
            $databases_yml[$this->env] = array();
        }
        $databases_yml = array_merge((array)$databases_yml['all'], (array)$databases_yml[$this->env]);
        $dsn = $databases_yml[$this->instance_name]['params']['dsn'];
        // コネクションの取得
        $this->dbi = EnviDB::getConnection($databases_yml[$this->instance_name]['params'], $this->instance_name);
        parse_str($dsn, $conf);
        switch ($conf['phptype']) {
        case 'mysql':
            include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'drivers'.DIRECTORY_SEPARATOR.'EnviMigrationDriversMysql.php';
            $this->driver = new EnviMigrationDriversMysql($this);
            break;
        }
        return $this->driver;
    }
    /* ----------------------------------------- */



    /**
     * +-- カラムを追加する
     *
     * オプション | 説明 | デフォルト
     * ---------- | ---- | ----------
     * limit      | カラムの桁数を指定 |
     * default    | デフォルト値を指定 |
     * null       | null値を許可するか | true
     * not_null   | null値を許可しないか | false
     * precision  | decimal 型の精度を指定 |
     * scale      | decimal 型の小数点以下の桁数 |
     * primary    | 主キーをセットする | false
     * auto_increment | オートインクリメントにする | false
     * after      | 指定したcolumnの前ににつける | false
     * first      | 先頭につける | false
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @param       string $column_name カラム名
     * @param       string $type
     * @param       array $options オプション設定 OPTIONAL:array
     * @return      void
     * @since       3.4.0
     */
    protected function addColumn($table_name, $column_name, $type, $options = array())
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change' && !$this->is_up) {
            $this->Driver()->removeColumn($table_name, $column_name);
            return;
        }
        $this->Driver()->addColumn($table_name, $column_name, $type, $options);
    }
    /* ----------------------------------------- */

    /**
     * +-- インデックスを作成する
     *
     * オプション | 説明 | デフォルト
     * ---------- | ---- | ----------
     * name       | インデックスの名前 |
     * unique     | trueを指定するとユニークなインデックス | false
     * primary    | trueを指定すると主キー | false
     * index_type | インデックスの種類を指定する | INDEX
     * length     | インデックスに含まれるカラムの長さ |
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @param       string $column_name カラム名
     * @param       array $options オプション設定 OPTIONAL:array
     * @return      void
     * @since       3.4.0
     */
    protected function addIndex($table_name, $column_name, $options = array())
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change' && !$this->is_up) {
            $this->Driver()->removeIndex($table_name, $options );
            return;
        }
        $this->Driver()->addIndex($table_name, $column_name, $options);
    }
    /* ----------------------------------------- */


    /**
     * +-- タイムスタンプを追加する
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @return      void
     * @since       3.4.0
     */
    protected function addTimestamps($table_name)
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change' && !$this->is_up) {
            $this->Driver()->removeTimestamps($table_name);
            return;
        }
        $this->Driver()->addTimestamps($table_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- カラムの変更
     *
     * オプション | 説明 | デフォルト
     * ---------- | ---- | ----------
     * limit      | カラムの桁数を指定 |
     * default    | デフォルト値を指定 |
     * null       | null値を許可するか | true
     * not_null   | null値を許可しないか | false
     * precision  | decimal 型の精度を指定 |
     * scale      | decimal 型の小数点以下の桁数 |
     * auto_increment | オートインクリメントにする |
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @param       string $column_name カラム名
     * @param       string $type データ型
     * @param      array $options オプション設定 OPTIONAL:array
     * @return      void
     * @since       3.4.0
     */
    protected function changeColumn($table_name, $column_name, $type, $options = array())
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change') {
            throw new exception (__FUNCTION__.' は change 内で使用できません。');
        }
        $this->Driver()->changeColumn($table_name, $column_name, $type, $options);
    }
    /* ----------------------------------------- */

    /**
     * +-- カラムの初期値を設定
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @param       string $column_name カラム名
     * @param       var_text $default_val
     * @return      void
     * @since       3.4.0
     */
    protected function changeColumnDefault($table_name, $column_name, $default_val)
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change') {
            throw new exception (__FUNCTION__.' は change 内で使用できません。');
        }
        $this->Driver()->changeColumnDefault($table_name, $column_name, $default_val);
    }
    /* ----------------------------------------- */

    /**
     * +-- テーブルを作成する
     *
     *
     * オプション | 説明 | デフォルト
     * ---------- | ---- | ----------
     * schema     | カラムオプション |
     * engine     | ストレージエンジン(Mysqlのみ) | InnoDB
     * force      | テーブルを作成前に、既存のテーブルを削除 | false
     *
     * カラムオプション | 説明 | デフォルト
     * ---------------- | ---- | ----------
     * type             | カラムのデータ型 |
     * limit            | カラムの桁数を指定 |
     * default          | デフォルト値を指定 |
     * null             | null値を許可するか | true
     * not_null         | null値を許可しないか | false
     * precision        | decimal 型の精度を指定 |
     * scale            | decimal 型の小数点以下の桁数 |
     * primary          | 主キーをセットする |
     * auto_increment   | オートインクリメントにする | false
     * index            | インデックス名の配列 |
     * unique           | UNIQUEインデックス名の配列 |
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @param      array $options オプション設定 OPTIONAL:array
     * @return      void
     * @since       3.4.0
     */
    protected function createTable($table_name, $options = array())
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change' && !$this->is_up) {
            $this->Driver()->dropTable($table_name);
            return;
        }
        $this->Driver()->createTable($table_name, $options);
    }
    /* ----------------------------------------- */

    /**
     * +-- テーブルを削除する
     *
     * オプション | 説明 | デフォルト
     * ---------- | ---- | ----------
     * force      | テーブルを作成前に、既存のテーブルを削除 | false
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @param       array $options オプション設定 OPTIONAL:array
     * @return      void
     * @since       3.4.0
     */
    protected function dropTable($table_name, $options = array())
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change') {
            throw new exception (__FUNCTION__.' は change 内で使用できません。');
        }
        $this->Driver()->dropTable($table_name, $options);
    }
    /* ----------------------------------------- */

    /**
     * +-- カラムを削除する
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @param       string $column_name カラム名s
     * @return      void
     * @since       3.4.0
     */
    protected function removeColumn($table_name, $column_name)
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change') {
            throw new exception (__FUNCTION__.' は change 内で使用できません。');
        }
        $this->Driver()->removeColumn($table_name, $column_name);
    }
    /* ----------------------------------------- */


    /**
     * +-- インデックスを消去します
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @param      array $options オプション設定 OPTIONAL:array
     * @return      void
     * @since       3.4.0
     */
    protected function removeIndex($table_name, $options = array())
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change') {
            throw new exception (__FUNCTION__.' は change 内で使用できません。');
        }
        $this->Driver()->removeIndex($table_name, $options);
    }
    /* ----------------------------------------- */

    /**
     * +-- タイムスタンプを消去します
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @return      void
     * @since       3.4.0
     */
    protected function removeTimestamps($table_name)
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change' && !$this->is_up) {
            $this->Driver()->addTimestamps($table_name);
            return;
        }
        $this->Driver()->removeTimestamps($table_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- カラムをリネームします
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @param       string $column_name カラム名
     * @param       var_text $new_column_name
     * @return      void
     * @since       3.4.0
     */
    protected function renameColumn($table_name, $column_name, $new_column_name)
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change' && !$this->is_up) {
            $this->Driver()->renameColumn($table_name, $new_column_name, $column_name);
            return;
        }
        $this->Driver()->renameColumn($table_name, $column_name, $new_column_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- インデックスをリネームします
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @param       var_text $old_name
     * @param       var_text $new_name
     * @return      void
     * @since       3.4.0
     */
    protected function renameIndex($table_name, $old_name, $new_name)
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change' && !$this->is_up) {
            $this->Driver()->renameColumn($table_name, $new_name, $old_name);
            return;
        }
        $this->Driver()->renameIndex($table_name, $old_name, $new_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- テーブルをリネームします
     *
     * @doc_enable
     * @access      protected
     * @param       string $table_name テーブル名
     * @param       var_text $new_name
     * @return      void
     * @since       3.4.0
     */
    protected function renameTable($table_name, $new_name)
    {
        list(, $trace) = debug_backtrace();
        if ($trace['function'] === 'change' && !$this->is_up) {
            $this->Driver()->renameTable($new_name, $table_name);
            return;
        }
        $this->Driver()->renameTable($table_name, $new_name);
    }
    /* ----------------------------------------- */



}
