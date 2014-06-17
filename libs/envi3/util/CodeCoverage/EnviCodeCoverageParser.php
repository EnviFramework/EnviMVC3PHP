<?php
/**
 *
 *
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
 * @doc_ignore
 */

/**
 *
 *
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
class EnviCodeCoverageParser
{
    private $parser;
    private $ignored_lines;
    private $code_coverage;

    /**
     * +-- ファクトリ
     *
     * @access      public
     * @static
     * @param       EnviCodeCoverage $code_coverage
     * @return      EnviCodeCoverageParser
     */
    public static function factory(EnviCodeCoverage $code_coverage)
    {
        $obj = new EnviCodeCoverageParser;
        $obj->code_coverage = $code_coverage;
        $obj->parser = new EnviCodeParser;
        return $obj;
    }
    /* ----------------------------------------- */

    public function parseFile($file_name)
    {
        return $this->parser->parseFile($file_name);
    }

    /**
     * +-- ファイル名を指定して、展開済みのDocBlockのリストを取得する
     *
     * @access      public
     * @param       string $file_name
     * @return      array
     */
    public function getDocTagList($file_name)
    {
        return $this->parser->getDocTagList($file_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- メソッドのDogsTagを返す
     *
     * @access      public
     * @param       string $file_name
     * @return      array
     */
    public function getMethodDocsTagSimple($file_name)
    {
        return $this->parser->getMethodDocsTagSimple($file_name);
    }
    /* ----------------------------------------- */


    public function addIgnoredLine($file_name, array $ignored_lines, array $cover_class, array$cover_method)
    {
        $use_cover = count($cover_class) || count($cover_method);
        if (!$use_cover) {
            return $ignored_lines;
        }
        $class_name         = '';
        $namespace_name     = '';
        $namespace_end_line = false;
        $token_result = $this->parseFile($file_name);
        $token_list  = $token_result->getTokenList();
        foreach ($token_list as $token) {
            if ($namespace_end_line !== false && $namespace_end_line <= $token->getLine()) {
                $namespace_name = '';
                $namespace_end_line = false;
            }
            switch ($token->getTokenName()) {
            case 'NAMESPACE':
                $namespace_end_line = false;
                if ($token->getEndLine() !== $token->getLine()) {
                    $namespace_end_line = $token->getEndLine();
                }
                $namespace_name        = $token->getName()."\\";
                break;
            case 'FUNCTION':
                if (!isset($cover_method[$class_name][$token->getName()])) {
                    $end_line = $token->getEndLine();
                    for ($i = $token->getLine(); $i <= $end_line; $i++) {
                        $ignored_lines[] = $i;
                    }
                }

            break;
            case 'INTERFACE':
            case 'TRAIT':
            case 'CLASS':
                $class_name = $namespace_name.$token->getName();
                if (!isset($cover_class[$class_name]) && !isset($cover_method[$class_name])) {
                    $end_line = $token->getEndLine();
                    for ($i = $token->getLine(); $i <= $end_line; $i++) {
                        $ignored_lines[] = $i;
                    }
                }

            break;
            }
        }
        $ignored_lines = array_unique($ignored_lines);
        sort($ignored_lines);
        return $ignored_lines;
    }

    /**
     * +-- code coverage 計測範囲外行を取得する
     *
     * @access      public
     * @param       string $file_name ファイルパス
     * @param       array $cover_class カバークラス
     * @param       array $cover_method カバーメソッド
     * @return      array
     */
    public function getSkipLine($file_name, array $cover_class, array$cover_method)
    {

        if (isset($this->ignored_lines[$file_name])) {
            return $this->addIgnoredLine($file_name, $this->ignored_lines[$file_name], $cover_class, $cover_method);
        }
        $this->ignored_lines[$file_name] = array();
        $ignore                        = false;
        $stop                          = false;
        $lines                         = file($file_name);
        $lines_count                   = count($lines);

        foreach ($lines as $index => $line) {
            if (!trim($line)) {
                $this->ignored_lines[$file_name][] = $index + 1;
            }
        }

        $token_result = $this->parseFile($file_name);

        $classes = array_merge($token_result->getClassList(), $token_result->getTraitList());
        $token_list  = $token_result->getTokenList();

        $namespace_name        = '';
        $namespace_end_line    = false;
        foreach ($token_list as $token) {
            if ($namespace_end_line !== false && $namespace_end_line <= $token->getLine()) {
                $namespace_name = '';
                $namespace_end_line = false;
            }
            switch ($token->getTokenName()) {
            case 'COMMENT':
            case 'DOC_COMMENT':
                $_token = trim($token);
                $_line  = trim($lines[$token->getLine() - 1]);

                if (strpos($_token, '@codeCoverageIgnoreStart') !== false) {
                    $ignore = true;
                } elseif (strpos($_token, '@codeCoverageIgnoreEnd') !== false) {
                    $stop = true;
                } elseif (strpos($_token, '@codeCoverageIgnore') !== false) {
                    $ignore = true;
                    $stop   = true;
                }

                if (strpos($_token, $_line) === 0) {
                    $count = substr_count($token, "\n");
                    $line  = $token->getLine();
                    $this->ignored_lines[$file_name][] = $line;
                    for ($i = $line; $i < $line + $count; $i++) {
                        $this->ignored_lines[$file_name][] = $i;
                    }

                    if ($token->getTokenName() === 'DOC_COMMENT') {
                        if (substr(trim($lines[$i-1]), -2) === '*/') {
                            $this->ignored_lines[$file_name][] = $i;
                        }
                    }
                }
                break;

            case 'INTERFACE':
            case 'TRAIT':
            case 'CLASS':
            case 'FUNCTION':
                $doc_block = $token->getDocBlock();
                $this->ignored_lines[$file_name][] = $token->getLine();
                // アノテーション処理
                if (strpos($doc_block, '@codeCoverageIgnore')) {
                    $end_line = $token->getEndLine();

                    for ($i = $token->getLine(); $i <= $end_line; $i++) {
                        $this->ignored_lines[$file_name][] = $i;
                    }
                } elseif ($token instanceof EnviParserToken_FUNCTION) {
                    break;
                }

                // Methodが無いならすべてスキップ
                if (empty($classes[$namespace_name.$token->getName()]['methods'])) {
                    for ($i = $token->getLine();
                         $i <= $token->getEndLine();
                         $i++) {
                        $this->ignored_lines[$file_name][] = $i;
                    }
                    break;
                }
                // 空白の消去
                $firstMethod = array_shift(
                    $classes[$namespace_name.$token->getName()]['methods']
                );

                do {
                    $lastMethod = array_pop(
                        $classes[$namespace_name.$token->getName()]['methods']
                    );
                } while ($lastMethod !== null &&
                    substr($lastMethod->getSignature(), 0, 18) === 'anonymous function');

                if ($lastMethod === null) {
                    $lastMethod = $firstMethod;
                }

                for ($i = $token->getLine();
                     $i < $firstMethod->getLine();
                     $i++) {
                    $this->ignored_lines[$file_name][] = $i;
                }
                for ($i = $token->getEndLine();
                     $i > $lastMethod->getEndLine();
                     $i--) {
                    $this->ignored_lines[$file_name][] = $i;
                }


                break;

            case 'NAMESPACE':
                $this->ignored_lines[$file_name][] = $token->getEndLine();
                $this->ignored_lines[$file_name][] = $token->getLine();

                $namespace_end_line = false;
                if ($token->getEndLine() !== $token->getLine()) {
                    $namespace_end_line = $token->getEndLine();
                }
                $namespace_name        = $token->getName()."\\";
                break;
            case 'OPEN_TAG':
            case 'CLOSE_TAG':
            case 'USE':
            case 'TRY':
                $this->ignored_lines[$file_name][] = $token->getLine();
                break;
            }

            if ($ignore) {
                $this->ignored_lines[$file_name][] = $token->getLine();

                if ($stop) {
                    $ignore = false;
                    $stop   = false;
                }
            }
        }

        $this->ignored_lines[$file_name][] = $lines_count + 1;

        $this->ignored_lines[$file_name] = array_unique(
            $this->ignored_lines[$file_name]
        );

        sort($this->ignored_lines[$file_name]);

        return $this->addIgnoredLine($file_name, $this->ignored_lines[$file_name], $cover_class, $cover_method);
    }
    /* ----------------------------------------- */

}

