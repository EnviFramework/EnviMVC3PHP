<?php
/**
 * EnviDocumenterで使用されるドライバ
 *
 *
 *
 * PHP versions 5
 *
 *
 * @category   ユーティリティ
 * @package    ドキュメンテーション
 * @subpackage Documenter
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 3.3.3.5
 * @doc_ignore
 */

/**
 * EnviDocumenterで使用されるドライバ
 *
 * 各Markdownファイルへの書き出しドライバです
 *
 * @category   ユーティリティ
 * @package    ドキュメンテーション
 * @subpackage Documenter
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 3.3.3.5
 * @doc_ignore
 */
class EnviDocumenterDriver
{
    private $template_dir;
    private $docs_dir;
    private $documenter;
    public function __construct($documenter, $docs_dir = NULL, $template_dir = NULL)
    {
        $this->documenter   = $documenter;
        $this->docs_dir     = dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/document/man/';
        $this->template_dir = dirname(__FILE__).'/template/md_tpl/';
    }

    public function fileWriter($class_list, $token_list, EnviParserResult $cpr)
    {
        $write_path = $this->makeWritePath($cpr->getFileName()).'.md';

        $this->write(
            $write_path,
            $this->template_dir.'file.tpl',
            array(
                'file_name' => mb_ereg_replace('\.php$', '', basename($cpr->getFileName())),
                'class_list' => $class_list,
            )
        );

        $write_path = $this->makeWritePath($cpr->getFileName()).'/intro.md';
        $doc_comment = $this->getFileDocComment($token_list);
        $this->introWrite($write_path, $doc_comment);
    }
    /* ----------------------------------------- */

    /**
     * +-- write path から urlパスへ変更する
     *
     * @access      public
     * @param       any $write_path
     * @return      string
     */
    public function writePathToManPath($write_path)
    {

        $write_path = str_replace("\\", '/', $write_path);
        mb_ereg('document/man/(.*).md$', realpath($write_path), $man_path);

        return '/c/man/v3/'.$man_path[1];
    }
    /* ----------------------------------------- */

    public function toPath($path)
    {
        return mb_ereg_replace("\\\\", '/', $path);
    }

    /**
     * +-- コンスタントドライバ
     *
     * @access      public
     * @param       any $package_name
     * @param       any $sub_package_name
     * @return      void
     */
    public function categoryWriter()
    {
        $category = $this->documenter->category_list;
        $write_path = $this->docs_dir.'reference.md';
        $this->write($write_path, $this->template_dir.'category.tpl', array('category' => $category));

        $category = $this->documenter->category_list;
        $write_path = $this->docs_dir.'__menu.md';
        $this->write($write_path, $this->template_dir.'menu.tpl', array('category' => $category));
    }
    /* ----------------------------------------- */

    /**
     * +-- クラスドライバ
     *
     * @access      public
     * @param       any $class_name
     * @return      void
     */
    public function classWriter($class_name)
    {
        $class_item = $this->documenter->class_list[$class_name];
        $write_path = $class_item['class_item']['man_path'];
        $this->write(
            $write_path,
            $this->template_dir.'class.tpl',
            array(
                'file_name'  => $class_item['class_item']['file_name'],
                'class_name' => $class_name,
                'token'      => $class_item['class_item']['token'],
                'methods'    => $class_item['methods']
            )
        );
    }
    /* ----------------------------------------- */

    /**
     * +-- メソッドドライバ
     *
     * @access      public
     * @param       any $method_name
     * @return      void
     */
    public function methodWriter($method_name)
    {
        $method = $this->documenter->method_list[$method_name];
        $class_name = $method['class_name'];
        $write_path = $method['man_path'];
        $this->write(
            $write_path,
            $this->template_dir.'method.tpl',
            array(
                'file_name'        => $method['file_name'],
                'class_name'       => $class_name,
                'method_name'      => $method_name,
                'write_path'       => $write_path,
                'token'            => $method['token'],
                'method_list'      => $this->documenter->method_list,
                'class_token'      => $method['class_token'],
                'file_doc_token'   => $method['file_doc_token'],
            )
        );
    }
    /* ----------------------------------------- */

    /**
     * +-- コンスタントドライバ
     *
     * @access      public
     * @param       any $package_name
     * @param       any $sub_package_name
     * @return      void
     */
    public function constantWriter($package_name, $sub_package_name)
    {
        $package = $this->documenter->package_list[$package_name][$sub_package_name];
        $write_path = $package['constant_man_path'];
        $this->write($write_path, $this->template_dir.'constants.tpl', array('class_list' => $package['class_list']));
    }
    /* ----------------------------------------- */

    /**
     * +-- サブパッケージドライバ
     *
     * @access      public
     * @param       any $package_name
     * @param       any $sub_package_name
     * @return      void
     */
    public function subPackageWriter($package_name, $sub_package_name)
    {
        $package = $this->documenter->package_list[$package_name][$sub_package_name];
        $write_path = $package['sub_package_man_path'];
        $this->write($write_path, $this->template_dir.'sub_package.tpl', array('sub_package' => $package, 'class_list' => $package['class_list'], 'package_name' => $package_name, 'sub_package_name' => $sub_package_name));
        $this->introWrite($package['intro_man_path'], $this->tokenToDocList($package['file_doc']));
    }
    /* ----------------------------------------- */


    /**
     * +-- パッケージドライバ
     *
     * @access      public
     * @param       any $package_name
     * @param       any $sub_package_name
     * @return      void
     */
    public function packageWriter($package_name)
    {
        $package = $this->documenter->package_list[$package_name];
        $sub_package = each($package);
        $write_path = $sub_package[1]['package_man_path'];
        $this->write($write_path, $this->template_dir.'package.tpl', array('package' => $package, 'package_name' => $package_name));
    }
    /* ----------------------------------------- */

    /**
     * +-- イントロを書き込み
     *
     * @access      protected
     * @param       var_text $values
     * @param       EnviParserResult $cpr
     * @return      void
     */
    protected function introWrite($write_path, $values)
    {
        if (!isset($values['enable']) || !$values['enable']) {
            return;
        } elseif (strlen(trim($values['doc_detail'])) < 10) {
            return;
        }
        $this->write($write_path, $this->template_dir.'intro.tpl', $values);
    }
    /* ----------------------------------------- */

    /**
     * +-- 書き込みファイルパスを取得
     *
     * @access      public
     * @param       var_text $file_name
     * @return      void
     */
    public function makeWritePath($file_name)
    {
        return $this->docs_dir.'/reference/';
        return $this->docs_dir.mb_ereg_replace('^.*envi3/(.*)\.php$', '\1', $file_name);
    }
    /* ----------------------------------------- */


    protected function write($write_path, $tpl_path, $values)
    {
        ob_start();
        extract($values);
        $driver = $this;
        include $tpl_path;
        $res = ob_get_contents();
        ob_end_clean();
        $this->documenter->cliWrite(dirname($this->toPath($write_path)));
        @mkdir(dirname($this->toPath($write_path)), 0777, true);
        file_put_contents($this->toPath($write_path), $res);
        $this->documenter->cliWrite($this->toPath($write_path));
    }



    private function getFileDocComment(&$token_list)
    {
        $res = array('doc_subject' => '', 'doc_detail' => '', );
        foreach ($token_list as $token) {
            return $this->tokenToDocList($token);
        }
        return $res;
    }

    private function tokenToDocList($token)
    {
        $res = array('doc_subject' => '', 'doc_detail' => '', );
        if ($token->getTokenName() === 'DOC_COMMENT') {
            $res['doc_subject'] = $token->getDocBlockSubject();
            $res['doc_detail'] = str_replace('PHP versions 5', '', $token->getDocBlockDetail());
            $res['enable']     = strpos($token->getDocBlock(), '@sub_class') === false;
        }
        return $res;
    }


}

