<?php
/**
 * バリデーターのテスト
 *
 * @category   EnviTest
 * @package    Envi3
 * @subpackage EnviTest
 * @since File available since Release 1.0.0
 * @author     Akito <akito-artisan@five-foxes.com>
 */

require_once T_ENVI_BASE.'EnviValidator.php';

/**
 * バリデーターのテスト
 *
 * @category   EnviTest
 * @package    Envi3
 * @subpackage EnviTest
 * @since File available since Release 1.0.0
 * @author     Akito <akito-artisan@five-foxes.com>
 */
class EnviValidateTest extends testCaseBase
{
    public function initialize()
    {
        $_POST = array();
        $_GET  = array();
        validator()->free();
    }
    // +------------------------------------------------
    
    /**
     * +-- type:equalテスト
     *
     * @access      public
     * @return      void
     */
    public function validation_equal_Test()
    {
        $validator = validator();
        $this->assertTrue($validator->validation('equal', 'test', 'test'));
        $this->assertFalse($validator->validation('equal', 'test', 'test2'));
        $this->assertTrue($validator->validation('equal', 'あいうえお', 'あいうえお'));
    }
    /* ----------------------------------------- */
    
    /**
     * +-- type:notequalテスト
     *
     * @access      public
     * @return      void
     */
    public function validation_notequal_Test()
    {
        $validator = validator();
        $this->assertTrue($validator->validation('notequal', 'test', 'test2'));
        $this->assertFalse($validator->validation('notequal', 'test', 'test'));
    }
    /* ----------------------------------------- */
    /**
     * +-- type:xdigitテスト
     *
     * @access      public
     * @return      void
     */
    public function validation_xdigit_Test()
    {
        $validator = validator();
        $this->assertTrue($validator->validation('xdigit', '1234567890abcdef', false));
        $this->assertFalse($validator->validation('xdigit', 'あいうえお', false));
        $this->assertFalse($validator->validation('xdigit', 'asdfghjk', false));
    }
    /* ----------------------------------------- */
    /**
     * +-- type:digitテスト
     *
     * @access      public
     * @return      void
     */
    public function validation_digit_Test()
    {
        $validator = validator();
        $this->assertTrue($validator->validation('digit', '1234567890', false));
        $this->assertFalse($validator->validation('digit', '-1234567890', false));
        $this->assertFalse($validator->validation('digit', '0.123456789', false));
        $this->assertFalse($validator->validation('digit', 'あいうえお', false));
        $this->assertFalse($validator->validation('digit', 'asdfghjk', false));
        $this->assertFalse($validator->validation('digit', '123456789abcdef', false));
    }
    /* ----------------------------------------- */
    
    
    // -------------------------------------------------
    // +------------------------------------------------
    
    /**
     * +-- バリデーター追加のテスト
     *
     * @access      public
     * @return      void
     */
    public function registerValidatorsTest()
    {
        $validator = validator();
        $validator->registerValidators('test_validator', 'envi_validate_test_test_validaror', '{form}test error');
        $this->assertTrue($validator->validation('test_validator', 'test', 'test'));
        $this->assertFalse($validator->validation('test_validator', 'test', 'test2'));
        
        $validator->registerValidators('test_validator2', array(new EnviValidateTestValidator, 'sample'), '{form}test2 error');
        $this->assertTrue($validator->validation('test_validator2', 'test', 'test'));
        $this->assertFalse($validator->validation('test_validator2', 'test', 'test2'));
        
        $_POST['test_data_1'] = 'test1';
        $_POST['test_data_2'] = 'test2';
        $_POST['test_data_3'] = 'test3';
        $_POST['test_data_4'] = 'test4';
        $validator->autoPrepare(array('test_data_1' => 'ttt1'), 'test_validator', true, false, validator::METHOD_POST, 'test1');
        $validator->autoPrepare(array('test_data_3' => 'ttt3'), 'test_validator2', true, false, validator::METHOD_POST, 'test3');
        $res = $validator->executeAll();
        $this->assertFalse($validator->isError($res));
        $this->assertEquals($res['test_data_1'], 'test1');
        $this->assertEquals($res['test_data_3'], 'test3');
        
        
        $validator->autoPrepare(array('test_data_2' => 'ttt2'), 'test_validator', true, false, validator::METHOD_POST, 'test1');
        $validator->autoPrepare(array('test_data_4' => 'ttt4'), 'test_validator2', true, false, validator::METHOD_POST, 'test3');
        $res = $validator->executeAll();
        $this->assertTrue($validator->isError($res));
        $errors = EnviRequest::getErrors();
        $this->assertEquals($errors['message'][0], 'ttt2test error');
        $this->assertEquals($errors['message'][1], 'ttt4test2 error');
    }
    /* ----------------------------------------- */
    
    
    // -------------------------------------------------
    
}

function envi_validate_test_test_validaror($validation_data, $option)
{
    return $validation_data === $option;
}

class EnviValidateTestValidator
{
    public function sample($validation_data, $option)
    {
        return $validation_data === $option;
    }
}
