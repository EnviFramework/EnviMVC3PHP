<?php
/**
 * レンダラー
 *
 * はじめに
 * ------------------------------------------------
 * レンダラーは、その名の通り、画面出力を司る機能です。
 * EnviMVCでは、開発者が好みのテンプレートエンジンを自由に組み込むことが出来ます。
 *
 * EnviRendererインターフェイス継承し、必要部分を実装することで、自由にレンダラーを作成できます。
 *
 * 標準で3つのレンダラーと、自動エスケープ機能の付いた、3つのレンダラーを提供します。
 *
 *
 * Tips
 * ------------------------------------------------
 * Viewコントローラーで記述する、レンダラーオブジェクトは、アクションコントローラーで生成しても構いません。
 *
 * その場合は、Viewコントローラーを使用しません。
 * レンダラで`display()`したあと、`return false;`または、単に、`return;`、`return Envi::NONE;`等の方法で、Viewコントローラーへの遷移を止めて下さい。
 *
 *
 *
 *
 * PHP versions 5
 *
 *
 * @category   EnviMVC拡張
 * @package    レンダラ
 * @subpackage Renderer
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 1.0.0
 * @subpackage_main
 */

/**
 * レンダラーのインターフェイス
 *
 * @category   EnviMVC拡張
 * @package    レンダラ
 * @subpackage Renderer
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 */
interface EnviRenderer
{

    /**
     * +-- templateに値を格納する
     *
     * @param string $name 格納する名前
     * @param mixed $value 値
     * @return void
     */
    public function setAttribute($name, $value);

    /**
     * +-- templateに値を格納する
     *
     * @param string $name 格納する名前
     * @param mixed $value 値
     * @return void
     * @see EnviPHPRenderer::setAttribute()
     * @deprecated EnviPHPRenderer::setAttribute()を使用して下さい。
     */
    public function assign($name, $value);

    /**
     * +-- 画面に描画する
     *
     * 指定されたテンプレートを読み込み、標準出力に出力します。
     *
     * @access      public
     * @param       string $file_name templateのパス
     * @param       string $cache_id キャッシュID OPTIONAL:NULL
     * @param       stiring $dummy2 ダミー変数 OPTIONAL:NULL
     * @return      void
     */
    public function display($file_name, $cache_id  = NULL, $dummy2 = NULL);

    public function is_cached($file_name, $cache_id  = NULL, $dummy2 = NULL);

    public function clear_cache($file_name, $cache_id  = NULL, $dummy2 = NULL);


    /**
     * +-- 展開したテンプレートの出力結果を返す
     *
     * 指定されたテンプレートを読み込み、実行結果の文字列を返します。
     *
     * @access      public
     * @param       string $file_name templateのパス
     * @param       string $cache_id キャッシュID OPTIONAL:NULL
     * @param       stiring $dummy2 ダミー変数 OPTIONAL:NULL
     * @return      stiring
     */
    public function displayRef($file_name, $cache_id  = NULL, $dummy2 = NULL);
    /* ----------------------------------------- */

}
