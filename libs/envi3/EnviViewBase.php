<?php
/**
 * ビューコントローラー
 *
 * ビューコントローラーの詳しい説明は、
 * [基本リファレンス/ビューコントローラー](/c/man/v3/core/view_controller)
 * で行っていますので、そちらを参照して下さい。
 *
 * すべてのアクションコントローラーは、基底クラスである、EnviViewBaseを継承していますが、
 * コレを直接継承することは無く、このクラスを直接継承することは無く、`envi init-app`によって生成される、viewBaseを介して継承されます。
 *
 * コレによって、アプリケーション毎のデフォルト処理をviewBaseに記述することが出来ます。
 *
 * モジュール毎のデフォルト処理は、`envi init-module`によって生成される、views.class.php内に記述することが出来ます。
 * このクラスも、viewBaseを介してEnviViewBaseを継承しています。
 *
 * ビューコントローラーは必ずしも必要ではありません。
 * アクションコントローラーから直接レンダラをコールする [方法](/c/man/v3/core/action_controller)もあります。
 *
 *
 * PHP versions 5
 *
 *
 * @category   フレームワーク基礎処理
 * @package    ベースクラス
 * @subpackage ViewController
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
 * ビュー基底クラス
 *
 * ビューコントローラーを書くときは必ずこのクラスを継承してください。
 *
 * 通常であれば、このクラスを直接継承することは無く、
 * `envi init-app`によって生成される、viewBaseや、
 * `envi init-module`によって生成される、views.class.phpを介して継承されます。
 *
 * @abstract
 * @category   フレームワーク基礎処理
 * @package    ベースクラス
 * @subpackage ViewController
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 */
abstract class EnviViewBase
{
    public $renderer;


    public function __construct()
    {
    }

    /**
     * @abstract
     */
    public function initialize()
    {
        return true;
    }

    /**
     * @abstract
     */
    public function execute()
    {
        return true;
    }


    /**
     * @abstract
     */
    public function setRenderer()
    {
        $renderer_path = Envi()->getConfiguration('SYSTEM', 'renderer');
        $renderer_class = substr(basename($renderer_path), 0, -4);
        if (!class_exists($renderer_class, false)) {
            include $renderer_path;
        }
        $this->renderer = new $renderer_class();
    }

    /**
     * @abstract
     */
    public function shutdown()
    {
        return true;
    }
}
