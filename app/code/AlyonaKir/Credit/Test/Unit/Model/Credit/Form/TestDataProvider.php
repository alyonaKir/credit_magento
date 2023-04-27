<?php

declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Model\Credit\Form;

use AlyonaKir\Credit\Model\Credit\Credit;
use AlyonaKir\Credit\Model\Credit\Form\DataProvider;
use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\Collection;
use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\CollectionFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers \AlyonaKir\Credit\Model\Credit\Form\DataProvider */
class TestDataProvider extends TestCase
{
    /**
     * @var CollectionFactory|MockObject
     */
    private $collectionFactoryMock;

    /**
     * @var Collection|MockObject
     */
    private $collectionMock;

    /**
     * @var DataProvider
     */
    private $dataProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->collectionMock = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collectionFactoryMock = $this->getMockBuilder(CollectionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collectionFactoryMock->method('create')
            ->willReturn($this->collectionMock);

        $this->dataProvider = new DataProvider(
            'credit_form_data_provider',
            'credit_id',
            'credit_id',
            $this->collectionFactoryMock,
            [],
            []
        );
    }

    /** @test */
    public function testGetData()
    {
        $creditMock = $this->getMockBuilder(Credit::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getData', 'getCreditId', 'getFile'])
            ->getMock();

        $creditMock->method('getData')
            ->willReturn(['name' => 'John', 'status' => 1]);

        $creditMock->method('getCreditId')
            ->willReturn(123);

        $creditMock->method('getFile')
            ->willReturn('https://example.com/file.pdf');

        $this->collectionMock->method('getItems')
            ->willReturn([$creditMock]);

        $expectedData = [
            123 => [
                'credit_fieldset' => ['name' => 'John', 'status' => 1, 'my_url' => 'https://example.com/file.pdf']
            ]
        ];

        $this->assertEquals($expectedData, $this->dataProvider->getData());
    }
}
