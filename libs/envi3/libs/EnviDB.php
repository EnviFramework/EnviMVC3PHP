<?php
/**
 * @package Envi3
 * @subpackage
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

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


class EnviDBIBase
{
    protected $default_fetch_mode;
    protected $PDO;
    public $last_query;
    public $is_tran;

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

    public function &PDO()
    {
        return $this->PDO;
    }

    /**
     * クオートする
     *
     * @param $str クオートする文字列
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

    public function quote($str)
    {
        return $this->quotesmart($str);
    }

    /**
     * インスタンス全体のフェッチモードを指定する
     *
     */
    public function setFetchMode($fetch_mode)
    {
        $this->default_fetch_mode = $fetch_mode;
    }


    public function lastInsertId($name = NULL)
    {
        return $this->PDO->lastInsertId($name);
    }

    /**
     * PDO::prepare()へのラッパー
     *
     * デフォルトフェッチモードの有効
     *
     */
    public function &prepare($statement, $driver_options = array())
    {
        $this->last_query = $statement;
        $pdos = $this->PDO->prepare($statement, $driver_options);
        $pdos->setFetchMode($this->default_fetch_mode);
        return $pdos;
    }


    /**
     * PDOS::execute()へのラッパー
     *
     * デフォルトフェッチモードの有効
     *
     */
    public function execute(PDOStatement $pdos, $driver_options = array())
    {
        foreach ($driver_options as $key => $value) {
            $pdos->bindValue ($key+1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $pdos->execute();
        $this->last_query = $pdos->queryString;
        return $pdos;
    }

    /**
     * バインドメカニズムを利用出来るようにした、query
     *
     * 第二引数に何も入れなければ、単にPDO::query()へのrapperとなります
     *
     * @param $statement string SQL
     * @param $bind array bindする値
     */
    public function &query($statement, $bind = array())
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

    /**
     * 実行したクエリの結果を配列ですべて返します
     *
     *
     * @param $statement string SQL
     * @param $bind array bindする値
     * @param $fetch_mode int フェッチモード
     */
    public function getAll($statement, $bind = array(), $fetch_mode = false)
    {
        $pdos = $this->query($statement, $bind);
        $fetch_mode = $fetch_mode === false ? $this->default_fetch_mode : $fetch_mode;
        return $pdos->fetchAll($fetch_mode);
    }

    /**
     * 実行したクエリの結果を配列で一行返します
     *
     *
     * @param $statement string SQL
     * @param $bind array bindする値
     * @param $fetch_mode int フェッチモード
     */
    public function getRow($statement, $bind = array(), $fetch_mode = false)
    {
        $pdos = $this->query($statement, $bind);
        $fetch_mode = $fetch_mode === false ? $this->default_fetch_mode : $fetch_mode;
        return $pdos->fetch($fetch_mode);
    }


    /**
     * 実行したクエリの結果を配列で一行返します
     *
     *
     * @param $statement string SQL
     * @param $bind array bindする値
     * @param $fetch_mode int フェッチモード
     */
    public function getOne($statement, $bind = array(), $fetch_mode = false)
    {
        $pdos = $this->query($statement, $bind);
        return $pdos->fetchColumn(0);
    }

    /**
     * 実行したクエリの結果を配列で縦1行返します
     *
     *
     * @param $statement string SQL
     * @param $bind array bindする値
     */
    public function getCol($statement, $col = 0, $bind = array())
    {
        $pdos = $this->query($statement, $bind);

        while (($row = $pdos->fetchColumn($col)) !== false) {
            $res[] = $row;
        }
        return $res;
    }

    /**
     * クエリでマッチした数を返します
     *
     * @param $statement string SQL
     * @param $bind array bindする値
     */
    public function count($statement, $bind = array())
    {
        $pdos = $this->query($statement, $bind);
        $fetch_mode = $fetch_mode === false ? $this->default_fetch_mode : $fetch_mode;
        return $pdos->rowCount();
    }

    public function ngram($str, $gram = 4)
    {
        $str = mb_convert_kana($str, "KVsnR");
        $str = str_replace(array('+', '-',' ','　', "\r", "\n"), array('＋', '－', '', '', '', ''), $str);
        $i = 0;
        $arr = array();
        $leng = mb_strlen($str) - $gram+1;
        $i = 0;
        while ($i < $leng) {
            $arr[] = mb_substr($str, $i++, $gram);
        }
        return $arr;
    }

    public function beginTransaction()
    {
        if ($this->is_tran) {
            return true;
        }
        $this->is_tran = true;
        return $this->PDO->beginTransaction();
    }

    public function rollback()
    {
        $this->is_tran = false;
        return $this->PDO->rollback();
    }

    public function commit()
    {
        if ($this->is_tran) {
            $this->is_tran = false;
            return $this->PDO->commit();
        }
    }

    public function disconnect()
    {
        unset($this->PDO);
    }


    public function autoExecute($table, $table_fields, $mode = DB::AUTOQUERY_INSERT, $where = false)
    {
        $sql = $this->buildManipSQL($table, $table_fields, $mode, $where);
        return $this->query($sql, $table_fields);
    }

    public function isTran()
    {
        return $this->is_tran;
    }

    public function inTransaction()
    {
        return $this->is_tran;
    }


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
}
