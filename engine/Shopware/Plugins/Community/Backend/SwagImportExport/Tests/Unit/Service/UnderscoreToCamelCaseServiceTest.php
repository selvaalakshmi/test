<?php
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagImportExport\Tests\Unit\Service;

use Shopware\Components\SwagImportExport\Service\UnderscoreToCamelCaseService;

class UnderscoreToCamelCaseServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider test_underscoreToCamelCase_provider
     *
     * @param $string
     * @param $expectedResult
     */
    public function test_underscoreToCamelCase($string, $expectedResult)
    {
        $service = new UnderscoreToCamelCaseService();

        $result = $service->underscoreToCamelCase($string);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function test_underscoreToCamelCase_provider()
    {
        return [
            [null, ''],
            ['', ''],
            [234, '234'],
            [234.123, '234.123'],
            ['foo_10_bar', 'foo_10Bar'],
            ['foo_10_bar_this_is_1_test', 'foo_10BarThisIs_1Test'],
            ['foo_10_bar_this_is_a_2._test', 'foo_10BarThisIsA_2.Test'],
            ['this_is_a_test', 'thisIsATest'],
            ['thisIs_a_test', 'thisIsATest'],
            ['this is_a_test', 'this isATest'],
            ['this is a_test', 'this is aTest'],
            ['this is a test', 'this is a test'],
            ['one_more_test', 'oneMoreTest'],
        ];
    }
}
