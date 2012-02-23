<?php
/**
 * @package Envi3
 * @subpackage EnviMVCVendorExtension
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

function EnviWebType()
{
    return EnviWebType::singleton();
}

/**
 * アクセス者の情報を解析
 *
 * @package Envi3
 * @subpackage EnviMVCVendorExtension
 * @sinse 0.1
 */
class EnviWebType
{
    const PC =      "pc";
    const AU =      "au";
    const TUKA =     "t";
    const IDO =      "ido";
    const VODAFONE = "v";
    const DOCOMO =   "d";
    const PHS =      "phs";
    const LMODE =    "l";
    const PSP =      "psp";
    const IPHONE =   "iPhone";
    const ANDROID =  "android";
    const OHTER =    "other";
    const DEBUG =    "debug";

    public $Envi_hdml_smaf_map;
    public $Envi_hdml_aud_map;
    public $Envi_hdml_grf_map;
    public $Envi_lmode_smaf_map;
    public $Envi_lmode_grf_map;
    public $_cash = array();
    public $remote_host;

    private static $instance;

    /**
     * +-- シングルトン
     *
     * @access public
     * @static
     * @return EnviWebType
     */
    public static function singleton()
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }

    /**
     * +-- コンストラクタ
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
    //TUKAデバイスマップ
        $Envi_hdml_smaf_map = array("HI11" => 4, "KC11" => 4, "HI12" => 4, "KC12" => 4, "KCT4" => 4, "KCT5" => 4, "KCT6" => 4, "KCT7" => 4,
                        "SN12" => 16, "SN14" => 16, "SN13" => 16, "HI13" => 16, "SN15" => 16, "SN16" => 16, "KC13" => 16,
                        "HI14" => 16, "CA14" => 16, "SN17" => 16, "HI21" => 16, "TST3" => 16, "KCT8" => 16, "TST4" => 16,
                        "MIT1" => 16, "SYT3" => 16, "MAT3" => 16, "CN17" => 16, "ST13" => 16, "KC14" => 40, "TST5" => 40,
                        "KCT9" => 40, "TST6" => 40, "KC15" => 40, "ST14" => 40, "KCTA" => 40, "KCTB" => 16, "KCTC" => 40,
                        "SYT4" => 40, "TST7" => 40, "TST8" => 40, "KCTD" => 40, "SYT5" => 40, "KCU1" => 40
        );
        $Envi_hdml_aud_map = array("SN12" => 1, "SN14" => 1, "SN13" => 1, "SN15" => 1, "SN16" => 1, "SN17" => 1, "SN21" => 1, "SN22" => 1,
                        "CA14" => 1, "TS23" => 1, "TST3" => 1, "TST4" => 1, "TST5" => 1, "TST6" => 1, "SA22" => 1,
                        "ST13" => 1, "ST14" => 1, "MIT1" => 1, "SYT3" => 1, "SN22" => 1, "SYT4" => 1, "TST7" => 1,
                        "TST8" => 1, "KCTD" => 1, "SYT5" => 1, "KCU1" => 1, "test" => 1
        );
        $Envi_hdml_grf_map = array("HI21" => 1, "HI14" => 1, "TST6" => 1, "ST13" => 1,
                        "ST14" => 1, "KC15" => 1, "SYT3" => 1, "TST5" => 1,
                        "KCTA" => 1, "KCTC" => 1, "SYT4" => 1, "TST7" => 1,
                        "TST8" => 1, "KCTD" => 1, "SYT5" => 1, "KCU1" => 1
        );

        //L-modeデバイスマップ
        $Envi_lmode_smaf_map = array("NTT4955595094544-000" => 16, "NTT4955595098269-000" => 16, "NTT4955595091253-000" => 16,
            "NTT4955595091314-000" => 16, "NTT4955595095749-000" => 16, "NTT4955595094513-000" => 16, "NTT4955595094476-000" => 16,
            "NTT4955595094391-000" => 16, "NTT4955595097675-000" => 16, "NTT4955595097255-000" => 16, "CANSL70" => 16, "CANSL50" => 16,
            "CANVL20" => 16, "CANVL10" => 16, "CANVL1" => 16, "SHAUXWB10" => 16, "SHAUX-W71" => 16, "SHAUXW-70" => 16, "PCCTF-LS710" => 16,
            "PCCTF-LS700" => 16, "PCCTF-LS500" => 16, "PCCTF-LP900F" => 16, "PCCTF-LP800F" => 16, "MGCUFL3" => 16, "MGCUFL1" => 16,
            "MGCKXL6" => 16, "KMEKXL5" => 16
        );

        $Envi_lmode_grf_map = array("NTT4955595094544-000" => 1, "NTT4955595098269-000" => 1, "NTT4955595095749-000" => 1,
            "NTT4955595094513-000" => 1, "NTT4955595094476-000" => 1, "NTT4955595094391-000" => 1, "NTT4955595097675-000" => 1,
            "NTT4955595097255-000" => 1, "CANSL70" => 1, "CANSL50" => 1, "CANVL20" => 1, "CANVL10" => 1, "CANVL1" => 1, "SHAUXWB10" => 1, "SHAUX-W71" => 1,
            "SHAUX-W70" => 1, "SHAUXW51" => 1, "MGCUFL3" => 1, "MGCUFL1" => 1, "MGCKXL6" => 1, "KMEKXL5" => 1
        );
        $this->remote_host = @gethostbyaddr($_SERVER["REMOTE_ADDR"]);
    }

    public function getUserInfo()
    {
        if (isset($this->_cash["getUserinfo"])) {
            return $this->_cash["getUserinfo"];
        }
        $user_agent =& $_SERVER['HTTP_USER_AGENT'];
        if (stristr($_SERVER["HTTP_USER_AGENT"], "KDDI") && stristr($_SERVER["HTTP_USER_AGENT"], "Opera")) {
            $web = self::OHTER;
        } elseif (stristr($_SERVER["HTTP_USER_AGENT"], "iPhone")) {
            $web = self::IPHONE;
        } elseif (strstr($_SERVER["HTTP_USER_AGENT"], "Android")) {
            $web = self::ANDROID;
        } elseif (mb_eregi('KDDI|UP\.Browser', $_SERVER["HTTP_USER_AGENT"])) {
            $web = self::AU;
        } elseif (mb_eregi('J-PHONE|Vodafone|MOT|SoftBank', $_SERVER["HTTP_USER_AGENT"])) {
            $web = self::VODAFONE;
        } elseif (stristr($_SERVER["HTTP_USER_AGENT"], "Docomo")) {
            $web = self::DOCOMO;
        } elseif (strstr($_SERVER["HTTP_USER_AGENT"], "PlayStation Portable")) {
            $web = self::PSP;
        } else {
            // それ以外はPCよん
            $web = self::PC;
        }

        $this->_cash["getUserinfo"] = $web;
        return $web;
    }

    public function getWeb()
    {
        if (isset($this->_cash["getWeb"])) {
            return $this->_cash["getWeb"];
        }
        $user_agent =& $_SERVER['HTTP_USER_AGENT'];
        $remote_host = $this->remote_host;
        if (strstr($_SERVER["HTTP_USER_AGENT"], "KDDI") && strstr($_SERVER["HTTP_USER_AGENT"], "Opera")) {
            $web = self::OHTER;
        } elseif (strstr($_SERVER["HTTP_USER_AGENT"], "iPhone")) {
            $web = self::IPHONE;
            // $web = self::PC;
        } elseif (strstr($_SERVER["HTTP_USER_AGENT"], "Android")) {
            $web = self::ANDROID;
            // $web = self::PC;
        } elseif (ereg("\.(ido|ezweb)\.ne\.jp$", $remote_host)) {
            if (isset($_SERVER["HTTP_X_UP_SUBNO"])) {
                // EZweb WAP2.0 端末用の処理
                if (isset($_SERVER['HTTP_X_UP_DEVCAP_MULTIMEDIA'])) {
                    $web = self::AU;
                } else {
                    // $web = self::TUKA;
                    $web = self::PC;
                }
            } else {
                // EZweb 旧端末用の処理
                // $web = self::IDO;
                $web = self::PC;
            }
        } elseif (strstr($user_agent, "Googlebot-Mobile")) {
            $web = self::VODAFONE;
        } elseif ($remote_host  === 'pdxcgw.pdx.ne.jp') {
            // H" 用の処理
            $web = self::PHS;
        } elseif (mb_ereg("\.docomo\.ne\.jp$", $remote_host)) {
            // i-mode 用の処理
            $web = self::DOCOMO;
        } elseif (mb_ereg("\.jp-[ckqt]\.ne\.jp$", $remote_host) || mb_ereg("\.softbank\.ne\.jp", $remote_host)) {
            // J-SKY 用の処理
            $web = self::VODAFONE;
        } elseif (mb_ereg("\.pipopa\.ne\.jp$", $remote_host)) {
            // L-mode 用の処理
            $web = self::LMODE;
        } elseif ($_SERVER['REMOTE_ADDR'] === "") {
            //特定IPはデバッグに
            $web = self::DEBUG;
        } elseif (strstr($_SERVER["HTTP_USER_AGENT"], "PlayStation Portable")) {
            $web = self::PSP;
        } else {
            // それ以外はPCよん
            $web = self::PC;
        }
        $this->_cash["getWeb"] = $web;
        return $web;
    }

    public function getCharacter()
    {
        if (isset($this->_cash["getCharacter"])) {
            return $this->_cash["getCharacter"];
        }
        $info["remote_host"] = $this->remote_host;
        $info['web'] = $this->getWeb();
        switch ($info['web']) {
            case self::DEBUG:
            //デバッグの処理
                $get_user        = $this->getUserinfo();
                $info['browser'] = $get_user['browser'];
                $info['b_type']  = "xhtml";
                $info['size']    = "10000";
                $info['device']  = "test";
                $info['uid']     = "test";
                $info['smaf']    = 124;
                $info['pcm']     = true;
                $info['grf']     = true;
            break;
            case self::PC:
            //PCの処理
                $get_user = $this->getUserinfo();
                $info['b_type']  = "html";
                $info['browser'] = $get_user['browser'];
                $info['device']  = $get_user['os'];
                $info['uid']     = $_SERVER["REMOTE_ADDR"];
                $info['size']    = "9999999999";
                $info['smaf']    = 124;
                $info['pcm']     = true;
                $info['grf']     = true;
            break;
            case self::VODAFONE:
            //Vodafoneの処理
                $user_agent = split("[/ ]", $_SERVER['HTTP_USER_AGENT']);
                $info['b_type'] = "html";
                if (isset($_SERVER['HTTP_X_JPHONE_MSNAME'])) {
                    $info['browser'] = $_SERVER['HTTP_X_JPHONE_MSNAME'];
                } else {
                    $info['browser'] = $user_agent[1];
                }
                if (isset($user_agent[3])) {
                    if (isset($_SERVER['HTTP_X_JPHONE_UID'])) {
                        $info['uid'] = $_SERVER['HTTP_X_JPHONE_UID'];
                    } else {
                        $info['uid'] = $user_agent[3];
                    }
                } else {
                    $info['uid'] = $_SERVER["REMOTE_ADDR"];
                }
                if (isset($_SERVER['HTTP_X_JPHONE_SMAF'])) {
                    $info_SMAF = explode('/', $_SERVER['HTTP_X_JPHONE_SMAF']);
                    while (list($key, $val) = each($info_SMAF)) {
                        if ($val === "pcm") {
                            $info['pcm'] = TRUE;
                        } elseif ($val === "grf") {
                            $info['grf'] = TRUE;
                        } else {
                            $info['smaf'] = $val;
                        }
                    }
                } else {
                    $info['smaf'] = FALSE;
                }
                if (!isset($info['pcm'])) {
                    $info['pcm'] = FALSE;
                }
                if (!isset($info['grf'])) {
                    $info['grf'] = FALSE;
                }
                list($info['width'], $info['higth']) = explode('*', $_SERVER['HTTP_X_JPHONE_DISPLAY']);
                $info['device']                      = $_SERVER['HTTP_X_JPHONE_MSNAME'];
            break;
            case self::DOCOMO:
            //DOCOMOの場合
                $info['uid']     = $_SERVER["REMOTE_ADDR"];
                $info['b_type']  = "html";
                $user_agent      = split("[/ ()]", $_SERVER['HTTP_USER_AGENT']);
                $info['browser'] = $user_agent[1];
                $info['device']  = $user_agent[2];
                $info['cash']    = $user_agent[3];
                if ($info['cash']) {
                    $info['size'] = substr("$info[cash]", 1) * 1000;
                } else {
                    $info['size'] = 12000;
                }
            break;
            case self::AU:
            case self::TUKA:
            //EZWEBの場合
                $info['uid']    = $_SERVER['HTTP_X_UP_SUBNO'];
                $info['size']   = $_SERVER['HTTP_X_UP_DEVCAP_MAX_PDU'];
                $user_agent     = split('[- ]', $_SERVER['HTTP_USER_AGENT']);
                $info['device'] = $user_agent[1];
                if (isset($_SERVER['HTTP_X_UP_DEVCAP_MULTIMEDIA'])) {
                    //XHTML端末
                    $info['b_type'] = "xhtml";
                    $info['aud'] = TRUE;
                    $smaf_type = (int)substr($_SERVER['HTTP_X_UP_DEVCAP_MULTIMEDIA'], 4, 1);
                    if ($smaf_type === 1) {
                        $info['smaf'] = 4;
                    } elseif ($smaf_type === 2) {
                        $info['smaf'] = 16;
                        $info['grf'] = FALSE;
                    } elseif ($smaf_type === 3) {
                        $info['smaf'] = 16;
                        $info['grf'] = TRUE;
                    } elseif ($smaf_type === 4) {
                        $info['smaf'] = 40;
                        $info['grf'] = FALSE;
                    } elseif ($smaf_type === 5) {
                        $info['smaf'] = 40;
                        $info['grf'] = TRUE;
                    } elseif ($smaf_type === 6) {
                        $info['smaf'] = 40;
                        $info['grf'] = FALSE;
                    } elseif ($smaf_type === 7) {
                        $info['smaf'] = 40;
                        $info['grf'] = TRUE;
                    }
                } else {
                    //HDML端末
                    ini_set("default_mimetype", "text/x-hdml");    // HDML mime-types is text/x-hdml
                    ini_set("default_charset", "Shift_JIS");    // HDML charset is Shift_JIS
                    $info['b_type'] = "hdml";
                    $device = $info['device'];
                    if (isset($this->Envi_hdml_aud_map["$device"])) {$info['aud'] = TRUE;}
                    else {$info['aud'] = FALSE;}
                    if (isset($this->Envi_hdml_grf_map["$device"])) {$info['grf'] = TRUE;}
                    $info['smaf'] = $this->Envi_hdml_smaf_map["$device"];
                }
            break;
            case self::IDO:
                //旧KDDI端末
                ini_set("default_mimetype", "text/x-hdml");    // HDML mime-types is text/x-hdml
                ini_set("default_charset", "Shift_JIS");    // HDML charset is Shift_JIS
                $info['b_type'] = "hdml";
                $device         = $info['device'];
                if (isset($this->Envi_hdml_aud_map[$dev])) {
                    $info['aud'] = TRUE;
                } else {
                    $info['aud'] = FALSE;
                }
                if (isset($this->Envi_hdml_grf_map[$dev])) {
                    $info['grf'] = TRUE;
                }
                $info['smaf'] = isset($this->Envi_hdml_smaf_map[$dev]) ? $this->Envi_hdml_smaf_map[$dev] : 16;

            break;
            case self::LMODE:
            //L-modeの場合
                $user_agent      =  split("[/]", $_SERVER['HTTP_USER_AGENT']);
                $info['size']    = $user_agent[5];
                $info['b_type']  = "html";
                $info['browser'] = $user_agent[0];
                if (isset($this->Envi_lmode_smaf_map[$browser])) {
                    $info['smaf'] = $this->Envi_lmode_smaf_map[$browser];
                } else {
                    $info['smaf'] = FALSE;
                }
                $info['device'] = $user_agent[4];
                if (2 >= (substr($user_agent[2], 0, 1))) {
                    $info['b_type'] = 2;
                }
                if (2 >= (substr($user_agent[2], 0, 1))) {
                    $info['b_type'] = 1;
                }
                if ($info['b_type'] == 2) {
                    if ($user_agent[8] == 1) {
                        $info['ssl'] = TRUE;
                    } else {
                        $info['ssl'] = FALSE;
                    }
                    $info['p_type'] = $user_agent[9];
                    $info['width']  = substr($user_agent[9], 1, 4);
                    $info['higth']  = substr($user_agent[9], 5, 4);

                } else {
                    $info['ssl'] = FALSE;
                }

            break;
            default:
                $get_user = $this->getUserinfo();
                $info['b_type']  = "html";
                $info['browser'] = $get_user['browser'];
                $info['device']  = $get_user['os'];
                $info['uid']     = $_SERVER["REMOTE_ADDR"];
                $info['size']    = "9999999999";
                $info['smaf']    = false;
                $info['pcm']     = false;
                $info['grf']     = false;
            break;
        }
        $this->_cash["getCharacter"] = $info;
        return $info;
    }
}
