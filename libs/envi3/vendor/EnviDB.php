<?php
/**
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 * DIから呼ばれるクラス
 *
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class DBInstance
{
    private $_system_conf;
    public function __construct($config)
    {
        $this->_system_conf = $config;
    }

    public function getInstance($db_key)
    {
        if (!isset($this->_system_conf[$db_key])) {
            throw new EnviException("DB: {$db_key}が存在してません。");
        }
        return DB::getConnection($this->_system_conf[$db_key]['params'], $db_key);
    }
}

/**
 * pearDB風のインスタンスを提供するためのラッパー
 *
 */
class DB
{
    const AUTOQUERY_INSERT = 1;
    const AUTOQUERY_UPDATE = 2;
    const AUTOQUERY_REPLACE = 3;

    private static $connections = array();


    /**
     * +-- Enviから呼ばれるメソッド。必ず作る
     *
     * @access public
     * @static
     * @params  $param
     * @params  $instance_name
     * @return EnviDBIBase
     */
    public static function getConnection($param, $instance_name)
    {
        if ($param['connection_pool']) {
            if (!isset(self::$connections[$instance_name])) {
                parse_str($param['dsn'], $conf);
                self::$connections[$instance_name] = self::connect($conf);
                if ($param['initialize_query']) {
                    self::$connections[$instance_name]->query($param['initialize_query']);
                }
            }
            return self::$connections[$instance_name];
        }
        parse_str($param['dsn'], $conf);
        $dbi = self::connect($conf);
        if ($param['initialize_query']) {
            $dbi->query($param['initialize_query']);
        }
        return $dbi;
    }
    /* ----------------------------------------- */

    /**
     * +-- EnviDBIBaseを取得する
     *
     * @access public
     * @static
     * @params  $dsn
     * @params  $user OPTIONAL:false
     * @params  $password OPTIONAL:false
     * @return EnviDBIBase
     */
    public static function connect($dsn, $user = false, $password = false)
    {
        if ($user === false) {
            return new EnviDBIBase($dsn, '', '');
        } else {
            return new EnviDBIBase($dsn, $user, $password);
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- ダミー
     *
     * @static
     * @params & $obj
     * @return boolean
     */
    public static function isError(&$obj)
    {
        return false;
    }
    /* ----------------------------------------- */
}


/**
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class EnviDBIBase
{
    protected $default_fetch_mode;
    protected $PDO;
    public $last_query;
    public $is_tran;
    protected $tran_count = 0;

    /**
     * +-- PDOオブジェクトを返す
     *
     * @access public
     * @return PDO
     */
    public function &PDO()
    {
        return $this->PDO;
    }
    /* ----------------------------------------- */

    /**
     * クオートする
     *
     * @access public
     * @params mixied $str クオートするデータ
     * @return string
     */
    public function quotesmart($str)
    {
        if (is_int($str)) {
            return $this->PDO->quote($str, PDO::PARAM_INT);
        } elseif ($str === NULL ) {
            return $this->PDO->quote($str, PDO::PARAM_NULL);
        } else {
            return $this->PDO->quote($str, PDO::PARAM_STR);
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- 文字列をエスケープする
     *
     * @access public
     * @params mixied $str クオートするデータ
     * @return string
     */
    public function quote($str)
    {
        return $this->quotesmart($str);
    }
    /* ----------------------------------------- */

    /**
     * +-- インスタンス全体のフェッチモードを指定する
     *
     * @access public
     * @params  $fetch_mode
     * @return void
     */
    public function setFetchMode($fetch_mode)
    {
        $this->default_fetch_mode = $fetch_mode;
    }
    /* ----------------------------------------- */

    /**
     * +-- 最後にインサートされたIDを返す
     *
     * @access public
     * @params  $name OPTIONAL:NULL
     * @return integer|boolean
     */
    public function lastInsertId($name = NULL)
    {
        return $this->PDO->lastInsertId($name);
    }
    /* ----------------------------------------- */


    /**
     * +-- PDO::prepare()へのラッパー
     *
     * @access public
     * @params string $statement sql
     * @params array $driver_options OPTIONAL:array
     * @return PDOStatement
     */
    public function &prepare($statement, array $driver_options = array())
    {
        $this->last_query = $statement;
        $pdos = $this->PDO->prepare($statement, $driver_options);
        $pdos->setFetchMode($this->default_fetch_mode);
        return $pdos;
    }
    /* ----------------------------------------- */



    /**
     * +-- PDOS::execute()へのラッパー
     *
     * @access public
     * @params PDOStatement $pdos
     * @params array $driver_options OPTIONAL:array
     * @return PDOStatement
     */
    public function &execute(PDOStatement $pdos, array $driver_options = array())
    {
        foreach ($driver_options as $key => $value) {
            $pdos->bindValue ($key+1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $pdos->execute();
        $this->last_query = $pdos->queryString;
        return $pdos;
    }
    /* ----------------------------------------- */

    /**
     * +-- バインドメカニズムを利用出来るようにした、query
     *
     * 第二引数に何も入れなければ、単にPDO::query()へのrapperとなります
     *
     * @access public
     * @params string $statement sql
     * @params array $bind bindする値 OPTIONAL:array
     * @return PDOStatement
     */
    public function &query($statement, array $bind = array())
    {
        $this->last_query = $statement;
        if (is_null($bind)) {
            $pdos = $this->PDO->query($statement);
            $pdos->setFetchMode($this->default_fetch_mode);
        } else {
            $pdos = $this->execute($this->prepare($statement), $bind);
        }
        $this->last_query = $pdos->queryString;
        return $pdos;
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行したクエリの結果を配列ですべて返します
     *
     * @access public
     * @params string $statement SQL
     * @params array $bind OPTIONAL:array
     * @params integer $fetch_mode OPTIONAL:false
     * @return array
     */
    public function getAll($statement, array $bind = array(), $fetch_mode = false)
    {
        $pdos = $this->query($statement, $bind);
        $fetch_mode = $fetch_mode === false ? $this->default_fetch_mode : $fetch_mode;
        return $pdos->fetchAll($fetch_mode);
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行したクエリの結果を配列で一行返します
     *
     * @access public
     * @params string $statement SQL
     * @params array $bind OPTIONAL:array
     * @params integer $fetch_mode OPTIONAL:false
     * @return array
     */
    public function getRow($statement, array $bind = array(), $fetch_mode = false)
    {
        $pdos = $this->query($statement, $bind);
        $fetch_mode = $fetch_mode === false ? $this->default_fetch_mode : $fetch_mode;
        return $pdos->fetch($fetch_mode);
    }
    /* ----------------------------------------- */


    /**
     * +-- 実行したクエリの結果を1カラム分だけ返します
     *
     * @access public
     * @params string $statement SQL
     * @params array $bind OPTIONAL:array
     * @return string
     */
    public function getOne($statement, array $bind = array())
    {
        $pdos = $this->query($statement, $bind);
        return $pdos->fetchColumn(0);
    }
    /* ----------------------------------------- */



    /**
     * +-- 実行したクエリの結果を配列で縦1行返します
     *
     * @access public
     * @params string $statement SQL
     * @params  $col OPTIONAL:0
     * @params array $bind OPTIONAL:array
     * @return array
     */
    public function getCol($statement, $col = 0, array $bind = array())
    {
        $pdos = $this->query($statement, $bind);

        while (($row = $pdos->fetchColumn($col)) !== false) {
            $res[] = $row;
        }
        return $res;
    }
    /* ----------------------------------------- */

    /**
     * +-- クエリでマッチした数を返します
     *
     * @access public
     * @params string $statement SQL
     * @params array $bind OPTIONAL:array
     * @return integer
     */
    public function count($statement, array $bind = array())
    {
        $pdos = $this->query($statement, $bind);
        $fetch_mode = $fetch_mode === false ? $this->default_fetch_mode : $fetch_mode;
        return $pdos->rowCount();
    }
    /* ----------------------------------------- */


    /**
     * +-- Transaction開始
     *
     * @access public
     * @return boolean
     */
    public function beginTransaction()
    {
        $this->tran_count++;
        if ($this->is_tran) {
            return true;
        }
        $this->is_tran = true;
        return $this->PDO->beginTransaction();
    }
    /* ----------------------------------------- */

    /**
     * +-- トランザクションのロールバック
     *
     * @access public
     * @return boolean
     */
    public function rollback()
    {
        $this->is_tran = false;
        $this->tran_count = 0;
        return $this->PDO->rollback();
    }
    /* ----------------------------------------- */

    /**
     * +-- トランザクションのコミット
     *
     * @access public
     * @return boolean
     */
    public function commit()
    {
        if (!$this->is_tran) {
            return;
        }
        if (--$this->tran_count === 0) {
            $this->is_tran = false;
            return $this->PDO->commit();
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- INSERT文やREPLACE分、UPDATE文を配列から実行する
     *
     * @access public
     * @params string $table テーブル名
     * @params array $table_fields フィールドの配列
     * @params integer $mode OPTIONAL:DB::AUTOQUERY_INSERT
     * @params string $where UPDATE時のWHERE文 OPTIONAL:false
     * @return PDOStatement
     */
    public function autoExecute($table, array $table_fields, $mode = DB::AUTOQUERY_INSERT, $where = false)
    {
        $sql = $this->buildManipSQL($table, $table_fields, $mode, $where);
        return $this->query($sql, $table_fields);
    }
    /* ----------------------------------------- */

    /**
     * +-- トランザクション中かどうか
     *
     * @access public
     * @return boolean
     */
    public function isTran()
    {
        return $this->is_tran;
    }
    /* ----------------------------------------- */

    /**
     * +-- トランザクション中かどうか
     *
     * @access public
     * @return boolean
     */
    public function inTransaction()
    {
        return $this->is_tran;
    }
    /* ----------------------------------------- */

    /**
     * +-- トランザクションのネスト回数
     *
     * @access public
     * @return integer
     */
    public function transactionCount()
    {
        return $this->tran_count;
    }
    /* ----------------------------------------- */


    /**
     * +-- 接続解除
     *
     * @access public
     * @return void
     */
    public function disconnect()
    {
        if ($this->is_tran) {
            $this->rollback();
        }
        unset($this->PDO);
    }
    /* ----------------------------------------- */

    private function buildManipSQL(&$table, &$table_fields, &$mode, &$where)
    {
        if (count($table_fields) == 0) {
            return $this->raiseError(DB_ERROR_NEED_MORE_DATA);
        }
        $first = true;
        $arr = array();
        switch ($mode) {
        case DB::AUTOQUERY_INSERT:
            $values = '';
            $names = '';
            foreach ($table_fields as $key => $value) {
                $key = trim($key);
                if ($first) {
                    $first = false;
                } else {
                    $names .= ',';
                    $values .= ',';
                }
                $names .= '`'.$key.'`';
                $values .= '?';
                $arr[] = $value;
            }
            $table_fields = $arr;
            return "INSERT INTO $table ($names) VALUES ($values)";
        case DB::AUTOQUERY_REPLACE:
            $values = '';
            $names = '';
            foreach ($table_fields as $key => $value) {
                $key = trim($key);
                if ($first) {
                    $first = false;
                } else {
                    $names .= ',';
                    $values .= ',';
                }
                $names .= '`'.$key.'`';
                $values .= '?';
                $arr[] = $value;
            }
            $table_fields = $arr;
            return "REPLACE INTO $table ($names) VALUES ($values)";
        case DB::AUTOQUERY_UPDATE:
            $set = '';
            foreach ($table_fields as $key => $value) {
                $key = trim($key);
                if ($first) {
                    $first = false;
                } else {
                    $set .= ',';
                }
                $set .= "`$key` = ?";
                $arr[] = $value;
            }
            $sql = "UPDATE $table SET $set";
            if ($where) {
                $sql .= " WHERE $where";
            }
            $table_fields = $arr;
            return $sql;
        default:
            throw new PDOException;
        }
    }

    /**
     * +-- コンストラクタ
     *
     * @access public
     * @params  $dsn
     * @params  $username OPTIONAL:''
     * @params  $password OPTIONAL:''
     * @params  $driver_options OPTIONAL:array
     * @return void
     */
    public function __construct($dsn, $username = '', $password = '', $driver_options = array())
    {
        if (is_array($dsn)) {
            $username = $dsn['username'];
            $password = $dsn['password'];
            $dsn = $dsn['phptype'].':dbname='.$dsn['database'].';host='.$dsn['hostspec'];
        }
        $this->PDO = new PDO($dsn, $username, $password, $driver_options);
        // エラーモードを修正する
        $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $this->setFetchMode(PDO::FETCH_ASSOC);
    }
    /* ----------------------------------------- */

    /**
     * +-- デストラクタ
     *
     * @access public
     * @return void
     */
    public function __destruct()
    {
        $this->disconnect();
    }
    /* ----------------------------------------- */
}