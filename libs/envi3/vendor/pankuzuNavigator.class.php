<?php
/**
 * @package Envi3
 * @subpackage
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 * パンクズリストを作成する
 *
 * @access private
 * @since 2005/11/10 10:22
 * @package Envi
 * @subpackage EnviMVC
 */
class pankuzuNavigator
{

    private $_pankuzu = array();
    private $_default_pankuzu = array();

    public function __constructor()
    {
    }



    /**
     * +-- パンくずから、URLを作成する
     *
     * @access public
     * @params array $pankuzu
     * @params string $base_url OPTIONAL:ENVI_MVC_TOP_URL
     * @return string
     */
    public function getUrl(array $pankuzu, $base_url = ENVI_MVC_TOP_URL)
    {
        if (count($pankuzu) != 4 || !isset($pankuzu[0]) || !isset($pankuzu[1]) || !isset($pankuzu[2]) || !isset($pankuzu[3])) {
            return false;
        }

        return $base_url.$pankuzu[1]."/".$pankuzu[2].context::controller()->_system_conf["SYSTEM"]["ext"];
    }
    /* ----------------------------------------- */



    /**
     * +-- デフォルトで先頭に付加すべき、パンクズデータをAttributeします
     *
     * @access public
     * @params array $pankuzu_list
     * @return void
     */
    public function setDefaultPankuzu(array $pankuzu_list)
    {
        $this->_default_pankuzu = $pankuzu_list;
    }
    /* ----------------------------------------- */


    /**
     * パンクズデータをAttributeします
     *
     * @param string $name Attribute名
     * @param mixd $data 値
     * @return void
     */
    public function setPankuzu($pankuzu_name, $pankuzu_list)
    {
        $this->_pankuzu[$pankuzu_name] = $pankuzu_list;
    }

    /**
     * パンクズデータを作成します
     *
     * @param string $name Attribute名
     * @param mixd $data 値
     * @return void
     */
    public function makePankuzu($pagename, $module, $action, $query)
    {
        $pankuzu_list = array_chunk(func_get_args(), 4);
    }

    /**
     * Attributeしたパンクズデータを取り出します
     *
     * @param string $name Attribute名
     * @return mixd
     */
    public function getPankuzu($pankuzu_name)
    {
        return $this->_default_pankuzu + isset($this->_pankuzu[$pankuzu_name]) ? $this->_pankuzu[$pankuzu_name] : array();
    }

    /**
     * Attributeされているか確認します
     *
     * @param string $name Attribute名
     * @return boolean
     */
    public function hasPankuzu($pankuzu_name)
    {
        return isset($this->_pankuzu[$pankuzu_name]);
    }

    /**
     * Attributeされているデータを削除します
     *
     * @param string $name Attribute名
     * @return void
     */
    public function removePankuzu($pankuzu_name)
    {
        if (isset($this->_pankuzu[$pankuzu_name])) {
            unset($this->_pankuzu[$pankuzu_name]);
        }
    }

    /**
     * Attributeされているデータを全削除します
     *
     * @param string $name Attribute名
     * @return void
     */
    public function cleanPankuzu()
    {
        $this->_pankuzu = array();
    }
}
