<?php
/**
 * メールの送信
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    GIT: $Id:$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */

define("ENVI_SENDMAIL_VERSION", "1.0");

/**
 * メールの送信
 *
 *
 * @package    Envi3
 * @category   MVC
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class EnviSendMail
{
    /**
     * 送信先の配列を格納
     *
     * @var string
     */
    public $to_array = array();

    /**
     * エラーメールの送信先
     *
     * @var string
     */
    public $error_to = "auto-mail@five-foxes.com";

    /**
     * CC送信先の配列を格納
     *
     * @see pandaSendMail(),$_cc
     * @var array
     */
    public $cc_array = array();

    /**
     * BCC送信先の配列を格納
     *
     * @see pandaSendMail(),$_bcc
     * @var array
     */
    public $bcc_array = array();


    /**
     * キーワードヘッダーを格納
     *
     * @see $header
     * @var string
     */
    public $keyword = "Envi MVC Sendmail";


    /**
     * 返信先 Reply-To:
     *
     * @var string
     */
    public $reply = "auto-mail@five-foxes.com";

    /**
     * 送信元 from:
     *
     * @var string
     */
    public $_from = "auto-mail@five-foxes.com";


    /**
     * 開発環境の場合の送信先
     *
     * false を指定すると本番と同じ動作（dev_sendに送らない）になります。
     *
     * @var string
     */
    public $dev_send = "akito-artisan@five-foxes.com,akito-yume@k.vodafone.ne.jp";

    /**
     * ステージ環境の場合の送信先
     *
     * false を指定すると本番と同じ動作（stg_sendに送らない）になります。
     *
     * @var string
     */
    public $stg_send = "akito-artisan@five-foxes.com";

    /**
     * ステージ環境の場合の許可送信先
     *
     * @var string
     */
    public $stg_allow_send = array(
        "akito-artisan@five-foxes.com",
    );

    /**
     * 件名 subject:
     *
     * @var string
     */
    public $subject = "";

    /**
     * 本文 body
     *
     * setTextMsg()コールで生成されます。
     *
     * @see setBody(),$footerpath,$filepath
     * @var string
     */
    public $body = "";

    /**
     * 添付ファイル
     *
     * @see addAttachment(),getAttachment(),
     * @var array
     */
    public $attachment = array();

    /**
     * 添付ファイルがあるかどうか
     *
     * バイナリの配列を設定してください。
     *
     * @see sendMailSubmit(),pandaSendMail()
     * @var array
     */
    public $is_attachment = false;

    /**
     * メールの正規化を行うか
     *
     * ヘッダの不要な改行や、半角カナの全角化を行う
     *
     * @see sendMailSubmit(),pandaSendMail()
     * @var bool
     */
    public $auto_clean = true;

    /**
     * 区切り線
     *
     * 添付ファイルの区切り線
     *
     * @var string
     */
    public $boundary = "--------SendMimeMailClass";

    /**
     * ServerInfo()オブジェクトを格納
     *
     * @var object
     */
    private $_ServerInfo;


    /**
     * 送信先 TOを格納
     *
     * $to_arrayから、クラス内で自動生成されます。
     *
     * @see $to_array,sendMailSubmit()
     * @var string
     */
    private $_to;



    /**
     * 送信先 CCを格納
     *
     * $cc_arrayから、クラス内で自動生成されます。
     *
     * @see $cc_array,sendMailSubmit()
     * @var string
     */
    private $_cc;


    /**
     * 送信先 BCCを格納
     *
     * $bcc_arrayから、クラス内で自動生成されます。
     *
     * @see $bcc_array,sendMailSubmit()
     * @var string
     */
    private $_bcc = false;


    /**
     * headerを格納します
     *
     * クラス内で自動生成されます。
     *
     * @see sendMailSubmit()
     * @var string
     */
    private $_header;


    public $snap_shot;

    public $smarty;

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct($smarty = null)
    {
        if (!is_object($smarty)) {
            include_once("ArtisanSmarty.class.php");
            $this->smarty = new Smarty();
        } else {
            $this->smarty = $smarty;
        }
        $this->boundary = uniqid("--------phpSendMail_".ENVI_SENDMAIL_VERSION);
        $this->_ServerInfo = EnviServerStatus();
    }


    public function setSnapShot(){
        $this->_snap_shot = $this;
    }

    public function getSnapShot(){
        return $this->_snap_shot;
    }

    /**
     * メールの送信実行
     *
     * @return boolean
     */
    public function sendMailSubmit()
    {
        mb_language("japanese");
        if (!$this->_makeHeader()) {
            return false;
        }

        if ($this->is_attachment) {
            //添付ありの場合
            $body="--".$this->boundary."\n"
                ."Content-Type: text/plain; charset=\"ISO-2022-JP\"\n"
                ."Content-Transfer-Encoding: 7bit\n"
                ."\n"
                .mb_convert_encoding($this->body, "JIS", "AUTO")
                ."\n";

            //添付する
            foreach ($this->attachment as $key => $value) {
                $body .= "--".$this->boundary."\n"
                    ."Content-Type: ".$value["type"]."; name=\""
                    .$value["file"]."\"\n"
                    ."Content-Transfer-Encoding: base64\n"
                    ."Content-Disposition: attachment; filename=\"".$value["file"]."\"\n\n"
                    .chunk_split(base64_encode($value["data"]))
                    ."\n";
                    $body.="--".$this->boundary."--\n";
            }

            $result = mail(
                $this->_to,
                mb_encode_mimeheader($this->subject),
                $body,
                $this->_header
            );
        } else {
            file_get_contents("http://wiki.five-foxes.com/mb_send_mail.php?to=".urlencode($this->_to)."&subject=".urlencode($this->subject)."&message=".urlencode($this->body."\r\n※本サーバーのメール機能が不調なため、別なサーバーからも同時送信しています。\r\n同じメールが2通届いた場合は、お手数ですが、一通破棄してください。")."&additional_headers=".urlencode($this->_header));
            //添付無しの場合は、シンプルに
            $result = mb_send_mail(
                $this->_to,
                $this->subject,
                $this->body,
                $this->_header
            );
        }
        return $result;
    }


    /**
     * ヘッダを作成
     *
     * @return boolean
     */
    private function _makeHeader()
    {
        $is_dev = ($this->_ServerInfo->getServerStatus() == EnviServerStatus::DEVELOPER);
        $is_stg = ($this->_ServerInfo->getServerStatus() == EnviServerStatus::STAGE);
        if (!count((array)$this->to_array)) {
            return false;
        } elseif ($is_dev && $this->dev_send !== false) {
            //開発なら、開発用アドレスに
            $this->_to = $this->dev_send;
        } elseif ($is_stg && $this->stg_send !== false) {
            $loop = 1;
            foreach ($this->to_array as $value) {
                if (in_array($value, $this->stg_allow_send)) {
                    $to_array_tmp[] = $value;
                } else if ($loop == 1) {
                    $to_array_tmp[] = $this->stg_send;
                    $loop++;
                }
            }
            $this->to_array = $to_array_tmp;
            $this->_to = join(",", (array)$this->to_array);
        } else {
            $this->_to = join(",", (array)$this->to_array);
        }

        if (count((array)$this->cc_array)) {
            if ($is_dev && $this->dev_send !== false) {
                //開発なら、開発用アドレスに
                $this->_cc = $this->dev_send;
            } elseif ($is_stg && $this->stg_send !== false) {
                $cc_array_tmp[] = $this->stg_send;
                foreach ($this->cc_array as $value) {
                    if (in_array($value, $this->stg_allow_send)) {
                        $cc_array_tmp[] = $value;
                    }
                }
                $this->cc_array = $cc_array_tmp;
                $this->_cc = join(",", (array)$this->cc_array);

            } else {
                $this->_cc = join(",", (array)$this->cc_array);
            }
        } else {
            if ($is_stg && $this->stg_send !== false) {
                $this->_cc = $this->stg_send;
            }
        }

        if (count((array)$this->bcc_array)) {
            if ($is_dev && $this->dev_send !== false) {
                //開発なら、開発用アドレスに
                $this->_bcc = $this->dev_send;
            } elseif ($is_stg && $this->stg_send !== false) {
                $loop = 1;
                foreach ($this->bcc_array as $value) {
                    if (in_array($value, $this->stg_allow_send)) {
                        $bcc_array_tmp[] = $value;
                    } else if ($loop == 1) {
                        $bcc_array_tmp[] = $this->stg_send;
                        $loop++;
                    }
                }
                $this->bcc_array = $bcc_array_tmp;
                $this->_bcc = join(",", (array)$this->bcc_array);
            } else {
                $this->_bcc = join(",", (array)$this->bcc_array);
            }
        }

        //開発なら自動で件名に【DEV】をつける。
        if ($is_dev) {
            $this->subject = "【DEV】".$this->subject;
        } elseif ($is_stg) {
            $this->subject = "【STG】".$this->subject;
        }

        //メールをクリーンな内容にする
        if ($this->auto_clean) {
            $this->setString($this->_to);
            $this->setString($this->_cc);
            $this->setString($this->_bcc);
            $this->setString($this->reply);
            $this->setString($this->subject, true);
            $this->setString($this->keyword);
            $this->setString($this->_from);
            $this->setString($this->body, true, true);
        }
        $this->_header = "From: ".$this->_from
                        .($this->_cc == false ? "" : "\r\nCc: ".$this->_cc)
                        .($this->_bcc == false ? "" : "\r\nBcc: ".$this->_bcc)
                        .($this->reply == false ? "" : "\r\nReply-To: ".$this->reply)
                        .($this->keyword == false ? "" : "\r\nKeyword: ".$this->keyword);

        // 添付ファイル用のヘッダ
        if($this->is_attachment){
            $this->_header .="\r\nMIME-Version: 1.0";
            $this->_header .="\r\nContent-Type: multipart/mixed; boundary=\"".$this->boundary."\"";
        }
        return $this->_header;
    }

    /**
     * ファイルテンプレートパスをセットする
     *
     * @see $smarty
     */
    public function setMailTemplateDir($path)
    {
        $this->smarty->template_dir = $path;
        $this->smarty->config_dir   = $path;
    }

    /**
     * ファイルコンパイルパスをセットする
     *
     * @see $smarty
     */
    public function setMailCompileDir($path)
    {
        $this->smarty->compile_dir = $path;
    }


    /**
     * 置き換え機能付きbodyの作成
     *
     * 本文テンプレートを読み込む
     *
     * @see msg,footerpath
     * @return boolean
     */
    public function setBody($template)
    {
        $this->body = $this->smarty->fetch($template, "EnviSendMailClass", "EnviSendMailClass");
    }

    /**
     * templateにtemplate変数を格納
     *
     * @param string|array $name
     * @param string $value
     */
    public function setAttribute($name, $value = null)
    {
        if (is_array($name)) {
            $this->smarty->assign($name);
        } else {
            $this->smarty->assign($name, $value);
        }
    }

    /**
     * 送信者設定
     *
     * @param strings $address アドレス
     * @param strings $name 名前
     */
    public function setFrom($address, $name=false)
    {
        if($name != false){
            $this->_from = mb_encode_mimeheader($name)."<".$address.">";
        }else{
            $this->_from = $address;
        }
    }

    /**
     * キーワード設定
     *
     * @param strings $keyword キーワード
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * 件名設定
     *
     * @param strings $subject 件名
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * 宛先設定
     *
     * @param strings $address アドレス
     * @param strings $name 名前
     */
    public function setTo($address, $name=false)
    {
        if (is_array($address)) {
            $this->to_array = (array)$this->to_array + $address;
        } elseif ($name != false) {
            $this->to_array[] = mb_encode_mimeheader($name)."<".$address.">";
        } else {
            $this->to_array[] = $address;
        }
    }

    /**
     * Cc設定
     *
     * @param strings $address アドレス
     * @param strings $name 名前
     */
    public function setCc($address, $name=false)
    {
        if (is_array($address)) {
            $this->cc_array = (array)$this->cc_array + $address;
        } elseif ($name != false) {
            $this->cc_array[] = mb_encode_mimeheader($name)."<".$address.">";
        } else {
            $this->cc_array[] = $address;
        }
    }

    /**
     * Bcc設定
     *
     * @param strings $address アドレス
     * @param strings $name 名前
     */
    public function setBcc($address, $name=false)
    {
        if (is_array($address)) {
            $this->bcc_array = (array)$this->bcc_array + $address;
        } elseif ($name != false) {
            $this->bcc_array[] = mb_encode_mimeheader($name)."<".$address.">";
        } else {
            $this->bcc_array[] = $address;
        }
    }

    /**
     * エンコード
     *
     * メールの内容を整える
     *
     * @parm [$msg] string
     * @return string
     */
    public function setString(&$msg, $is_kana = false, $isPre = false)
    {
        if (!$isPre) {
            $msg = str_replace(array("\n", "\r"), "", $msg);
        } elseif($is_kana) {
            $msg = mb_convert_kana($msg, 'KV');
        }
        return $msg;
    }


    /**
     * 添付する
     *
     * @param strings $data 添付データ
     * @param strings $Filename 添付ファイルの名前
     * @param strings $Type mimeヘッダ
     */
    public function addAttachment(&$data, $Filename="", $Type="application/octet-stream")
    {
        $this->is_attachment = TRUE;
        if($Filename == ""){
            $Filename = uniqid("at");
        }
        $s = count($this->attachment);
        $this->attachment[$s]["data"] = $data;
        $this->attachment[$s]["file"] = $Filename;
        $this->attachment[$s]["type"] = $Type;
    }


    /**
     * ファイルを読み込んで添付する
     *
     * @param strings $data 添付データ
     * @param strings $Filename 添付ファイルの名前
     * @param strings $Type mimeヘッダ
     */
    public function getAttachment($file, $rename = false, $Type = "application/octet-stream")
    {
        $data = file_get_contents($file);
        $this->addAttachment(
            $data,
            ($rename!=false ? $rename : basename($file)),
            $Type
        );
    }


    /**
     * エラーメール送信処理
     *
     * エラーメールを送信します。
     *
     * @param bool $isError trueの場合にのみメールを送信する
     * @return void
     */
    public function sendmailError($isError = true)
    {
        if ($isError) {
            $body = "以下の内容のメールを送信しようとしましたが、エラーの為送信出来ませんでした。\r\n"
                        ."宛先:".$this->_to."\r\n"
                        ."送信者:".$this->_from."\r\n"
                        ."CC:".$this->_cc."\r\n"
                        ."BCC:".$this->_bcc."\r\n"
                        ."件名:".$this->subject."\r\n\r\n"
                        ."ヘッダ一覧\r\n\r\n".$this->_header."\r\n\r\n"
                        .mb_strimwidth($this->body, 0, 12000, "・・・・長いメールの為本文の一部を省略しました。")
                        ."\r\n\r\n--------\r\n添付ファイル:".($this->is_attachment ? "あり" : "なし");
            $is_dev = ($this->_ServerInfo->getServerStatus() == SERVER_INFO_STS_DEVELOPMENT);
            $is_stg = ($this->_ServerInfo->getServerStatus() == SERVER_INFO_STS_STAGING);

            $subject = "GpandaSendmail Error Report";

            if ($is_dev) {
                $subject = "【DEV】".$subject;
            } elseif ($is_stg) {
                $this->subject = "【STG】".$this->subject;
            }

            mb_send_mail($this->error_to, $subject, $body, "auto-mail@five-foxes.com");
        }
    }
}
