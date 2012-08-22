<?php
/**
 *
 *
 * PHP versions 5
 *
 *
 * @category   %%project_category%%
 * @package    %%project_name%%
 * @subpackage
 * @author     %%your_name%% <%%your_email%%>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @version    GIT: $Id$
 * @link       %%your_link%%
 * @see        %%your_see%%
 * @since      File available since Release 1.0.0
 */


/**
 *
 *
 * @category   %%project_category%%
 * @package    %%project_name%%
 * @subpackage
 * @author     %%your_name%% <%%your_email%%>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @version    Release: @package_version@
 * @link       %%your_link%%
 * @see        %%your_see%%
 * @since      Class available since Release 1.0.0
 */
class viewBase extends EnviViewBase
{

    /**
     * +-- レンダラーセット
     *
     * @access public
     * @params
     * @return void
     */
    public function setRenderer()
    {
        parent::setRenderer();
    }
    /* ----------------------------------------- */

    /**
     * +-- 画面を簡単に描画する
     *
     * @access public
     * @params array $parameter OPTIONAL:NULL
     * @params string $template OPTIONAL:NULL
     * @return void
     */
    public function display(array $parameter = NULL, $template = NULL)
    {
        // パラメータのsetAttribute
        if (!empty($parameter)) {
            foreach ($parameter as $key => $value) {
                $this->renderer->setAttribute($key, $value);
            }
        }
        if ($template === NULL) {
            $template = Request::getThisAction() . '.tpl';
        }
        $this->renderer->display($template);
    }
    /* ----------------------------------------- */
}
