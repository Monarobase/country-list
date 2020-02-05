<?php
declare(strict_types=1);

namespace Monarobase\CountryList\Tests;

use Monarobase\CountryList\CountryList;
use Monarobase\CountryList\CountryNotFoundException;
use PHPUnit\Framework\TestCase;

class CountryListTest extends TestCase
{
    /**
     * @var CountryList
     */
    private $countryList;

    protected function setUp(): void
    {
        $this->countryList = new CountryList('vendor/umpirsky/country-list/data');
    }

    protected function tearDown(): void
    {
        unset($this->countryList);
        $this->countryList = null;
    }

    /**
     * @test
     */
    public function getDataDirTest(): void
    {
        $this->assertEquals(realpath('vendor/umpirsky/country-list/data'), $this->countryList->getDataDir());
    }

    /**
     * @test
     * @throws \Monarobase\CountryList\CountryNotFoundException
     */
    public function getOneTest(): void
    {
        $this->countryList->setList('xx', [
            'php' => [
                'C' => 'Country C',
                'B' => 'Country B',
                'A' => 'Country A',
            ]
        ]);
        $this->assertEquals('Country B', $this->countryList->getOne('B', 'xx'));

        $this->expectException(CountryNotFoundException::class);
        $this->countryList->getOne('D', 'xx');
    }

    /**
     * @test
     */
    public function getListPHPTest(): void
    {
        $this->countryList->setList('xx', [
            'php' => [
                'C' => 'Country C',
                'B' => 'Country B',
                'A' => 'Country A',
            ]
        ]);

        $this->assertEquals(array_keys([
            'A' => 'Country A',
            'B' => 'Country B',
            'C' => 'Country C',
        ]), array_keys($this->countryList->getList('xx')));

        $this->assertNotEquals(array_keys([
            'C' => 'Country C',
            'A' => 'Country A',
            'B' => 'Country B',
        ]), array_keys($this->countryList->getList('xx')));
    }

    /**
     * @test
     */
    public function getListJSONTest(): void
    {
        $this->countryList->setList('xx', [
            'json' => '{"A":"Country A","B":"Country B","C":"Country C"}'
        ]);

        $this->assertEquals(
            '{"A":"Country A","B":"Country B","C":"Country C"}',
            $this->countryList->getList('xx', 'json')
        );
    }

    /**
     * @test
     */
    public function hasTest(): void
    {
        $this->countryList->setList('xx', [
            'php' => [
                'A' => 'Country A',
                'B' => 'Country B',
                'C' => 'Country C',
            ]
        ]);

        $this->assertTrue($this->countryList->has('A', 'xx'));
        $this->assertFalse($this->countryList->has('D', 'xx'));
    }
}
