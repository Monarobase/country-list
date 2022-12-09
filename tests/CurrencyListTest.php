<?php
declare(strict_types=1);

namespace Clarity\CurrencyList\Tests;

use Clarity\CurrencyList\CurrencyList;
use Clarity\CurrencyList\CurrencyNotFoundException;
use PHPUnit\Framework\TestCase;

class CurrencyListTest extends TestCase
{
    /**
     * @var CurrencyList
     */
    private $currencyList;

    protected function setUp(): void
    {
        $this->currencyList = new CurrencyList('vendor/umpirsky/currency-list/data');
    }

    protected function tearDown(): void
    {
        unset($this->currencyList);
        $this->currencyList = null;
    }

    /**
     * @test
     */
    public function getDataDirTest(): void
    {
        $this->assertEquals(realpath('vendor/umpirsky/currency-list/data'), $this->currencyList->getDataDir());
    }

    /**
     * @test
     * @throws \Clarity\CurrencyList\CurrencyNotFoundException
     */
    public function getOneTest(): void
    {
        $this->currencyList->setList('xx', [
            'php' => [
                'C' => 'Currency C',
                'B' => 'Currency B',
                'A' => 'Currency A',
            ]
        ]);
        $this->assertEquals('Currency B', $this->currencyList->getOne('B', 'xx'));

        $this->expectException(CurrencyNotFoundException::class);
        $this->currencyList->getOne('D', 'xx');
    }

    /**
     * @test
     */
    public function getListPHPTest(): void
    {
        $this->currencyList->setList('xx', [
            'php' => [
                'C' => 'Currency C',
                'B' => 'Currency B',
                'A' => 'Currency A',
            ]
        ]);

        $this->assertEquals(array_keys([
            'A' => 'Currency A',
            'B' => 'Currency B',
            'C' => 'Currency C',
        ]), array_keys($this->currencyList->getList('xx')));

        $this->assertNotEquals(array_keys([
            'C' => 'Currency C',
            'A' => 'Currency A',
            'B' => 'Currency B',
        ]), array_keys($this->currencyList->getList('xx')));
    }

    /**
     * @test
     */
    public function getListJSONTest(): void
    {
        $this->currencyList->setList('xx', [
            'json' => '{"A":"Currency A","B":"Currency B","C":"Currency C"}'
        ]);

        $this->assertEquals(
            '{"A":"Currency A","B":"Currency B","C":"Currency C"}',
            $this->currencyList->getList('xx', 'json')
        );
    }

    /**
     * @test
     */
    public function hasTest(): void
    {
        $this->currencyList->setList('xx', [
            'php' => [
                'A' => 'Currency A',
                'B' => 'Currency B',
                'C' => 'Currency C',
            ]
        ]);

        $this->assertTrue($this->currencyList->has('A', 'xx'));
        $this->assertFalse($this->currencyList->has('D', 'xx'));
    }
}
