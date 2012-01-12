<?php
/**
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */


/**
 * +-- validator
 *
 * @access public
 * @static
 * @return validator
 */
function validator()
{
    return validator::singleton();
}
/* ----------------------------------------- */

/**
 * 雑多な入力検証を提供する入力検証クラス。
 *
 * よく使う入力検証の機能を集めました。<br>
 * エラーがあれば、エラーオブジェクトを返します。<br>
 * エラークラスをバンドルしていますが、オリジナルの物を使用することもできます。<br><br>
 * バリデータのリスト
 * - "number"           => 数値かどうか。小数点も許容します。(OPTION:なし)
 * - "naturalnumber"    => 整数かどうか。0も許容します。(OPTION:なし)
 * - "integer"          => 数字かどうか。小数点は使用出来ません(OPTION:なし)
 * - "numbermax"        => 数値の最大(OPTION:最大数)
 * - "numbermin"        => 数値の最小(OPTION:際少数)
 * - "alphabet"         => アルファベットかどうか(OPTION:なし)
 * - "alphabetornumber" => アルファベットもしくは数字かどうか(OPTION:なし)
 * - "rome"             => ローマ字区域(半角英語+半角数字+半角記号)の文字列か(OPTION:半角化するか)
 * - "maxlen"           => 最大文字数(OPTION:最大数)
 * - "minlen"           => 最小文字数(OPTION:最小数)
 * - "maxwidth"         => 最大文字幅。全角2半角1(OPTION:最大数)
 * - "minwidth"         => 最小文字幅。全角2半角1(OPTION:最少数)
 * - "blank"            => 空白かどうか(OPTION:なし)
 * - "noblank"          => 空白でないか(OPTION:なし)
 * - "nosubmit"         => 送信されているか(OPTION:なし)
 * - "encoding"         => 文字のエンコーディング(OPTION:エンコード名)
 * - "notags"           => タグが含まれていないか(OPTION:なし)
 * - "depend"           => 機種依存文字が含まれていないか(OPTION:なし)
 * - "mailformat"       => メールフォーマットの文字列になっているか(OPTION:なし)
 * - "mailsimple"       => simpleなメールフォーマットチェック
 * - "mail"             => ドメインも確認(OPTION:なし)
 * - "hiragana"         => ひらがなか(OPTION:カタカナをひらがなに直すか)
 * - "katakana"         => カタカナか(OPTION:ひらがなをカタカナに直すか)
 * - "hfurigana"        => ひらがなのふりがなか(OPTION:カタカナをひらがなに直すか)
 * - "kfurigana"        => カタカナのフリガナか(OPTION:ひらがなをカタカナに直すか)
 * - "urlformat"        => URLフォーマットの文字列になっているか(OPTION:なし)
 * - "url"              => ドメインも確認(OPTION:なし)
 * - "telephone"        => 電話番号のフォーマットになっているか
 * - "postcodeformat"   => 郵便番号のフォーマットになっているか(OPTION:なし)
 * - "whitelist"        => ホワイトリストに含まれているか(OPTION:ホワイトリストの配列)
 * - "date"             => YYYYMMDD形式のデータもしくは配列が、日付フォーマットになっているか(OPTION:array("year" => "年の配列キー","month" => "月の配列キー","day" => "日の配列キー"))
 * - "time"             => 時間フォーマットになっているか(OPTION:時間のフォーマット。定数参照)
 * - "array"            => 配列か(OPTION:なし)
 * - "notarray"         => でないか配列か(OPTION:なし)
 * - "arraykeyexists"   => 配列の中に指定されたキーが入っているか
 * - "arraynumber"      => 配列の中身は全て数字か(OPTION:なし)
 * - "arraynumbermax"   => 配列の中身の数字の合計最大(OPTION:最大数)
 * - "arraynumbermin"   => 配列の中身の数字の合計最小(OPTION:最小数)
 * - "arraycountmax"    => 配列の数の最大(OPTION:最大数)
 * - "arraycountmin"    => 配列の数の最小(OPTION:最小数)
 * - "arrayunique"      => 配列の値がuniqueかどうか(空文字列・NULLはuniqueチェックから省くかどうか)
 * - "maxbr"            => 改行数の最大(OPTION:最大数)
 * - "minbr"            => 改行数の最小(OPTION:最小数)
 * - "dirpath"          => 存在するディレクトリパスか(OPTION:なし)
 * - "file"             => 存在するファイル化(OPTION:なし)
 * - "ereg"             => ルビー互換の正規表現にマッチするか(OPTION:正規表現)
 * - "preg"             => パール互換の正規表現にマッチするか(OPTION:正規表現)
 *
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class validator
{
    const VALIDATE_MODE = 'mode';
    const VALIDATE_DATA = 'data';
    const VALIDATOR       = 'validator';
    const VALIDATOR_CHAIN = 'chain';
    const FORM_NAME        = 'form';
    const HOUR_ONLY        = 2;
    const HOUR_TO_MINUTE   = 4;
    const HOUR_TO_SECOND   = 6;
    const METHOD_POST      = 1;
    const METHOD_GET       = 2;


    private static $_error_object = NULL;

    /**
     * バリデーションチェインのフォーマット
     *
     * バリデーションチェインの既定値グループを登録します。<br>
     * 何度も同じチェインを使用する場合などに便利です。<br>
     * 直接配列で指定可能ですが、メソッドを呼び出して簡単に登録することもできます。<br>
     *
     * @var array Format:
     * <pre>
     * array(
     *    "[フォーマット名]" => array(
     *       "[バリデーションの実行順序]" => array(
     *          "[バリデータ名(半角小文字)]"=> array(
     *             self::VALIDATE_MODE   => [バリデートモード],
     *             self::VALIDATOR_CHAIN => [エラーがおこっても次ぎのバリデータを起動するか],
     *             )
     *       )
     *    )
     * )
     * </pre>
     * @see setChainFormat();
     * @see getChainFormat();
     */
    public $chain_format = array();

    private static $singleton_obj;

    public $error_class  = 'ValidatorError';

    /**#@+
    * @access private
    */

    /**
     * フォームの値が空の場合割り振る値
     *
     * @var mixed
     */
    private $_empty_form_data = false;

    /**
     * Executeされるバリデーションのリスト
     *
     * @var array
     */
    private $_validation_list = array();


    /**
     * 使用可能な、バリデータのリスト
     *
     * @var array
     */
    private $_validator_list = array(
        'number'           => '_typeNumber',
        'naturalnumber'    => '_typeNaturalNumber',
        'integer'          => '_typeInteger',
        'numbermax'        => '_typeNumberMax',
        'numbermin'        => '_typeNumberMin',
        'alphabet'         => '_typeAlphabet',
        'alphabetornumber' => '_typeAlphabetOrNumber',
        'rome'             => '_typeRome',
        'maxlen'           => '_typeMaxLen',
        'minlen'           => '_typeMinLen',
        'maxwidth'         => '_typeMaxWidth',
        'minwidth'         => '_typeMinWidth',
        'blank'            => '_typeBlank',
        'noblank'          => '_typeNoBlank',
        'nosubmit'         => '_typeNoSubmit',
        'encoding'         => '_typeEncoding',
        'notags'           => '_typeNoTags',
        'depend'           => '_typeDepend',
        'mailformat'       => '_typeMailFormat',
        'mailsimple'       => '_typeMailFormatSymple',
        'mail'             => '_typeMail',
        'hiragana'         => '_typeHiragana',
        'katakana'         => '_typeKatakana',
        'hfurigana'        => '_typeHFurigana',
        'kfurigana'        => '_typeKFurigana',
        'urlformat'        => '_typeUrlFormat',
        'url'              => '_typeUrl',
        'postcodeformat'   => '_typePostcodeFormat',
        'telephone'        => '_typeTelephoneFormat',
        'whitelist'        => '_typeWhiteList',
        'date'             => '_typeDate',
        'time'             => '_typeTime',
        'array'            => '_typeArray',
        'notarray'         => '_typeNotArray',
        'arraykeyexists'   => '_typeArrayKeyExists',
        'arraynumber'      => '_typeArrayNumber',
        'arraynumbermax'   => '_typeArrayNumberMax',
        'arraynumbermin'   => '_typeArrayNumberMin',
        'arraycountmax'    => '_typeArrayCountMax',
        'arraycountmin'    => '_typeArrayCountMin',
        'arrayunique'      => '_typeArrayUnique',
        'maxbr'            => '_typeMaxBr',
        'minbr'            => '_typeMinBr',
        'dirpath'          => '_typeDirPath',
        'file'             => '_typeFile',
        'ereg'             => '_typeEreg',
        'preg'             => '_typePreg',
        //'' => '',
    );

    public function &error()
    {
        if(!is_object(self::$_error_object)) {
            self::$_error_object = new $this->error_class();
        }
        return self::$_error_object;
    }
    /**
     * ユーザー定義バリデータのリスト
     *
     * @var array
     */
    private $_register_validators = array();

    /**#@-*/

    /**
     * コンストラクタ
     *
     * @return void
     */
    private function __construct()
    {
        $this->errors =& Request::getErrorsByRef();

    }

    public static function singleton()
    {
        if (!is_object(self::$singleton_obj)) {
            self::$singleton_obj = new validator();
        }

        return self::$singleton_obj;
    }


    /**
     * 実行するバリデータチェイン名を指定して実行
     *
     * 入力検証を実行しエラークラス、もしくは、保証されたデータを受け取ります。<br>
     * isError()メソッドでエラーのチェックを行えます。<br>
     *
     * @param string,array $validation_name バリデートするフォームデータ名
     * @param bool $object_clean エラーオブジェクトを毎回空にするか
     * @see isError()
     * @return array,object
     */
    public function execute($validation_name, $object_clean = TRUE)
    {
        if (is_array($validation_name)) {
            $validation_name = key($validation_name);
        }
        if (!isset($this->_validation_list[$validation_name])) {
            trigger_error("Unknown validator chain selected");
        }

        $validation_datas =& $this->_validation_list[$validation_name];
        // error flag
        $is_error         = false;
        foreach ($validation_datas[self::VALIDATOR] as $validator_data) {
            $each = each ($validator_data);
            $validator = $each["key"];
            $option    = $each["value"];
            //foreach ($validator_data as $validator => $option) {
            //blankチェック以外のblankはすり抜ける
            $ck = $this->_validation($validator, $validation_datas[self::VALIDATE_DATA], $option[self::VALIDATE_MODE]);
            if (!$ck) {
                //エラーハンドリング
                $is_error = true;
                $this->_handleError(
                    $validation_name,
                    $validation_datas[self::FORM_NAME],
                    $validator, $validation_datas[self::VALIDATE_DATA],
                    $option[self::VALIDATE_MODE]
                );
                if($option[self::VALIDATOR_CHAIN] === false){
                    //連続バリデートが不可なら抜ける
                    break;
                }
                continue;
            }
            //}
        }

        //結果
        $res[$validation_name] =& $this->_validation_list[$validation_name][self::VALIDATE_DATA];
        if ($is_error) {
            //エラーの場合
            if ($object_clean === true) {
                $res = self::$_error_object;
                self::$_error_object = null;
            } else {
                return self::$_error_object;
            }
        }
        return $res;
    }

    /**
     * すべて実行
     *
     * 入力検証を全て実行しエラークラス、もしくは、保証されたデータを受け取ります。<br>
     * isError()メソッドでエラーのチェックを行えます。<br>
     *
     * @see isError()
     * @return array,object
     */
    public function executeAll()
    {
        $is_error = false;
        $res = array();
        foreach ($this->_validation_list as $validator_name => $validation_datas) {
            if ($this->isError($this->execute($validator_name, false))){
                $is_error = true;
            }
            //結果
            $res[$validator_name] =& $this->_validation_list[$validator_name][self::VALIDATE_DATA];
        }

        if ($is_error) {
        //エラーが一つでも含まれている場合
            return self::$_error_object;
        } else {
        //正常終了
            return $res;
        }
    }

    /**
     * バリデート機能定義(自動)
     *
     * 検証する入力データを自動で取得・定義して、新規にバリデータにかけます。<br>
     * デフォルト取得されるデータは、$_POST・$_GETの両方からサーチします。<br>
     * $post_only に<br>
     * VM_METHOD_GET(GETのみ)<br>
     * VM_METHOD_POST(POSTのみ)<br>
     * VM_METHOD_POST|VM_METHOD_GET(両方/デフォルトはこれ)<br>
     * を指定することで、受け取るデータに制限をかける事が出来ます。<br>
     * ※上位互換のため、bool型もサポートしていますが、これは推奨されません。<br>
     *
     *
     * @param string,array $validation_name <pre>バリデートするフォームデータ名。
     * array("バリデートするフォームデータ名" => フォーム名)
     * 配列を指定することで、フォーム名をつけることができます。
     * フォーム名は、エラー発生時にエラークラスに渡されます。</pre>
     * @param string|array $validator バリデータ名,$this->getChainFormat()の結果
     * @param bool $validator_chain エラーがあった場合に確認処理を継続するか
     * @param bool $trim 入力検証データをtrimするかどうか
     * @param integer|boolean VM_METHOD_POST = POSTのみ VM_METHOD_GET = GETのみ VM_METHOD_POST|VM_METHOD_GET = POSTかGETのどちらか。
     * @param mix $validate_mode バリデータオプション
     * @see prepare();
     * @return void
     */
    public function autoPrepare($validation_name, $validator, $validator_chain = true, $trim = false, $post_only = 3, $validate_mode = false)
    {
        $this->prepare($validation_name,
            $validator,
            $this->_getValidationData(is_array($validation_name) ? key($validation_name) : $validation_name, $trim, $post_only),
            $validator_chain,
            $validate_mode
        );
    }

    /**
     * バリデート機能定義(手動)
     *
     * 検証する入力データを手動で取得・定義して、新規にバリデータにかけます。
     *
     * @param string,array $validation_name <pre>バリデートするフォームデータ名。
     * array("データ名" => "フォーム名")
     * 配列を指定することで、フォーム名をつけることができます。
     * フォーム名は、エラー発生時にエラークラスに渡されます。</pre>
     * @param string,array $validator バリデータ名,$this->getChainFormat()の結果
     * @param string,bool,object,array,string,int バリデートするデータ
     * @param bool $validator_chain エラーがあった場合に確認処理を継続するか
     * @param bool $trim 入力検証データをtrimするかどうか
     * @param bool $post_only TRUEで、POSTのみ取得
     * @param bool,string,int,array $validate_mode バリデータオプション
     * @see autoPrepare();
     * @return void
     */
    public function prepare($validation_name, $validator, $validation_data, $validator_chain = true, $validate_mode = false)
    {
        if (is_array($validation_name)) {
            //配列が渡されたら、要素をバリデータ名に、値をフォーム名に
            $validation_name_key = key($validation_name);
            $this->_validation_list[$validation_name_key][self::FORM_NAME] = $validation_name[$validation_name_key];
            $validation_name = $validation_name_key;
        }else{
            $this->_validation_list[$validation_name][self::FORM_NAME] = $validation_name;
        }

        $this->_validation_list[$validation_name][self::VALIDATE_DATA] = $validation_data;
        if (is_array($validator)) {
            $this->_validation_list[$validation_name][self::VALIDATOR]=$validator;
        } elseif(isset($this->_validator_list[strtolower($validator)]) ||
                isset($this->_register_validators[strtolower($validator)])) {
            $this->chain($validation_name, $validator, $validator_chain, $validate_mode);
        } else {
            trigger_error("Unknown validator selected", E_USER_ERROR);
        }
    }

    /**
     * ユーザー定義のバリデータを追加する
     *
     * execute()実行時に、<br>
     * userFunction([検証されるデータ], [指定されたオプション]);<br>
     * の形で、指定された関数にわたります。<br>
     * ユーザー定義関数からは、正しい場合true・間違っている場合falseを返してください。<br>

     * @param string $validator_name 読み出しに使用するバリデータ名
     * @param string $function_name 関数名
     * @return void
     */
    public function registerValidators($validator_name, $function_name)
    {
        if (!function_exists($function_name)) {
            trigger_error('No exists function selected', E_USER_ERROR);
        }

        $this->_register_validators[strtolower($validator_name)] = $function_name;
    }

    /**
     * 検証に使用するバリデータを鎖状につなぎます。
     *
     * ひとつの入力データに対して、複数のバリデータを使いたい場合に使用します。<br>
     * バリデータはchain()で呼び出された順番に、実行されます。
     *
     * @param string $validation_name バリデートするフォームデータ名
     * @param string $validator バリデータ名
     * @param bool $validator_chain エラーの場合につなげてバリデート処理を行うか
     * @param bool,string,int,array $validate_mode バリデータオプション
     * @return void
     */
    public function chain($validation_name, $validator, $validator_chain = true, $validate_mode = false)
    {
        if (is_array($validation_name)) {
            $validation_name = key($validation_name);
        }
        if (isset($this->_validation_list[$validation_name])) {
            $this->_validation_list[$validation_name][self::VALIDATOR][][strtolower($validator)] = array(
                                                                self::VALIDATE_MODE   => $validate_mode,
                                                                self::VALIDATOR_CHAIN => $validator_chain,
                                                                );
        } else {
            $this->autoPrepare($validation_name, $validator, $validator_chain, $validate_mode);
        }

    }

    /**
     * チェインのフォーマットを作成します
     *
     * 入力検証のフォーマットを作成して、簡単に再利用可能にします。
     *
     * @param string $group フォーマットグループ名
     * @param string $validator バリデータ名
     * @param string,int $order チェインされる順番
     * @param bool $validator_chain エラーの場合につなげてバリデート処理を行うか
     * @param bool,string,int,array $validate_mode バリデータオプション
     * @see getChainFormat()
     * @return void
     */
    public function setChainFormat($group, $validator, $order = 'AUTO', $validator_chain = true, $validate_mode = false)
    {
        if (is_numeric($order)) {
            $this->chain_format[$group][(int)$order][strtolower($validator)] = array(
                                                                self::VALIDATE_MODE   => $validate_mode,
                                                                self::VALIDATOR_CHAIN => $validator_chain,
                                                                );
        } else {
            $this->chain_format[$group][][strtolower($validator)] = array(
                                                                self::VALIDATE_MODE   => $validate_mode,
                                                                self::VALIDATOR_CHAIN => $validator_chain,
                                                                );
        }
    }

    /**
     * チェインのフォーマットを返します
     *
     * setChainFormat()メソッドなどで指定された、フォーマットを返します。
     * <code>
     * $vm->autoPrepare(array("mail" => "メールアドレス", $vm->getChainFormat("mail"));
     * $res = $vm->execute("mail");
     * var_dump($vm->isError($res));
     *
     * return bool
     * </code>
     *
     * @param string $group フォーマットグループ名
     * @see setChainFormat();
     * @see prepare();
     * @see autoPrepare();
     * @return array
     */
    public function getChainFormat($group)
    {
        return $this->chain_format[$group];
    }

    /**
     * バリデータの使用をキャンセルする
     *
     * 一度チェインされたバリデータの使用をキャンセルします。<br>
     * 全てのチェインを消す場合は、free()メソッドが高速です。
     *
     * @param $validation_name バリデーション名
     * @param $validator キャンセルするバリデータ
     * @see free()
     * @return void
     */
    public function unchain($validation_name, $validator)
    {
        foreach ($this->_validation_list[$validation_name][self::VALIDATOR] as $key => $value) {
            if(isset($value[strtolower($validator)])){
                unset($this->_validation_list[$validation_name][self::VALIDATOR][$key]);
                break;
            }
        }
    }

    /**
     * バリデート結果がエラーかどうかを判断する
     *
     * バリデート結果がエラーかどうかを判断し、実行結果はエラーの場合に、TRUEを返します。
     *
     * @param object,string,int,array $result execute()・executeAllの結果
     * @return bool
     */
    public function isError($result)
    {
        return $result instanceof $this->error_class;

    }

    /**
     * 初期化
     *
     * ValidatorMagicの初期化をします。<br>
     * 全てのエラー、チェインは空になります。
     *
     * @return void
     */
    public function free()
    {
        $this->_validation_list = array();
        self::$_error_object = null;
    }

    /**
     * 簡単にバリデートする
     *
     * 入力データを簡単に検証します。
     * 正しければ、TRUE違っていれば、FALSEを返します。
     *
     * @param string $validator 使用するバリデータ
     * @param string,arrray $data バリデータにかけるデータ
     * @param string,array $option バリデータオプション
     * @return bool
     */
    public function validation($validator, $data, $option)
    {
        $validator = strtolower($validator);
        return $this->_validation($validator, $data, $option);
    }


    /**
     * エラーオブジェクトを直接指定する
     *
     * @param object &$error_obj
     * @return void
     */
    public function setErrorObject($error_obj)
    {
        self::$_error_object =& $error_obj;
        $this->error_class = get_class($error_obj);
    }

    /**
     * 空欄フォームの標準値を設定する
     *
     * @param object $empty_form_data
     * @return void
     */
    public function setEmptyFormData($empty_form_data)
    {
        $this->_empty_form_data = $empty_form_data;
    }

    /**#@+
     * @access private
     * @return void
     */

    /**
     * バリデートする
     *
     * @param string $validator 使用するバリデータ
     * @param string,arrray $data バリデータにかけるデータ
     * @param string,array $option バリデータオプション
     * @access private
     * @return bool
     */
    protected function _validation(&$validator, &$data, &$option)
    {
        if (($validator !== "blank" && $validator !== "noblank") ?
            $this->_typeNoBlank($data, false) : true) {
            if (isset($this->_validator_list[$validator])) {
                $method =& $this->_validator_list[$validator];
                $ck = $this->$method($data, $option);
            } elseif (isset($this->_register_validators[$validator])) {
                $ck = call_user_func_array($this->_register_validators[$validator], array($data, $option));
            } else {
                trigger_error("Unknown validator selected", E_USER_ERROR);
            }
        } else {
            return true;
        }
        return $ck;
    }

    /**
     * バリデートするデータを取得
     *
     * @param string $validation_name バリデーションチェイン名
     * @param bool $trim trimするか？
     * @param bool $post_only POSTのみ取得
     * @return mixed
     */
    protected function _getValidationData($validation_name, &$trim, &$post_only)
    {

        if (!strstr($validation_name, '[')) {
            if (($post_only == 3 || $post_only == 1 || is_bool($post_only)) &&
                (array_key_exists($validation_name, $_POST) !== false ? $_POST[$validation_name] !== "" : false)) {
                $res = $_POST[$validation_name];
            } elseif (($post_only == 3 || $post_only == 2 || $post_only === false) &&
                (array_key_exists($validation_name, $_GET) !== false ? $_GET[$validation_name] !== "" : false)) {
                $res = $_GET[$validation_name];
            } else {
                $res = $this->_empty_form_data;
            }

        } else {
            $regs = array();
            preg_match_all("/([^\\[]*)\\[([^\\]]*)\\]/", $validation_name, $regs);
            if (($post_only == 3 || $post_only == 1 || is_bool($post_only)) &&
                (array_key_exists($regs[1][0], $_POST) !== false ? $_POST[$regs[1][0]] !== "" : false)) {
                $res = $_POST[$regs[1][0]];
            } elseif (($post_only == 3 || $post_only == 2 || $post_only === false) &&
                (array_key_exists($regs[1][0], $_GET) !== false ? $_GET[$regs[1][0]] !== "" : false)) {
                $res = $_GET[$regs[1][0]];
            } else {
                $res = $this->_empty_form_data;
            }
            foreach ($regs[2] as $value) {
                if (isset($res[$value])) {
                    $res = $res[$value];
                } else {
                    $res = $this->_empty_form_data;
                    break;
                }
            }

        }
        if($trim == true) {
            $this->_trimmer($res);
        }
        return $res;
    }

    /**
     * 再帰的にtrimする
     *
     * @param string,array $validation_data trimするデータ
     *
     */
    protected function _trimmer(&$validation_data)
    {
        if(is_array($validation_data)){
            foreach ($validation_data as $key => $value) {
                $this->_trimmer($validation_data[$key]);
            }
        }elseif(is_string($validation_data)){
            $validation_data = trim($validation_data);
        }
    }

    /**
     * エラー処理
     *
     * @param string $name バリデータチェイン名
     * @return void
     */
    protected function _handleError($name, $form_name, $validator, $data, $option)
    {
        if(!is_object(self::$_error_object)) {
            self::$_error_object = new $this->error_class();
        }
        self::$_error_object->setError($name, $form_name, $validator, $data, $option);
    }


    /**#@-*/

    /* ここからバリデータメソッド */

    /**#@+
     * @access private
     * @return bool
    */

    /**
     * 数字かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeNumber(&$ValidationData, $dummy)
    {
        return is_numeric($ValidationData);
    }

    /**
     * X以下の数字かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $max 最大値
     */
    protected function _typeNumberMax(&$ValidationData, &$max)
    {
        return is_numeric($ValidationData) ? $max >= $ValidationData : false;
    }

    /**
     * X以上の数字かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $min 最小値
     */
    protected function _typeNumberMin(&$ValidationData, &$min)
    {
        return is_numeric($ValidationData) ? $min <= $ValidationData : false;
    }

    /**
     * 電話番号かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeTelephoneFormat(&$ValidationData, $dummy)
    {
        return preg_match('/^[0-9][0-9\-]*[0-9]$/', $ValidationData);
    }

    /**
     * アルファベットかどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeAlphabet(&$ValidationData, $dummy)
    {
        return preg_match("/^[a-zA-Z]+$/", $ValidationData);

    }

    /**
     * アルファベットもしくは数字かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeAlphabetOrNumber(&$ValidationData, $dummy)
    {
        return preg_match("/^[a-zA-Z0-9]+$/", $ValidationData);

    }

    /**
     * ローマ字区域の文字列かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $convert 半角変換するか？
     */
    protected function _typeRome(&$ValidationData, $convert)
    {
        if ($convert) {
            $ValidationData = mb_convert_kana($ValidationData, "a");
        }
        return preg_match("/^[\!-\~]+$/", $ValidationData);
    }

    /**
     * 整数かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeInteger(&$ValidationData, $dummy)
    {
        if (preg_match("/^[0-9]$/", $ValidationData)) {
            return true;
        }
        return preg_match("/^-?[1-9][0-9]*$/", $ValidationData);

    }

    /**
     * 自然数かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeNaturalNumber(&$ValidationData, $dummy)
    {
        if (preg_match("/^[0-9]$/", $ValidationData)) {
            return true;
        }
        return preg_match("/^[1-9][0-9]*$/", $ValidationData);

    }

    /**
     * 文字数が既定値以内かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $max 最大値
     */
    protected function _typeMaxLen(&$ValidationData, &$max)
    {
        return $max >= mb_strlen($ValidationData);
    }


    /**
     * 文字数が既定値以上かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $min 最小値
     */
    protected function _typeMinLen(&$ValidationData, &$min)
    {
        return $min <= mb_strlen($ValidationData);
    }

    /**
     * 文字はばが既定値以内かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $max 最大値
     */
    protected function _typeMaxWidth(&$ValidationData, &$max)
    {
        return $max >= mb_strwidth($ValidationData);
    }


    /**
     * 文字はばが既定値以上かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $min 最小値
     */
    protected function _typeMinWidth(&$ValidationData, &$min)
    {
        return $min <= mb_strwidth($ValidationData);
    }

    /**
     * 空欄(もしくは送信されていない)かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeBlank(&$ValidationData, $dummy)
    {
        if (!is_array($ValidationData)) {
            return strlen($ValidationData) == 0;
        } else {
            foreach ($ValidationData as $value) {
                $res = $this->_typeNoBlank($value, $dummy);
                if ($res) {
                    return true;
                }
            }
        }
    }


    /**
     * 空欄(もしくは送信されていない)になっていないかどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeNoBlank(&$ValidationData, $dummy)
    {
        if (!is_array($ValidationData)) {
            return strlen($ValidationData) > 0;
        } else {
            foreach ($ValidationData as $value) {
                $res = $this->_typeNoBlank($value, $dummy);
                if ($res) {
                    return true;
                }
            }
        }
    }

    /**
     * 非送信になっていないかどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeNoSubmit(&$ValidationData, $dummy)
    {
        return $ValidationData !== false;
    }

    /**
     * 文字コードが既定値どおりになっているか？
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param strings $encoding エンコード名
     */
    protected function _typeEncoding(&$ValidationData, &$encoding)
    {
        if (!is_array($ValidationData)) {
            return mb_detect_encoding($ValidationData) == $encoding;
        } else {
            $ck = each($ValidationData);
            return mb_detect_encoding($ck) == $encoding;
        }
    }

    /**
     * タグが含まれていないか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeNoTags(&$ValidationData, $dummy)
    {
        if (is_array($ValidationData)) {
            false;
        }
        return strip_tags($ValidationData) == $ValidationData;
    }

    /**
     * 機種依存文字
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $kana 半角カナを全角カナに
     */
    protected function _typeDepend(&$ValidationData, &$kana)
    {
        if (is_array($ValidationData)) {
            false;
        }
        if ($kana == true) {
            $ValidationData = mb_convert_kana($ValidationData,"KV");
        }
        $_DEPEND_CHAR_PRE     = '(?-xism:(?<!\x8F))';
        $_DEPEND_CHAR_PATTERN = '[\xA9\xAA\xAB\xAC\xAD\xF9\xFA\xFB\xFC][\xA1-\xFE]';
        $_DEPEND_CHAR_POST    = '(?x-ism:(?=(?:[\xA1-\xFE][\xA1-\xFE])*(?:[\x00-\x7F\x8E\x8F]|\z)))';
        $REG_PATTERN  = "/".$_DEPEND_CHAR_PRE."(".$_DEPEND_CHAR_PATTERN.")".$_DEPEND_CHAR_POST."/";
        return preg_match($REG_PATTERN, mb_convert_encoding($ValidationData, 'EUC-JP-win')) == false;
    }

    /**
     * ひらがな
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $kana 全角片カナ・半角片カナを全角平がなに変える
     */
    protected function _typeHiragana(&$ValidationData, &$kana)
    {
        if (is_array($ValidationData)) {
            false;
        }
        if ($kana == true) {
            $ValidationData = mb_convert_kana($ValidationData,"HVc");
        }
        return mb_ereg("^[ぁ-ん]+$",$ValidationData) != false;
    }

    /**
     * カタカナ
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $kana 全角平がな・半角片カナを全角片カナに変える
     */
    protected function _typeKatakana(&$ValidationData, &$kana)
    {
        if (is_array($ValidationData)) {
            false;
        }
        if ($kana == true) {
            $ValidationData = mb_convert_kana($ValidationData,"KVC");
        }
        return mb_ereg("^[ァ-ヶ]+$",$ValidationData) != false;
    }

    /**
     * ひらがなのふりがな
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $kana 全角片カナ・半角片カナを全角平がなに変える
     */
    protected function _typeHFurigana(&$ValidationData, &$kana)
    {
        if (is_array($ValidationData)) {
            false;
        }
        if ($kana == true) {
            $ValidationData = mb_convert_kana($ValidationData,'HVc');
        }
        return mb_ereg('^[ぁ-んー]+$',$ValidationData) != false;
    }

    /**
     * カタカナのフリガナ
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $kana 全角平がな・半角片カナを全角片カナに変える
     */
    protected function _typeKFurigana(&$ValidationData, &$kana)
    {
        if (is_array($ValidationData)) {
            false;
        }
        if ($kana == true) {
            $ValidationData = mb_convert_kana($ValidationData,'KVC');
        }
        return mb_ereg('^[ァ-ヶー]+$',$ValidationData) != false;
    }

    /**
     * メールアドレスフォーマット
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $kana 全角英数字を半角に変換
     * @link http://www.din.or.jp/~ohzaki/perl.htm
     */
    protected function _typeMailFormat(&$ValidationData, &$kana)
    {
        if (is_array($ValidationData)) {
            false;
        }
        if ($kana == true) {
            $ValidationData = mb_convert_kana($ValidationData,"a");
        }
        $REG_PATTERN = '/(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")(?:\.(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*"))*@(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])(?:\.(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\]))+/';
        return preg_match($REG_PATTERN, $ValidationData) != false;
    }

    /**
     * シンプルなメールアドレスフォーマット
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $kana 全角英数字を半角に変換
     */
    protected function _typeMailFormatSymple(&$ValidationData, &$kana)
    {
        if (is_array($ValidationData)) {
            false;
        }
        if ($kana == true) {
            $ValidationData = mb_convert_kana($ValidationData,"a");
        }
        $REG_PATTERN = '/^[0-9a-zA-Z!#$%&=\-|_\/+\^\~][0-9a-zA-Z!#$%&=\-|_\/+.\^\~]*@[0-9a-zA-Z!#$%&=\-|_\/+\^\~]+\.[0-9a-zA-Z!#$%&=\-|_\/+.\^\~]*[a-zA-Z]$/';
        return preg_match($REG_PATTERN, $ValidationData) != false;
    }

    /**
     * URLフォーマット
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $kana 全角英数字を半角に変換
     * @link http://bakera.jp/hatomaru.aspx/yomoyama/perlnote
     */
    protected function _typeUrlFormat(&$ValidationData, &$kana)
    {
        if (is_array($ValidationData)) {
            false;
        }
        if ($kana == true) {
            $ValidationData = mb_convert_kana($ValidationData,"a");
        }
        $REG_PATTERN = "/\b(?:https?|shttp|ftp):\/\/(?:(?:[-_.!~*'()a-zA-Z0-9;:&=+$,]|%[0-9A-Fa-f][0-9A-Fa-f])*@)?(?:(?:[a-zA-Z0-9](?:[-a-zA-Z0-9]*[a-zA-Z0-9])?\.)*[a-zA-Z](?:[-a-zA-Z0-9]*[a-zA-Z0-9])?\.?|[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)(?::[0-9]*)?(?:\/(?:[-_.!~*'()a-zA-Z0-9:@&=+$,]|%[0-9A-Fa-f][0-9A-Fa-f])*(?:;(?:[-_.!~*'()a-zA-Z0-9:@&=+$,]|%[0-9A-Fa-f][0-9A-Fa-f])*)*(?:\/(?:[-_.!~*'()a-zA-Z0-9:@&=+$,]|%[0-9A-Fa-f][0-9A-Fa-f])*(?:;(?:[-_.!~*'()a-zA-Z0-9:@&=+$,]|%[0-9A-Fa-f][0-9A-Fa-f])*)*)*)?(?:\?(?:[-_.!~*'()a-zA-Z0-9;\/?:@&=+$,]|%[0-9A-Fa-f][0-9A-Fa-f])*)?(?:#(?:[-_.!~*'()a-zA-Z0-9;\/?:@&=+$,]|%[0-9A-Fa-f][0-9A-Fa-f])*)?/";
        return preg_match($REG_PATTERN, $ValidationData) != false;
    }

    /**
     * 郵便番号フォーマット
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $kana 全角英数字を半角に変換
     */
    protected function _typePostcodeFormat(&$ValidationData, &$kana)
    {
        if (is_array($ValidationData)) {
            false;
        }
        $REG_PATTERN = "/^\d{3}-\d{4}$|^\d{3}-\d{2}$|^\d{3}$/";
        return preg_match($REG_PATTERN, $ValidationData) != false;
    }

    /**
     * メールアドレス
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $kana 全角英数字を半角に変換
     */
    protected function _typeMail(&$ValidationData, &$kana)
    {
        if (is_array($ValidationData)) {
            false;
        }
        if ($this->_typeMailFormatSymple($ValidationData, $kana)) {
            list($user, $host) = explode('@',$ValidationData);
            if (gethostbyname($host)) {
                return true;
            }
        }
        return false;
    }

    /**
     * URL
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $kana 全角英数字を半角に変換
     */
    protected function _typeUrl(&$ValidationData, &$kana)
    {
        if (is_array($ValidationData)) {
            false;
        }
        if ($this->_typeUrlFormat($ValidationData, $kana)) {
            $a = parse_url($ValidationData);
            $host = $a["host"];
            if (gethostbyname($host)) {
                return true;
            }
        }
        return false;
    }

    /**
     * WhiteListに入っているデータかどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param array $White_list ホワイトリスト
     */
    protected function _typeWhiteList(&$ValidationData, &$WhiteList)
    {
        if (is_array($ValidationData)) {
            false;
        }
        return array_search($ValidationData, $WhiteList) !== false;

    }

    /**
     * 有効な日付かどうか
     *
     * 日付の有効性をチェックします。
     * YYYYMMDDフォーマットのデータの他に、配列を使用することが出来ます。
     * $DateListに、年月日に対応する配列名を入れる事で日付配列のチェックも出来ます。
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param array,bool $DateList array(month(月の配列名),day(日の配列名),year(年の配列名))
     */
    protected function _typeDate(&$ValidationData, &$DateList)
    {
        //プログラマレベルのエラー
        if(is_array($DateList)){
            isset($DateList["month"]) ? true : trigger_error("Nooption DateList[month] type date", E_USER_ERROR);
            isset($DateList["day"]) ? true : trigger_error("Nooption DateList[day] type date", E_USER_ERROR);
            isset($DateList["year"]) ? true : trigger_error("Nooption DateList[year] type date", E_USER_ERROR);
        }

        if (!is_array($ValidationData)) {
            if (strlen($ValidationData) == 8) {
                $month = (int)substr($ValidationData, 4, 2);
                $day   = (int)substr($ValidationData, 6, 2);
                $year  = (int)substr($ValidationData, 0, 4);
            } elseif (strtotime ($ValidationData) != -1) {
                $month = (int)strftime("%m", strtotime($ValidationData));
                $day   = (int)strftime("%d", strtotime($ValidationData));
                $year  = (int)strftime("%Y", strtotime($ValidationData));
            } else {
                return false;
            }
        } elseif((is_array($ValidationData)) ?
            (
                isset($ValidationData[$DateList["month"]]) &&
                isset($ValidationData[$DateList["day"]]) &&
                isset($ValidationData[$DateList["year"]])
            ) : false
        ) {
            $month = (int)$ValidationData[$DateList["month"]];
            $day   = (int)$ValidationData[$DateList["day"]];
            $year  = (int)$ValidationData[$DateList["year"]];
        } else {
            return false;
        }
        return checkdate($month, $day, $year);
    }

    /**
     * 有効な時間かどうか
     *
     * 時間の有効性をチェックします。
     * HH || HHMM || HHMMSS フォーマットのデータの他に、配列を使用することが出来ます。
     * $DateListに、時分病秒に対応する配列名を入れる事で時間配列のチェックも出来ます。
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param array,int $TimeFormat array(hour(時の配列名),minute(分の配列名),second(秒の配列名)),VM_HOUR_ONLY,VM_HOUR_TO_MINUTE,VM_HOUR_TO_SECOND
     */
    protected function _typeTime(&$ValidationData, &$TimeFormat)
    {
        //プログラマレベルのエラー
        if(is_array($TimeFormat)){
            isset($TimeFormat["hour"]) ? true : trigger_error("Nooption TimeFormat[hour] type time", E_USER_ERROR);
            isset($TimeFormat["minute"]) ? true : trigger_error("Nooption TimeFormat[minute] type time", E_USER_ERROR);
            isset($TimeFormat["second"]) ? true : trigger_error("Nooption TimeFormat[second] type time", E_USER_ERROR);
        }else{
            $format = array(2=>2,4=>4,6=>6);
            isset($format[$TimeFormat]) ? true : trigger_error("Undefined option selected type time", E_USER_ERROR);
        }

        if (!is_array($ValidationData) && !is_array($TimeFormat)) {
            $len = strlen($ValidationData);
            if($len != $TimeFormat){
                return false;
            }
            $hour   = (int)substr($ValidationData, 0, 2);
            $minute = ($len == 4 || $len == 6) ? (int)substr($ValidationData, 2, 2) : 0;
            $second = $len == 6 ? (int)substr($ValidationData, 4, 2) : 0;
        } elseif ((is_array($ValidationData) && is_array($TimeFormat)) ?
            (
                isset($ValidationData[$TimeFormat["hour"]]) &&
                isset($ValidationData[$TimeFormat["minute"]]) &&
                isset($ValidationData[$TimeFormat["second"]])
            ) : false
        ) {
            $hour     = (int)$ValidationData[$TimeFormat["hour"]];
            $minute   = (int)$ValidationData[$TimeFormat["minute"]];
            $second   = (int)$ValidationData[$TimeFormat["second"]];
        } else {
            return false;
        }
            return ($hour >= 0 && $minute >= 0 && $second >= 0 && $hour <= 24 && $minute < 60 && $second < 60);
    }

    /**
     * 配列かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeArray(&$ValidationData, $dummy)
    {
        return is_array($ValidationData);
    }

    /**
     * 配列で無いかかどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeNotArray(&$ValidationData, $dummy)
    {
        return !is_array($ValidationData);
    }

    /**
     * 配列で送信されたデータで、指定されたキーが送信されているかどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param array|string|int $key キー
     */
    protected function _typeArrayKeyExists(&$ValidationData, $keys)
    {
        if (is_array($ValidationData)) {
            if (is_array($keys)){
                foreach ($keys as $value) {
                    if (!array_key_exists($value, $ValidationData)) {
                        return false;
                    }
                }
            } elseif (!array_key_exists($keys, $ValidationData)) {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     * 数字のみの配列かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param bool $dummy ダミー変数
     */
    protected function _typeArrayNumber(&$ValidationData, $dummy)
    {
        if ($this->_typeArray($ValidationData, $dummy)) {
            foreach ($ValidationData as $key => $value) {
                if (!$this->_typeNumber($value, $dummy)) {
                    return false;
                }
            }
            return true;
        }
        //配列で無ければエラー
        return false;
    }

    /**
     * 数字のみの配列の合計が既定値以内かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $max 最大値
     */
    protected function _typeArrayNumberMax(&$ValidationData, &$max)
    {
        if ($this->_typeArrayNumber($ValidationData, $max) ? $max >= array_sum($ValidationData) : false) {
            return true;
        }
        return false;
    }

    /**
     * 数字のみの配列の合計が既定値以上かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $min 最小値
     */
    protected function _typeArrayNumberMin(&$ValidationData, &$min)
    {
        if ($this->_typeArrayNumber($ValidationData, $min) ? $min <= array_sum($ValidationData) : false) {
            return true;
        }
        return false;
    }

    /**
     * 配列の数が指定より少ないか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $max 最大値
     */
    protected function _typeArrayCountMax(&$ValidationData, &$max)
    {
        if(!$this->_typeArray($ValidationData, $max)){
            return false;
        }
        return count($ValidationData) <= $max;
    }

    /**
     * 配列の数が指定より多いか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $min 最小値
     */
    protected function _typeArrayCountMin(&$ValidationData, &$min)
    {
        if(!$this->_typeArray($ValidationData, $min)){
            return false;
        }
        return count($ValidationData) >= $min;
    }

    /**
     * 改行数が指定より少ないか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $max 最大値
     */
    protected function _typeMaxBr(&$ValidationData, &$max)
    {
        return count(explode("\n", $ValidationData, $max+1)) <= $max;
    }

    /**
     * 改行数が指定より多いか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param integer $min 最小値
     */
    protected function _typeMinBr(&$ValidationData, &$min)
    {
        return count(explode("\n", $ValidationData, $min+1)) >= $min;
    }

    /**
     * 指定されたファイルが、指定されたディレクトリ上にあるか
     *
     * @param strings $ValidationData 入力検証を行う変数
     * @param strings $ 最小値
     */
    protected function _typeDirPath(&$ValidationData, &$path)
    {
        return dirname(@realpath($ValidationData)) === realpath($path);
    }

    /**
     * 指定されたファイルが存在するかどうか
     *
     * @param strings $ValidationData 入力検証を行う変数
     * @param string $dummy ダミー変数
     */
    protected function _typeFile(&$ValidationData, $dummy)
    {
        clearstatcache();
        return is_file($ValidationData);
    }

    /**
     * 正規表現にマッチするかどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param string $regformat 正規表現文字列
     */
    protected function _typeEreg(&$ValidationData, &$regformat)
    {
        if (is_array($ValidationData)) {
            false;
        }
        return mb_ereg($regformat, $ValidationData) != false;
    }

    /**
     * 正規表現にマッチするかどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param string $regformat 正規表現文字列
     */
    protected function _typePreg(&$ValidationData, &$regformat)
    {
        if (is_array($ValidationData)) {
            false;
        }
        return preg_match($regformat, $ValidationData) != false;
    }

    /**
     * すべての値がユニークな配列かどうか
     *
     * @param strings,array $ValidationData 入力検証を行う変数
     * @param string $skip_blank 空の値をスキップして、ユニークチェックするかどうか (OPTIONAL)
     */
    protected function _typeArrayUnique($ValidationData, $skip_blank = true)
    {
        $ValidationData = array_values($ValidationData);
        if ($skip_blank) {
            $ValidationData = array_filter($ValidationData, 'strlen');
        }
        return $ValidationData === array_unique($ValidationData);
    }

}

/**
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class ValidatorError
{
    /**#@+
    * @access private
    */
    protected $_error_message;
    protected $_error_list   = array();
    protected $_error_default_list = array(
        'number'           => '{form}は数字で入力してください。',
        'naturalnumber'    => '{form}は数値で入力してください。',
        'integer'          => '{form}は数値で入力してください。',
        'numbermax'        => '{form}は{option}以下で入力してください。',
        'numbermin'        => '{form}は{option}以上で入力してください。',
        'alphabet'         => '{form}はアルファベットで入力してください。',
        'alphabetornumber' => '{form}はアルファベットか数字で入力してください。',
        'rome'             => '{form}はローマ字で入力してください。',
        'maxlen'           => '{form}は{option}文字以下で入力してください。',
        'minlen'           => '{form}は{option}文字以上で入力してください。',
        'maxwidth'         => '{form}は半角{option}文字以下で入力してください。',
        'minwidth'         => '{form}は半角{option}文字以上で入力してください。',
        'noblank'          => '{form}を入力してください。',
        'nosubmit'         => '{form}を入力してください。',
        'encoding'         => '{form}を正しく送信してください。',
        'notags'           => '{form}にはタグを使用で来ません。',
        'depend'           => '{form}に機種依存文字が含まれています。',
        'mailformat'       => '{form}がメールアドレスになっていません。',
        'mailsimple'       => '{form}がメールアドレスになっていません。',
        'mail'             => '{form}は正しいメールアドレスではありません。',
        'hiragana'         => '{form}はひらがなで入力してください。',
        'katakana'         => '{form}はカタカナで入力してください。',
        'hfurigana'        => '{form}はひらがなで入力してください。',
        'kfurigana'        => '{form}はカタカナで入力してください。',
        'urlformat'        => '{form}がURLになっていません。',
        'url'              => '{form}のようなURLは存在しません。',
        'telephone'        => '{form}の入力は正しくありません。',
        'postcodeformat'   => '{form}のような郵便番号はありません。',
        'whitelist'        => '{form}のを入力してください。',
        'date'             => '{form}が正しい日付になっていません。',
        'time'             => '{form}が正しい時間になっていません。',
        'array'            => '{form}を正しく入力してください。',
        'arraynumber'      => '{form}が数字になっていません。',
        'arraynumbermax'   => '{form}は{option}以下で入力してください。',
        'arraynumbermin'   => '{form}は{option}以上で入力してください。',
        'arraycountmax'    => '{form}を正しく入力してください。',
        'arraycountmin'    => '{form}を正しく入力してください。',
        'arrayunique'      => '{form}が重複しています。',
        'maxbr'            => '{form}の改行が多すぎます。',
        'minbr'            => '{form}の改行が少なすぎます。',
        'dirpath'          => '不正なリクエストです。',
        'file'             => '不正なリクエストです。',
        'ereg'             => '{form}の入力は正しくありません。',
        'preg'             => '{form}の入力は正しくありません。',
    );
    /**#@-*/

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct()
    {
        $this->_error_message =& Request::getErrorsByRef();
        if (Envi()->getConfiguration('SYSTEM', 'use_i18n')) {
            $this->_error_list = Envi()->getI18n('validator');
        }
    }

    /**
     * エラーのセット
     *
     * @param string $name バリデーションチェイン名
     * @param string $form_name フォーム名
     * @param string $validator バリデータ名
     * @param string|array $data データ
     * @param mixed $option 渡されたoption
     * @param int $id エラーコード
     * @return void
     */
    public function setError($name, $form_name, $validator, $data, $option)
    {
        $mess = isset($this->_error_list[$name][$validator]) ? $this->_error_list[$name][$validator] : $this->_error_default_list[$validator];
        $this->_error_message[$name][$validator] = str_replace(
            array(
                '{name}',
                '{form}',
                '{option}',
                '{data}',
            ),
            array(
                $name,
                $form_name,
                $this->_array2str($option),
                $this->_array2str($data),
            ),
            $mess
        );
    }

    /**
     * エラーメッセージのセット
     *
     * @param string $name バリデーションチェイン名
     * @param string $validator バリデータ名
     * @param string $message エラーメッセージ
     * @return void
     */
    public function setErrorMess($name, $validator, $message)
    {
        $this->_error_message[$name][$validator] = $message;
    }


    /**
     * エラーメッセージのセット
     *
     * @param string $name バリデーションチェイン名
     * @param string $validator バリデータ名
     * @param string $message エラーメッセージ
     * @return void
     */
    public function setErrorList($name, $validator, $message)
    {
        $this->_error_list[$name][$validator] = $message;
    }

    /**
     * エラーメッセージを受け取る
     *
     * @param string,bool $name エラーを取りたいバリデーションチェイン名。空にすると全て取得
     * @return array
     */
    public function getErrorMessage($name = false)
    {
        return $name == false ? $this->_error_message : $this->_error_message[$name];
    }


    /**
     * Errorの詳細を取得します。
     *
     * @return array
     */
    public function getErrorDetail()
    {
        $i = 0;
        foreach ($this->_error_message as $key => $values) {
            foreach ($values as $id => $value) {
                $res['message'][$i] = $value;
                $res['code'][$i] = $this->_error_code[$key][$id];
                $res['keys'][$key][] = $i;
                $i++;
            }
        }
        $res['count'] = $i;
        return $res;
    }

    /**
     * 配列をstring型に強制変換
     *
     * @param array|string $arr 変換したい配列
     */
    public function _array2str($arr)
    {
        if (is_array($arr)) {
            return $this->_array2str(current($arr));
        }
        return $arr;
    }
}