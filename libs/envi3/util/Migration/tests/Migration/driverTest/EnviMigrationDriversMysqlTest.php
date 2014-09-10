<?php
/**
 *
 *
 *
 * PHP versions 5
 *
 *

 *
 * @category   テスト
 * @package    テスト
 * @subpackage TestCode
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/c/man/v3/reference
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */

require_once dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR.'drivers'.DIRECTORY_SEPARATOR.'EnviMigrationDriversBase.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR.'drivers'.DIRECTORY_SEPARATOR.'EnviMigrationDriversMysql.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR.'EnviMigrationBase.php';

/**
 *
 *
 *
 *
 * @category   テスト
 * @package    テスト
 * @subpackage TestCode
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/c/man/v3/reference
 * @since      File available since Release 1.0.0
 */
class EnviMigrationDriversMysqlTest extends testCaseBase
{
    /**
     * +-- 初期化
     *
     * @access public
     * @return void
     */
    public function initialize()
    {
        $this->free();

    }
    /* ----------------------------------------- */


    public function dataProvider()
    {
        $mock = EnviMock::mock('EnviMigrationMock');
        $migration = new EnviMigrationMock;
        $EnviMigrationDriversMysql = new EnviMigrationDriversMysql($migration);
        return array(($EnviMigrationDriversMysql));
    }

    /**
     * +--
     *
     * @cover EnviMigrationDriversMysql::renameTable
     * @dataProvider    dataProvider
     * @access      public
     * @return      void
     */
    public function renameTableTest($driver)
    {
        $mock = EnviMock::mock('EnviMigrationDriversBase');
        $mock->shouldReceive('query')
            ->with('RENAME TABLE `foo` TO `bar`')
            ->once()
            ->andReturnNull();
        $driver->renameTable('foo', 'bar');
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @cover EnviMigrationDriversMysql::addTimestamps
     * @dataProvider    dataProvider
     * @access      public
     * @return      void
     */
    public function addTimestampsTest($driver)
    {
        $mock = EnviMock::mock('EnviMigrationDriversBase');
        $mock->shouldReceive('query')
            ->with('ALTER TABLE `foo` ADD `time_stamp` timestamp NOT NULL')
            ->once()
            ->andReturnNull();
        $driver->addTimestamps('foo', 'bar');
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @cover EnviMigrationDriversMysql::dropTable
     * @dataProvider    dataProvider
     * @access      public
     * @return      void
     */
    public function dropTableTest($driver)
    {
        $mock = EnviMock::mock('EnviMigrationDriversBase');
        $mock->shouldReceive('query')
            ->with('DROP TABLE `foo`')
            ->once()
            ->andReturnNull();
        $driver->dropTable('foo', array());
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @cover EnviMigrationDriversMysql::removeTimestamps
     * @dataProvider    dataProvider
     * @access      public
     * @return      void
     */
    public function removeTimestampsTest($driver)
    {
        $mock = EnviMock::mock('EnviMigrationDriversBase');
        $mock->shouldReceive('query')
            ->with('ALTER TABLE `foo` DROP `time_stamp`')
            ->once()
            ->andReturnNull();
        $driver->removeTimestamps('foo', array());
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @cover EnviMigrationDriversMysql::addIndex
     * @dataProvider    dataProvider
     * @access      public
     * @return      void
     */
    public function addIndexTest($driver)
    {
        $mock = EnviMock::mock('EnviMigrationDriversBase');
        $mock->shouldReceive('query')
            ->with('ALTER TABLE `foo` ADD INDEX idx_column_index (`column_1`, `column_2`)')
            ->once()
            ->andReturnNull();
        $driver->addIndex('foo', array('column_1', 'column_2'), array('name' => 'idx_column_index'));

        $this->code_coverage->finish();
        $this->code_coverage->start();

        $mock->shouldReceive('query')
            ->with('ALTER TABLE `foo` ADD INDEX  (`column_1`)')
            ->once()
            ->andReturnNull();
        $driver->addIndex('foo', 'column_1', array());



        $this->code_coverage->finish();
        $this->code_coverage->start();

        $mock->shouldReceive('query')
            ->with('ALTER TABLE `foo` ADD PRIMARY KEY  (`column_3`)')
            ->once()
            ->andReturnNull();
        $driver->addIndex('foo', 'column_3', array('primary' => true));


        $this->code_coverage->finish();
        $this->code_coverage->start();

        $mock->shouldReceive('query')
            ->with('ALTER TABLE `foo` ADD PRIMARY KEY  (`column_4`)')
            ->once()
            ->andReturnNull();
        $driver->addIndex('foo', 'column_4', array('index_type' => 'primary'));

        $this->code_coverage->finish();
        $this->code_coverage->start();



        $mock->shouldReceive('query')
            ->with('ALTER TABLE `foo` ADD UNIQUE uq_column_index (`column_1`, `column_2`)')
            ->once()
            ->andReturnNull();
        $driver->addIndex('foo', array('column_1', 'column_2'), array('name' => 'uq_column_index', 'unique' => true));

        $this->code_coverage->finish();
        $this->code_coverage->start();


        $mock->shouldReceive('query')
            ->with('ALTER TABLE `foo` ADD UNIQUE uq_column_index (`column_1`, `column_2`)')
            ->once()
            ->andReturnNull();
        $driver->addIndex('foo', array('column_1', 'column_2'), array('name' => 'uq_column_index', 'index_type' => 'unique'));

        $this->code_coverage->finish();
        $this->code_coverage->start();

    }
    /* ----------------------------------------- */


    /**
     * +-- 終了処理
     *
     * @access public
     * @return void
     */
    public function shutdown()
    {
    }

}
