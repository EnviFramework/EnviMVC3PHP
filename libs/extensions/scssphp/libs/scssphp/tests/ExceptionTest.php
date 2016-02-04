<?php
/**
 * SCSSPHP
 *
 * @copyright 2012-2015 Leaf Corcoran
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://leafo.github.io/scssphp
 */

namespace Leafo\ScssPhp\Tests;

use Leafo\ScssPhp\Compiler;

/**
 * Exception test
 *
 * @author Leaf Corcoran <leafot@gmail.com>
 */
class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->scss = new Compiler();
    }

    /**
     * @param string $scss
     * @param string $expectedExceptionMessage
     *
     * @dataProvider provideScss
     */
    public function testThrowError($scss, $expectedExceptionMessage)
    {
        try {
            $this->compile($scss);
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), $expectedExceptionMessage) !== false) {
                return;
            };
        }

        $this->fail('Expected exception to be raised: ' . $expectedExceptionMessage);
    }

    /**
     * @return array
     */
    public function provideScss()
    {
        return array(
            array(<<<'END_OF_SCSS'
.test {
  foo : bar;
END_OF_SCSS
                ,
                'unclosed block'
            ),
            array(<<<'END_OF_SCSS'
.test {
}}
END_OF_SCSS
                ,
                'unexpected }'
            ),
            array(<<<'END_OF_SCSS'
.test { color: #fff / 0; }
END_OF_SCSS
                ,
                'color: Can\'t divide by zero'
            ),
            array(<<<'END_OF_SCSS'
.test { left: 300px/0; }
END_OF_SCSS
                ,
                'Division by zero'
            ),
            array(<<<'END_OF_SCSS'
.test {
  @include foo();
}
END_OF_SCSS
                ,
                'Undefined mixin foo'
            ),
            array(<<<'END_OF_SCSS'
@mixin do-nothing() {
}

.test {
  @include do-nothing($a: "hello");
}
END_OF_SCSS
                ,
                'Mixin or function doesn\'t have an argument named $a.'
            ),
            array(<<<'END_OF_SCSS'
div {
  color: darken(cobaltgreen, 10%);
}
END_OF_SCSS
                ,
                'expecting color'
            ),
        );
    }

    private function compile($str)
    {
        return trim($this->scss->compile($str));
    }
}
