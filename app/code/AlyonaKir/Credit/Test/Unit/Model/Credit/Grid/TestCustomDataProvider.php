<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Model\Credit\Grid;

use AlyonaKir\Credit\Api\ApplicationRepositoryInterface;
use AlyonaKir\Credit\Model\Credit\Grid\CustomDataProvider;
use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\Collection;
use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\CollectionFactory;
use Magento\Backend\Model\Url;;

use Magento\Framework\Api\Filter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers CustomDataProvider */
class TestCustomDataProvider extends TestCase
{
    /**
     * @var CustomDataProvider
     */
    protected CustomDataProvider $dataProvider;

    /**
     * @var Collection|MockObject
     */
    protected $collectionMock;

    /**
     * @var ApplicationRepositoryInterface|MockObject
     */
    protected $applicationRepositoryMock;

    /**
     * @var Url|MockObject
     */
    protected $urlMock;

    protected function setUp(): void
    {
        $this->collectionMock = $this->createMock(Collection::class);
        $collectionFactoryMock = $this->createMock(CollectionFactory::class);
        $collectionFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->collectionMock);

        $this->applicationRepositoryMock = $this->createMock(ApplicationRepositoryInterface::class);
        $this->urlMock = $this->createMock(Url::class);

        $this->dataProvider = new CustomDataProvider(
            'credit_grid_data_source',
            'credit_id',
            'application_id',
            $collectionFactoryMock,
            $this->applicationRepositoryMock,
            $this->urlMock
        );
    }

    /** @test */
    public function testGetData(): void
    {
        $this->collectionMock->method('toArray')
            ->willReturn([
                'totalRecords' => 1,
                'items' => array([
                    'application_id'=>1
                ])]);
        $_SERVER['HTTP_HOST'] = "example";
        $data = [
            'totalRecords' => null,
            'items' => array(['application_id'=>1, 'userName'=> ' ', 'link' => 'https://example/backend/customer/index/edit/id/0/key/'])
        ];
        $this->assertSame($data, $this->dataProvider->getData());
    }

    /** @test */
    public function testAddField(): void
    {
        $field = "id";
        $this->dataProvider->addField($field);
    }

    /** @test */
    public function testAddFilter(): void
    {
        $filter = $this->getMockBuilder(Filter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filter->expects($this->any())
            ->method('getField')
            ->willReturn("test_field");

        $this->dataProvider->addFilter($filter);
    }
}
