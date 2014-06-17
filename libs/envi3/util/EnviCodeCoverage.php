<?php
/**
 * コードカバレッジ計測
 *
 * コードカバレッジをサポートするには Xdebug 2.1.3以降及び、
 * [tokenizer](http://www.php.net/manual/ja/tokenizer.installation.php)拡張モジュールが必要です。
 *
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage CodeCoverage
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release v3.3.3.5
 * @subpackage_main
 */
require_once dirname(__FILE__).'/EnviCodeParser.php';
/**
 * コードカバレッジ計測
 *
 *
 * コードカバレッジをサポートするには Xdebug 2.1.3以降及び、
 * [tokenizer](http://www.php.net/manual/ja/tokenizer.installation.php)拡張モジュールが必要です。
 *
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage CodeCoverage
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release v3.3.3.5
 */
class EnviCodeCoverage
{
    /**
     * @var EnviCodeCoverageDriver
     */
    private $driver;

    /**
     * @var EnviCodeCoverageFilter
     */
    private $filter;

    /**
     * @var EnviCodeCoverageParser
     */
    private $parser;

    /**
     * @var EnviCodeCoverageParser
     */
    private $is_nothing = false;


    /**
     * Code coverage data.
     *
     * @var array
     */
    private $coverage_data = array();

    const UN_USE_FLAG = -2;
    const COVERD     = 0;
    const NOT_COVERD = 1;
    const TOTAL_COVER = 1;

    /**
     * +-- コンストラクタ
     *
     * @access      private
     * @return      void
     */
    private function __construct()
    {
    }
    /* ----------------------------------------- */

    /**
     * +-- オブジェクトの精製
     *
     * @access      public
     * @static
     * @return      void
     */
    public static function factory()
    {
        $obj = new EnviCodeCoverage;
        $obj->initialize();
        return $obj;
    }
    /* ----------------------------------------- */

    /**
     * +-- 初期化
     *
     * @access      private
     * @return      void
     */
    private function initialize()
    {
        // @codeCoverageIgnoreStart
        if (!extension_loaded('xdebug')) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $res = dl('xdebug.dll');
            } else {
                $res = dl('xdebug.so');
            }
            if ($res) {
                throw new Exception('please install xdebug.http://pecl.php.net/package-changelog.php?package=xdebug');
            }
        }
        // @codeCoverageIgnoreEnd

        $this->driver = $this->subClassFactory('Driver');
        $this->filter = $this->subClassFactory('Filter');
        $this->parser = $this->subClassFactory('Parser');
        $this->filter->addBlackListByDirectory(dirname(__FILE__));
    }
    /* ----------------------------------------- */


    public function setCover(array $cover)
    {
        $this->driver->setCover($cover);
    }

    public function unSetCover()
    {
        $this->driver->unSetCover();
    }

    public function startNothing()
    {
        $this->finish();
        $this->is_nothing = true;
    }
    public function endNothing()
    {
        $this->is_nothing = false;
        $this->start();
    }

    /**
     * +-- ドライバオブジェクトを返す
     *
     * @access      public
     * @return      EnviCodeCoverageDriver
     */
    public function &driver()
    {
        return $this->driver;
    }
    /* ----------------------------------------- */

    /**
     * +-- フィルタオブジェクトを返す
     *
     * @access      public
     * @return      EnviCodeCoverageFilter
     */
    public function &filter()
    {
        return $this->filter;
    }
    /* ----------------------------------------- */

    /**
     * +-- パーサーオブジェクトを返す
     *
     * @access      public
     * @return      EnviCodeCoverageParser
     */
    public function &parser()
    {
        return $this->parser;
    }
    /* ----------------------------------------- */


    /**
     * +-- トレース開始
     *
     * @access      public
     * @return      void
     */
    public function start()
    {
        if ($this->is_nothing) {
            return;
        }
        $this->driver->start();
    }
    /* ----------------------------------------- */

    /**
     * +-- トレース終了
     *
     * @access      public
     * @return      void
     */
    public function finish()
    {
        if ($this->is_nothing) {
            return;
        }
        $data = $this->driver->finish();
        foreach ($data as $file_name => $coverage_data) {
            if (!isset($this->coverage_data[$file_name])) {
                $this->coverage_data[$file_name] = $coverage_data;
                continue;
            }
            foreach ($coverage_data as $line => $flag) {
                if (!isset($this->coverage_data[$file_name][$line]) || $this->coverage_data[$file_name][$line] <= 0) {
                    $this->coverage_data[$file_name][$line] = 1;
                } elseif ($this->coverage_data[$file_name][$line] > 0) {
                    $this->coverage_data[$file_name][$line] += 1;
                }
            }
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- 空にする
     *
     * @access      public
     * @return      void
     */
    public function free()
    {
        $this->coverage_data = array();
    }
    /* ----------------------------------------- */


    /**
     * +-- CodeCoverage詳細情報の取得
     *
     * @access      public
     * @param       var_text $add_white_list_file OPTIONAL:true
     * @return      array
     */
    public function getCodeCoverage($add_white_list_file = true)
    {
        if ($add_white_list_file) {
            $this->addWhiteListFiles();
        }
        $clone_coverage_data = $this->coverage_data;
        $cover_count = array(0, 0);
        $class_coverage_data = array();
        foreach ($clone_coverage_data as $file_name => &$coverage_data) {
            $epr = $this->parser->parseFile($file_name);
            $file_code_root_coverage = $epr->getCodeRouteCoverage();
            // フィルタ
            $skip_line = $this->parser->getSkipLine($file_name, array(), array());
            foreach ($skip_line as $line) {
                unset($file_code_root_coverage[$line]);
            }
            // トータルカバレッジ
            foreach ($file_code_root_coverage as $line => $total_cover) {
                $covered = isset($coverage_data[$line]) ? $coverage_data[$line] : 0;
                if ($covered < 0) {
                    $covered = 0;
                }
                $is_cover = $covered >= $total_cover;
                $cover_count[self::COVERD]       += min($covered, $total_cover);
                $cover_count[self::TOTAL_COVER]  += $total_cover;
                $coverage_data[$line] = array($covered, $total_cover, $is_cover);
            }
            foreach ($coverage_data as $line => $val) {
                if (!is_array($val)) {
                    unset($coverage_data[$line]);
                }
            }

            $class_list = $epr->getClassList();
            foreach ($class_list as $class_name => $class_item) {
                $line     = $class_item['token']->getLine();
                $end_line = $class_item['token']->getEndLine();
                $class_cover = array(
                    'class' => array(
                        'detail'      => array(),
                        'cover_count' => array(0, 0)
                        ),
                    'method' => array(),
                    'file_name' => $file_name,
                );
                while ($line <= $end_line) {
                    if (isset($coverage_data[$line])) {
                        $class_cover['class']['detail'][$line]                   = $coverage_data[$line];
                        $class_cover['class']['cover_count'][self::TOTAL_COVER] += $coverage_data[$line][self::TOTAL_COVER];
                        $class_cover['class']['cover_count'][self::COVERD]      += min($coverage_data[$line][self::TOTAL_COVER], $coverage_data[$line][self::COVERD]);
                    }
                    $line++;
                }
                // チェック行が0ならカバレッジ計測に使用しない。
                if ($class_cover['class']['cover_count'][self::TOTAL_COVER] === 0) {
                    continue;
                }
                $class_cover['class']['cover_rate'] = $class_cover['class']['cover_count'][self::TOTAL_COVER] === 0 ? 0 : ($class_cover['class']['cover_count'][self::COVERD]/$class_cover['class']['cover_count'][self::TOTAL_COVER]*100);
                $class_coverage_data[$class_name] = $class_cover;
                // メソッド
                foreach ($class_item['methods'] as $token) {
                    $line     = $token->getLine();
                    $end_line = $token->getEndLine();
                    $method = array(
                        'detail' => array(),
                        'cover_count' => array(0, 0)
                    );
                    while ($line <= $end_line) {
                        if (isset($coverage_data[$line])) {
                            $method['detail'][$line]                   = $coverage_data[$line];
                            $method['cover_count'][self::TOTAL_COVER] += $coverage_data[$line][self::TOTAL_COVER];
                            $method['cover_count'][self::COVERD]      += min($coverage_data[$line][self::TOTAL_COVER], $coverage_data[$line][self::COVERD]);
                        }
                        $line++;
                    }
                    $method['cover_rate'] = $method['cover_count'][self::TOTAL_COVER] === 0 ? 0 : ($method['cover_count'][self::COVERD]/$method['cover_count'][self::TOTAL_COVER]*100);
                    if ($method['cover_count'][self::TOTAL_COVER] > 0) {
                        $class_coverage_data[$class_name]['methods'][$token->getName()] = $method;
                    }

                }
            }
            unset($val);
        }
        unset($coverage_data);
        return array(
            'coverage_data_all'   => $clone_coverage_data,
            'class_coverage_data' => $class_coverage_data,
            'cover_count'         => $cover_count,
            'cover_rate'          => $cover_count[self::TOTAL_COVER] === 0 ? 0 : ($cover_count[self::COVERD]/$cover_count[self::TOTAL_COVER]*100),
        );
    }
    /* ----------------------------------------- */


    private function addWhiteListFiles()
    {
        $white_list_files = $this->filter->getWhiteList();
        $this->start();
        foreach ($white_list_files as $file_name) {
            if (!isset($this->coverage_data[$file_name])) {
                include_once $file_name;
            }
        }
        $this->finish();
    }



    private function subClassFactory($class_name)
    {
        $class_name = __CLASS__.$class_name;
        if (!class_exists($class_name, false)) {
            include dirname(__FILE__).DIRECTORY_SEPARATOR.'CodeCoverage'.DIRECTORY_SEPARATOR.$class_name.'.php';
        }
        return $class_name::factory($this);
    }

}


