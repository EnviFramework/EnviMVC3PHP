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
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 1.0.0
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
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 1.0.0
 */
class EnviMigrationDriversMysql extends EnviMigrationDriversBase
{
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
     * primary    | 主キーをセットする |
     * auto_increment | オートインクリメントにする |
     *
     *
     * @access      public
     * @param       string $table_name
     * @param       string $column_name
     * @param       string $type
     * @param       array $options OPTIONAL:array
     * @return      void
     */
    public function addColumn($table_name, $column_name, $type, array $options = array())
    {
        if (isset($option['limit'])) {
            $type .= "({$option['limit']})";
        } elseif (isset($option['precision']) && isset($option['scale'])) {
            $type .= "({$option['precision']}, {$option['scale']})";
        }
        $sql = "ALTER TABLE  `{$table_name}` ADD  `{$column_name}` {$type} ";

        if (isset($options['not_null']) && $options['not_null']) {
            $sql .= "  NOT NULL ";
        } elseif (isset($options['null']) && $options['null'] === false) {
            $sql .= "  NOT NULL ";
        }


        if (isset($options['auto_increment'])) {
            $sql .= ' AUTO_INCREMENT';
        } elseif (isset($options['default'])) {
            $sql .= ' DEFAULT ';
            $sql .= (strtolower($options['default']) === 'null' && !isset($options['not_null'])) ? 'NULL' : '"'.$options['default'].'"';
        }
        if (isset($options['primary']) || isset($options['auto_increment'])) {
            $sql .= ' PRIMARY KEY ';
        }


        if (isset($options['after'])) {
            $sql .= " AFTER  `{$options['after']}` ";
        }
        if (isset($options['first']) && $options['first']) {
            $sql .= " FIRST ";
        }
        $this->query($sql);
    }
    /* ----------------------------------------- */

    /**
     * +-- インデックスを作成する
     *
     * オプション | 説明 | デフォルト
     * ---------- | ---- | ----------
     * name       | インデックスの名前
     * unique     | trueを指定するとユニークなインデックス | false
     * primary    | trueを指定すると主キー | false
     * index_type | インデックスの種類を指定する | INDEX
     * length     | インデックスに含まれるカラムの長さ
     *
     * @access      public
     * @param       var_text $table_name
     * @param       var_text $column_name
     * @param       array $options OPTIONAL:array
     * @return      void
     */
    public function addIndex($table_name, $column_name, array $options = array())
    {
        if (is_array($column_name)) {
            $column_name = join(',', $column_name);
        }
        $index_name = '';

        if (isset($options['name'])) {
            $index_name = $options['name'];
        }
        $index_type = 'INDEX';

        if (isset($options['primary'])) {
            $index_type = 'PRIMARY KEY';
        } elseif (isset($options['index_type']) && strtolower($options['index_type']) === 'primary') {
            $index_type = 'PRIMARY KEY';
        }

        if (isset($options['unique'])) {
            $index_type = 'UNIQUE';
        } elseif (isset($options['index_type']) && strtolower($options['index_type']) === 'unique') {
            $index_type = 'UNIQUE';
        }


        $sql = "ALTER TABLE `{$table_name}` ADD {$index_type} {$index_name}( {$column_name} )";
        $this->query($sql);
    }
    /* ----------------------------------------- */

    /**
     * +-- タイムスタンプを追加する
     *
     * @access      public
     * @param       var_text $table_name
     * @return      void
     */
    public function addTimestamps($table_name)
    {
        $sql = "ALTER TABLE  `{$table_name}` ADD  `time_stamp` timestamp NOT NULL ";
        $this->query($sql);
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
     * @access      public
     * @param       var_text $table_name
     * @param       var_text $column_name
     * @param       var_text $type
     * @param       var_text $options OPTIONAL:array
     * @return      void
     */
    public function changeColumn($table_name, $column_name, $type, $options = array())
    {
        $sql = 'SHOW COLUMNS FROM {$table_name} WHERE Field LIKE :column_name';
        $res = $this->DBI()->getRow($sql, array('column_name' => $column_name));



        if (isset($option['limit'])) {
            $type .= "({$option['limit']})";
        } elseif (isset($option['precision']) && isset($option['scale'])) {
            $type .= "({$option['precision']}, {$option['scale']})";
        }

        $sql = 'ALTER TABLE {$table_name} CHANGE {$column_name} {$table_name} ';
        $sql .= $type;
        if (isset($options['null']) && $options['null'] === true) {
        } elseif (isset($res['Null']) && $res['Null'] === 'No') {
            $sql .= "  NOT NULL ";
            $res['not_null'] = true;
        } elseif (isset($options['null']) && $options['null'] === false) {
            $sql .= "  NOT NULL ";
            $res['not_null'] = true;
        } elseif (isset($options['not_null']) && $options['not_null'] === true) {
            $sql .= "  NOT NULL ";
            $res['not_null'] = true;
        }
        // auto_increment
        $auto_increment = false;
        if (isset($options['auto_increment']) && $options['auto_increment'] === true) {
            $auto_increment = true;
        } elseif (isset($options['auto_increment']) && $options['auto_increment'] === false) {
        } elseif (isset($res['Extra']) && $res['Extra'] === 'auto_increment') {
            $auto_increment = true;
        }
        if ($auto_increment) {
            $sql .= ' AUTO_INCREMENT';
        } elseif (isset($options['default']) && strlen($res['default'])) {
            $sql .= (strtolower($options['default']) === 'null' && !isset($options['not_null'])) ? 'NULL' : '"'.$options['default'].'"';
        } elseif (isset($res['Default']) && strlen($res['Default'])) {
            $sql .= ' DEFAULT ';
            $sql .= (strtolower($res['Default']) === 'null' && !isset($res['not_null'])) ? 'NULL' : '"'.$res['Default'].'"';
        }

        $this->query($sql);
    }
    /* ----------------------------------------- */

    /**
     * +-- カラムの初期値を設定
     *
     * @access      public
     * @param       var_text $table_name
     * @param       var_text $column_name
     * @param       var_text $default_val
     * @return      void
     */
    public function changeColumnDefault($table_name, $column_name, $default_val)
    {
        $sql = 'SHOW COLUMNS FROM {$table_name} WHERE Field LIKE :column_name';
        $res = $this->DBI()->getRow($sql, array('column_name' => $column_name));

        $sql = 'ALTER TABLE {$table_name} CHANGE {$column_name} {$table_name} ';
        $sql .= $res['Type'];

        if (isset($res['Null']) && $res['Null'] === 'No') {
            $sql .= "  NOT NULL ";
            $res['not_null'] = true;
        }
        if (isset($res['Extra']) && $res['Extra'] === 'auto_increment') {
            $sql .= ' AUTO_INCREMENT';
        } elseif (isset($res['Default']) && strlen($res['Default'])) {
            $sql .= ' DEFAULT :default_val ';
        }

        $this->query($sql, array('default_val' => $default_val));
    }
    /* ----------------------------------------- */


    /**
     * +-- テーブルを作成する
     *
     *
     * オプション | 説明 | デフォルト
     * ---------- | ---- | ----------
     * schema     | カラムオプション |
     * engine     | ストレージエンジン | InnoDB
     * force      | テーブルを作成前に、既存のテーブルを削除 | InnoDB
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
     * auto_increment   | オートインクリメントにする |
     * index            | インデックス名の配列 |
     * unique           | UNIQUEインデックス名の配列 |
     *
     * @access      public
     * @param       var_text $table_name
     * @param       var_text $options OPTIONAL:array
     * @return      void
     */
    public function createTable($table_name, $options = array())
    {
        $index = array();
        $unique = array();
        $primary = array();
        $comma = '';

        if (isset($options['force'])) {
            $sql = "DROP TABLE IF EXISTS `{$table_name}`";
            $this->query($sql);
        }

        $sql = "CREATE TABLE `{$table_name}` (\n";
        foreach ($options['schema'] as $column => $val) {

            if (isset($val['limit'])) {
                $val['type'] .= "({$val['limit']})";
            } elseif (isset($val['precision']) && isset($val['scale'])) {
                $val['type'] .= "({$val['precision']}, {$val['scale']})";
            }
            $sql .= $comma;
            $sql .= "`{$column}` {$val['type']} ";
            if (isset($val['not_null'])) {
                $sql .= 'NOT NULL ';
            }
            if (isset($val['auto_increment'])) {
                $sql .= ' AUTO_INCREMENT';
            } elseif (isset($val['default'])) {
                $sql .= ' DEFAULT ';
                $sql .= (strtolower($val['default']) === 'null' && !isset($val['not_null'])) ? 'NULL' : '"'.$val['default'].'"';
            }
            if (isset($val['index'])) {
                foreach ($val['index'] as $item) {
                    $index[$item][] = $column;
                }
            }
            if (isset($val['unique'])) {
                foreach ($val['unique'] as $item) {
                    $unique[$item][] = $column;
                }
            }
            if (isset($val['primary'])) {
                $primary[] = $column;
            }
            $comma = ",\n";
        }
        if (count($primary)) {
            $sql .= $comma.'PRIMARY KEY ('.join(',', $primary).')';
        }
        if (count($unique)) {
            foreach ($unique as $index_name => $idx_column) {
                $sql .= $comma.'UNIQUE KEY `'.$index_name.'` ('.join(',', $idx_column).')';
            }
        }
        if (count($index)) {
            foreach ($index as $index_name => $idx_column) {
                $sql .= $comma.'KEY `'.$index_name.'` ('.join(',', $idx_column).')';
            }
        }
        $engine = 'InnoDB';
        if (isset($options['engine'])) {
            $engine = $options['engine'];
        }
        $sql .= ") ENGINE={$engine};\n";
        $this->query($sql);
    }
    /* ----------------------------------------- */

    /**
     * +-- テーブルを削除する
     *
     * @access      public
     * @param       var_text $table_name
     * @param       var_text $options OPTIONAL:array
     * @return      void
     */
    public function dropTable($table_name, $options = array())
    {
        $sql = "DROP TABLE `{$table_name}`;";
        $this->query($sql);
    }
    /* ----------------------------------------- */

    /**
     * +-- カラムを削除する
     *
     * @access      public
     * @param       var_text $table_name
     * @param       var_text $column_names
     * @return      void
     */
    public function removeColumn($table_name, $column_names)
    {
        if (is_array($column_names)) {
            $sql = "ALTER TABLE `{$table_name}` ";
            $comma = '';
            foreach ($column_names as $column_name) {
                $sql .= $comma." DROP `{$column_name}`";
                $comma = ',';
            }

        } else {
            $sql = "ALTER TABLE `{$table_name}` DROP `{$column_names}`";
        }
        $this->query($sql);
    }
    /* ----------------------------------------- */

    /**
     * +-- インデックスを消去します
     *
     * @access      public
     * @param       var_text $table_name
     * @param       var_text $options OPTIONAL:array
     * @return      void
     */
    public function removeIndex($table_name, $options = array())
    {
        $sql = "ALTER TABLE `{$table_name}` DROP INDEX `{$options['name']}`";
        $this->query($sql);
    }
    /* ----------------------------------------- */

    /**
     * +-- タイムスタンプを消去します
     *
     * @access      public
     * @param       var_text $table_name
     * @return      void
     */
    public function removeTimestamps($table_name)
    {
        $sql = "ALTER TABLE `{$table_name}` DROP `time_stamp`";
        $this->query($sql);
    }
    /* ----------------------------------------- */

    /**
     * +-- カラムをリネームします
     *
     * @access      public
     * @param       var_text $table_name
     * @param       var_text $column_name
     * @param       var_text $new_column_name
     * @return      void
     */
    public function renameColumn($table_name, $column_name, $new_column_name)
    {
        $sql = 'SHOW COLUMNS FROM {$table_name} WHERE Field LIKE :column_name';
        $res = $this->DBI()->getRow($sql, array('column_name' => $column_name));

        $sql = 'ALTER TABLE {$table_name} CHANGE {$column_name} {$new_column_name} ';
        $sql .= $res['Type'];

        if (isset($res['Null']) && $res['Null'] === 'No') {
            $sql .= "  NOT NULL ";
            $res['not_null'] = true;
        }
        if (isset($res['Extra']) && $res['Extra'] === 'auto_increment') {
            $sql .= ' AUTO_INCREMENT';
        } elseif (isset($res['Default']) && strlen($res['Default'])) {
            $sql .= ' DEFAULT ';
            $sql .= (strtolower($res['Default']) === 'null' && !isset($res['not_null'])) ? 'NULL' : '"'.$res['Default'].'"';
        }


        $this->query($sql);
    }
    /* ----------------------------------------- */

    /**
     * +-- インデックスをリネームします
     *
     * @access      public
     * @param       var_text $table_name
     * @param       var_text $old_name
     * @param       var_text $new_name
     * @return      void
     */
    public function renameIndex($table_name, $old_name, $new_name)
    {
        $sql = 'SHOW INDEX FROM  `{$table_name}` WHERE Key_name LIKE :old_name';
        $res = $this->DBI()->getAll($sql, array('old_name' => $old_name));
        $column_name = array();
        foreach ($res as $row) {
            $column_name[] = $row['Column_name'];
        }
        $column_name = join(',', $column_name);

        $sql = 'ALTER TABLE  `{$table_name}` DROP INDEX  `{$old_name}` ,ADD INDEX  `{$new_name}` ( {$column_name} )';
        $this->query($sql);
    }
    /* ----------------------------------------- */

    /**
     * +-- テーブルをリネームします
     *
     * @access      public
     * @param       var_text $table_name
     * @param       var_text $new_name
     * @return      void
     */
    public function renameTable($table_name, $new_name)
    {
        $sql = "RENAME TABLE {$table_name} TO {$new_name} ;";
        $this->query($sql);
    }
    /* ----------------------------------------- */

}