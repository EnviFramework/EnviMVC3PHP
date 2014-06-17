<?php

/**
 * �e�X�gAssert
 *
 * EnviTestCase�Ōp������邽�ߒ��ڎQ�Ƃ��邱�Ƃ͂���܂��񂪁A
 * EnviTestCase�͂��ׂẮA�e�X�g�Ōp������邽�߁A
 * ���ׂẴe�X�g�̒��ł��̃N���X�ɒ�`����Ă���e�X�g�A�T�[�V�������g�p���邱�Ƃ��o���܂��B
 *
 *
 *
 * @category   �����e�X�g
 * @package    UnitTest
 * @subpackage UnitTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 */
abstract class EnviTestAssert extends EnviTestBase
{
    /**
     * +-- �z��ɃL�[�����邩�ǂ������m�F���A�Ȃ��ꍇ�̓G���[$message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$array�ɃL�[$key�����݂��邩�ǂ������m�F���A���݂��Ȃ��ꍇ�̓G���[$message ��񍐂��܂��B
     *
     * @access public
     * @param string $key �m�F����L�[
     * @param array $array �m�F����z��
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertArrayHasKey($key, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(!is_array($key) && is_array($array))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(array_key_exists($key, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- �z��ɃL�[���Ȃ����ǂ������m�F���A����ꍇ�̓G���[$message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$array�ɃL�[$key�����݂��Ȃ����ǂ������m�F���A���݂���ꍇ�̓G���[$message ��񍐂��܂��B
     *
     * @access public
     * @param string $key �m�F����L�[
     * @param array $array �m�F����z��
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertArrayNotHasKey($key, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(!is_array($key) && is_array($array))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((array_key_exists($key, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $array�ɒl$value�����݂��邩�ǂ������m�F���܂��B ���݂��Ȃ��ꍇ�̓G���[$message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$array�ɒl$value�����݂��邩�ǂ������m�F���܂��B ���݂��Ȃ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $value ���݊m�F����l
     * @param array $array �m�F����z��
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertArrayHasValue($value, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(array_search($value, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $array�ɒl$value�����݂��Ȃ����ǂ������m�F���܂��B ���݂���ꍇ�̓G���[$message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$array�ɒl$value�����݂��邩�ǂ������m�F���܂��B ���݂��Ȃ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $value ���݊m�F����l
     * @param mixed $array �m�F����z��
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertArrayNotHasValue($value, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((array_search($value, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- �z�񂩂ǂ������m�F���܂��B�z��łȂ��ꍇ�̓G���[$message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�z�񂩂ǂ������m�F���܂��B�z��łȂ��ꍇ�̓G���[$message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a �m�F����l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertArray($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(is_array($a))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $class_name::$attribute_name() �����݂��Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$class_name�N���X�ɁA$attribute_name���\�b�h�����݂��邩���m�F���܂��B���݂��Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $attribute_name ���\�b�h��
     * @param mixed $class_name �N���X��
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertClassHasAttribute($attribute_name, $class_name, $message = '')
    {
        $this->assertionExecuteBefore();
        $array = get_class_methods($class_name);
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(array_search($attribute_name, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }

    /**
     * +-- $class_name::attribute_name() �����݂���ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$class_name�N���X�ɁA$attribute_name���\�b�h�����݂��邩���m�F���܂��B���݂��Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $attribute_name ���\�b�h��
     * @param mixed $class_name �N���X��
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertClassNotHasAttribute($attribute_name, $class_name, $message = '')
    {
        $this->assertionExecuteBefore();
        $array = get_class_methods($class_name);
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((array_search($attribute_name, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }

    /**
     * +-- $array�ɒl$value�����݂��邩�ǂ������m�F���܂��B ���݂��Ȃ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$array�ɒl$value�����݂��邩�ǂ������m�F���܂��B ���݂��Ȃ��ꍇ�̓G���[ $message ��񍐂��܂��B
     * assertArrayHasValue�Ƃ̈Ⴂ�́A$value��string�ȊO�g�p�ł������_�ł��B
     *
     * @access public
     * @param mixed $value ���݊m�F����l
     * @param mixed $array �m�F����z��
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertContains($value, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array) || is_array($value)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(array_search($value, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }


    /**
     * +-- $array�ɒl$value�����݂��Ȃ����ǂ������m�F���܂��B ���݂���ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$array�ɒl$value�����݂��Ȃ����ǂ������m�F���܂��B ���݂���ꍇ�̓G���[ $message ��񍐂��܂��B
     * assertArrayNotHasValue�Ƃ̈Ⴂ�́A$value��string�ȊO�g�p�ł������_�ł��B
     *
     * @access public
     * @param mixed $value ���݊m�F����l
     * @param mixed $array �m�F����z��
     * @param string $message OPTIONAL:''
     * @return boolean
     */
    public function assertNotContains($value, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array) || is_array($value)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (array_search($value, $array) !== false) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /**
     * +-- $array�̒��g�̌^�� $type �����ł͂Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�z��$array�̒��g�̌^��$type�ƂȂ��Ă��邩���m�F���܂��B$type�ȊO�����݂��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $type �^�̖��O
     * @param mixed $array �m�F����z��
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertContainsOnly($type, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (is_array($type) || !is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        foreach ($array as $value) {
            if (!(gettype($value) === $type)) {
                throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
            }
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $array�̒��g�̌^�� $type �����̏ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�z��$array�̒��g�̌^��$type�ȊO�ƂȂ��Ă��邩���m�F���܂��B$type�����݂��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $type �^�̖��O
     * @param mixed $array �m�F����z��
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertNotContainsOnly($type, $array, $message = '')
    {
        if (is_array($type) || !is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        foreach ($array as $value) {
            if (gettype($value) === $type) {
                throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
            }
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $array �̗v�f���� $count �łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�z��$array�̗v�f�����A$count�ł��邱�Ƃ��m�F���܂��B�Ⴄ�ꍇ�́A$message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $count �z��̗v�f��
     * @param mixed $array �m�F����z��
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertCount($count, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(count($array) === $count)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $array �̗v�f���� $count �̏ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�z��$array�̗v�f�����A$count�łłȂ����Ƃ��m�F���܂��B�Ⴄ�ꍇ�́A$message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $count �z��̗v�f��
     * @param mixed $array �m�F����z��
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertNotCount($count, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((count($array) === $count)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- ��ł��邩���m�F���A��̏ꍇ�́A�G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����͋�ł��邩���m�F���A��̏ꍇ�́A�G���[ $message ��񍐂��܂��B
     * ���L�̂悤�Ȓl���A��ł���Ɣ��f����܂��B
     * + "" (�󕶎���)
     * + 0 (���� �� 0)
     * + 0.0 (���������_���� 0)
     * + "0" (������ �� 0)
     * + NULL
     * + FALSE
     * + array() (��̔z��)
     * + $var; (�ϐ����錾����Ă��邪�A�l���ݒ肳��Ă��Ȃ�)
     *
     * @access public
     * @param mixed $a �m�F����l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertEmpty($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!empty($a)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- ��łȂ������m�F���A��̏ꍇ�́A�G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����͋�łȂ������m�F���A��̏ꍇ�́A�G���[ $message ��񍐂��܂��B
     * ���L�̂悤�Ȓl���A��ł���Ɣ��f����܂��B
     * + "" (�󕶎���)
     * + 0 (���� �� 0)
     * + 0.0 (���������_���� 0)
     * + "0" (������ �� 0)
     * + NULL
     * + FALSE
     * + array() (��̔z��)
     * + $var; (�ϐ����錾����Ă��邪�A�l���ݒ肳��Ă��Ȃ�)
     *
     * @access public
     * @param mixed $a �m�F����l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertNotEmpty($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (empty($a)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */



    /**
     * +-- 2 �̕ϐ� $a �� $b �����������ǂ������m�F���A�������Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V������2 �̕ϐ� $a �� $b �����������ǂ������m�F���A�������Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a �m�F����l
     * @param mixed $b �m�F����l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertEquals($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a == $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 2 �̕ϐ� $a �� $b ���������Ȃ����ǂ������m�F���A�������ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V������2�̕ϐ� $a �� $b ���������Ȃ����ǂ������m�F���A�������ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a �m�F����l
     * @param mixed $b �m�F����l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertNotEquals($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (($a == $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- false���ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́Afalse���ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a �m�F����l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertFalse($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a === false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- �w�肳�ꂽ�t�@�C���������t�@�C�����ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�w�肳�ꂽ�t�@�C���������t�@�C�����ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $a �m�F����t�@�C����
     * @param string $b �m�F����t�@�C����
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertFileEquals($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(is_file($a) === is_file($b)) || !(file_get_contents($a) === file_get_contents($b))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- �w�肳�ꂽ�t�@�C���������t�@�C���łȂ����ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�w�肳�ꂽ�t�@�C���������t�@�C���łȂ����ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $a �m�F����t�@�C����
     * @param string $b �m�F����t�@�C����
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertFileNotEquals($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(is_file($a) === is_file($b)) || !(file_get_contents($a) === file_get_contents($b))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- �t�@�C�������݂��邩�ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�t�@�C�������݂��邩�ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a �m�F����t�@�C���p�X
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertFileExists($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(file_exists($a))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- �t�@�C�������݂��Ȃ����ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�t�@�C�������݂��Ȃ����ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a �m�F����t�@�C���p�X
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertNotFileExists($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if ((file_exists($a))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a > $b ���ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$a > $b ���ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a �m�F����l
     * @param mixed $b �m�F����l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertGreaterThan($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a > $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a>=$b���ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$a>=$b���ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a �m�F����l
     * @param mixed $b �m�F����l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertGreaterThanOrEqual($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a >= $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $actual �� $expected �̃C���X�^���X�łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$actual �� $expected �̃C���X�^���X�łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $expected �N���X��
     * @param mixed $actual �I�u�W�F�N�g
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertInstanceOf($expected, $actual, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_object($actual) || !is_string($expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!($actual instanceof $expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $actual �� $expected �̃C���X�^���X�̏ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$actual �� $expected �̃C���X�^���X�̏ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $expected �N���X��
     * @param mixed $actual �I�u�W�F�N�g
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertNotInstanceOf($expected, $actual, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_object($actual) || !is_string($expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (($actual instanceof $expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $actual �̌^�� $expected �łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$actual �̌^�� $expected �łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $expected �^��
     * @param mixed $actual ���ׂ�l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertInternalType($expected, $actual, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(gettype($actual) === $expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */
    /**
     * +-- $actual �̌^�� $expected �̏ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$actual �̌^�� $expected �̏ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $expected �^��
     * @param mixed $actual ���ׂ�l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertNotInternalType($expected, $actual, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((gettype($actual) === $expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a<$b���ǂ������m�F���A�����łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$a<$b���ǂ������m�F���A�����łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a ���ׂ�l
     * @param mixed $b ���ׂ�l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertLessThan($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a < $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a<=$b���ǂ������m�F���A�����łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$a<=$b���ǂ������m�F���A�����łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a ���ׂ�l
     * @param mixed $b ���ׂ�l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertLessThanOrEqual($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a <= $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- Null���ǂ������m�F���A�����łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́ANull���ǂ������m�F���A�����łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a ���ׂ�l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertNull($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a === NULL)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- �I�u�W�F�N�g$object�Ƀ��\�b�h$attribute_name �����邩���m�F���A���݂��Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�I�u�W�F�N�g$object�Ƀ��\�b�h$attribute_name �����邩���m�F���A���݂��Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $attribute_name ���\�b�h��
     * @param mixed $object ���ׂ�I�u�W�F�N�g
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertObjectHasAttribute($attribute_name, $object, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($attribute_name)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(method_exists($object, $attribute_name) === true)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- �I�u�W�F�N�g$object�Ƀ��\�b�h$attribute_name ���Ȃ������m�F���A���݂���ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�I�u�W�F�N�g$object�Ƀ��\�b�h$attribute_name ���Ȃ������m�F���A���݂���ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $attribute_name ���\�b�h��
     * @param mixed $object ���ׂ�I�u�W�F�N�g
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertObjectNotHasAttribute($attribute_name, $object, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($attribute_name)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((method_exists($object, $attribute_name) === true)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string �����K�\�� $pattern �Ƀ}�b�`���Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string �����K�\�� $pattern �Ƀ}�b�`���Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $pattern ���K�\��
     * @param mixed $string ���ׂ�l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertRegExp($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_ereg($pattern, $string))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string �����K�\�� $pattern �Ƀ}�b�`����ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string �����K�\�� $pattern �Ƀ}�b�`����ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $pattern ���K�\��
     * @param mixed $string ���ׂ�l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertNotRegExp($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((mb_ereg($pattern, $string))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */



    /**
     * +-- $string ��(Preg)���K�\�� $pattern �Ƀ}�b�`���Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string ��(Preg)���K�\�� $pattern �Ƀ}�b�`���Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $pattern ���K�\��
     * @param mixed $string ���ׂ�l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertPregMatch($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(preg_match($pattern, $string) === true)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string ��(Preg)���K�\�� $pattern �Ƀ}�b�`����ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string ��(Preg)���K�\�� $pattern �Ƀ}�b�`����ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $pattern ���K�\��
     * @param mixed $string ���ׂ�l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertNotPregMatch($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((preg_match($pattern, $string) === true)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */



    /**
     * +-- $string ������������ $pattern �Ƀ}�b�`���Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string ������������ $pattern �Ƀ}�b�`���Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $pattern ����������
     * @param mixed $string ���ׂ�l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertStringMatchesFormat($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(sprintf($pattern, $string) === true)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string ������������ $pattern �Ƀ}�b�`����ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string ������������ $pattern �Ƀ}�b�`����ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param string $pattern ����������
     * @param mixed $string
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertStringNotMatchesFormat($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((sprintf($pattern, $string) === true)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string �� $format_file �̓��e�Ƀ}�b�`���Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string �� $format_file �̓��e�Ƀ}�b�`���Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $format_file �t�@�C���p�X
     * @param mixed $string ������
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertStringMatchesFormatFile($format_file, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($format_file) || !is_string($string) || is_file($format_file)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(file_get_contents($format_file) === $string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $string �� $format_file �̓��e�Ƀ}�b�`����ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string �� $format_file �̓��e�Ƀ}�b�`����ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $format_file �t�@�C���p�X
     * @param mixed $string ������
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertStringNotMatchesFormatFile($format_file, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($format_file) || !is_string($string) || is_file($format_file)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((file_get_contents($format_file) === $string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- �^�ƁA�l���������ǂ������m�F���A�����łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�^�ƁA�l���������ǂ������m�F���A�����łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a �m�F����l
     * @param mixed $b �m�F����l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertSame($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a === $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- �^�ƁA�l���Ⴄ���ǂ������m�F���A�����łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A�^�ƁA�l���Ⴄ���ǂ������m�F���A�����łȂ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a �m�F����l
     * @param mixed $b �m�F����l
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertNotSame($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (($a === $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string �� $suffix �ŏI����Ă��Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string �� $suffix �ŏI����Ă��Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $suffix �I�[������
     * @param mixed $string �m�F���镶����
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertStringEndsWith($suffix, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($suffix) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_strpos($string, $suffix) === mb_strlen($string))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }

    /**
     * +-- $string �� $suffix �ŏI����Ă���ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string �� $suffix �ŏI����Ă���ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $suffix �I�[������
     * @param mixed $string �m�F���镶����
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertStringNotEndsWith($suffix, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($suffix) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((mb_strpos($string, $suffix) === mb_strlen($string))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }

    /**
     * +-- expected_file �Ŏw�肵���t�@�C���̓��e�� $string ���܂܂�Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́Aexpected_file �Ŏw�肵���t�@�C���̓��e�� $string ���܂܂�Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $expected_file �t�@�C���p�X
     * @param mixed $string ���ׂ镶����
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertStringEqualsFile($expected_file, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($expected_file) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_strpos($string, file_get_contents($expected_file)) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- expected_file �Ŏw�肵���t�@�C���̓��e�� $string ���܂܂��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́Aexpected_file �Ŏw�肵���t�@�C���̓��e�� $string ���܂܂��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $expected_file �t�@�C���p�X
     * @param mixed $string ���ׂ镶����
     * @param string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertStringNotEqualsFile($expected_file, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($expected_file) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((mb_strpos($string, file_get_contents($expected_file)) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }

    /**
     * +-- $string �� $prefix �Ŏn�܂��Ă��Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string �� $prefix �Ŏn�܂��Ă��Ȃ��ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access      public
     * @param       mixed $prefix �擪������
     * @param       mixed $string ���ׂ镶����
     * @param       string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return      boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertStringStartsWith($prefix, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($prefix) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_strpos($string, $prefix) === 0)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string �� $prefix �Ŏn�܂��Ă���ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́A$string �� $prefix �Ŏn�܂��Ă���ꍇ�ɃG���[ $message ��񍐂��܂��B
     *
     * @access      public
     * @param       mixed $prefix �擪������
     * @param       mixed $string ���ׂ镶����
     * @param       string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return      boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertStringNotStartsWith($prefix, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($prefix) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_strpos($string, $prefix) === 0)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    public function assertTag()
    {
        $this->assertionExecuteBefore();
            $this->assertionExecuteAfter();
        return true;
    }

    /**
     * +-- �A�T�[�V�����̒ǉ�
     *
     * @access public
     * @param mixed $value
     * @param EnviTestContain $contain
     * @param       string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return      boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertThat($value, EnviTestContain $contain, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($contain->execute($value))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- true���ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * ���̃A�T�[�V�����́Atrue���ǂ������m�F���܂��B �����łȂ��ꍇ�̓G���[ $message ��񍐂��܂��B
     *
     * @access public
     * @param mixed $a �m�F����l
     * @param       string $message OPTIONAL:'' �\������G���[���b�Z�[�W
     * @return      boolean OK�̏ꍇtrue��Ԃ��܂��B �e�X�g��NG�̏ꍇ�́A�����Ԃ��܂���B
     */
    public function assertTrue($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a === true)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */
}

