<?php
/**
 * テスト用dummy
 *
 * @category   EnviTest
 * @package    Envi3
 * @subpackage EnviTest
 * @since File available since Release 1.0.0
 * @author     Akito <akito-artisan@five-foxes.com>
 */

require_once T_ENVI_BASE.'EnviRequest.php';

/**
 * テスト用dummy
 *
 * @category   EnviTest
 * @package    Envi3
 * @subpackage EnviTest
 * @since File available since Release 1.0.0
 * @author     Akito <akito-artisan@five-foxes.com>
 */
class EnviRequestTest extends testCaseBase
{
    public function initialize()
    {
        EnviRequest::cleanAttributes();
    }
    public function setAttributeTest()
    {
        $test_data = 'sample_data';
        EnviRequest::setAttribute('test_data', $test_data);
        $this->assertEquals($test_data, EnviRequest::getAttribute('test_data'));
        
        // 書き換え
        $test_data = 'sample_data2';
        EnviRequest::setAttribute('test_data', $test_data);
        $this->assertEquals($test_data, EnviRequest::getAttribute('test_data'));
        
        
        // 複数データ
        $test_data = 'sample_data2';
        EnviRequest::setAttribute('test_data2', $test_data);
        $this->assertEquals($test_data, EnviRequest::getAttribute('test_data2'));
    }
}
