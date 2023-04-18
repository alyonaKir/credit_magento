<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Model;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use PHPUnit\Framework\TestCase;
use \PHPUnit\Framework\MockObject\MockObject;
use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\CollectionFactory;
use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\Collection;
use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit as CreditResource;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use AlyonaKir\Credit\Model\Credit\Credit;
use AlyonaKir\Credit\Model\Credit\CreditSearchResultFactory;
use AlyonaKir\Credit\Model\Credit\CreditSearchResult;
use AlyonaKir\Credit\Api\CreditSearchResultInterface;
use AlyonaKir\Credit\Model\Credit\CreditRepository;

/**
 * @covers \AlyonaKir\Credit\Model\CreditRepository
 */
class TestCreditRepository extends TestCase
{

    protected CreditRepository|MockObject $object;


    private CollectionFactory|MockObject $collectionFactory;

    private CreditResource|MockObject $creditResource;


    private CreditFactory|MockObject $creditFactory;


    private SearchCriteriaBuilder|MockObject $searchCriteriaBuilder;

    private CreditSearchResultFactory|MockObject $searchResultFactory;

    private Credit|MockObject $credit;

    protected function setUp(): void
    {
        $this->collectionFactory = $this->createPartialMock(
            CollectionFactory::class,
            ['create']
        );

        $this->creditResource = $this->getMockBuilder(CreditResource::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->creditFactory = $this->createPartialMock(
            CreditFactory::class,
            ['create']
        );


        $this->searchCriteriaBuilder = $this->getMockBuilder(SearchCriteriaBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();


        $this->searchResultFactory = $this->createPartialMock(
            CreditSearchResultFactory::class,
            ['create']
        );

        $this->credit = $this->getMockBuilder(Credit::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new CreditRepository(
            $this->collectionFactory,
            $this->creditResource,
            $this->creditFactory,
            $this->searchCriteriaBuilder,
            $this->searchResultFactory
        );

    }

    /** @test */
    public function testSave()
    {
        $model = $this->getMockBuilder(Credit::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->creditResource->expects($this->any())
            ->method('save')
            ->with($model);

        $result = $this->object->save($model);

        $this->assertSame($model, $result);
    }

    /** @test */
    public function testGetByApplicationId()
    {
        $applicationId = 5;
        $creditMock = $this->createMock(Credit::class);

        $filter = $this->getMockBuilder(Filter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filter->expects($this->any())
            ->method('getConditionType')
            ->willReturn(0);

        $filterGroup = $this->getMockBuilder(FilterGroup::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filterGroup->expects($this->once())
            ->method('getFilters')
            ->willReturn([$filter]);

        $searchCriteriaMock = $this->createMock(SearchCriteriaInterface::class);
        $searchCriteriaMock->expects($this->once())
            ->method('getFilterGroups')
            ->willReturn([$filterGroup]);

        $this->searchCriteriaBuilder->expects($this->any())
            ->method('create')
            ->willReturn($searchCriteriaMock);
        $searchCriteriaMock = $this->searchCriteriaBuilder->create();

        $collectionMock = $this->createMock(Collection::class);

        $this->collectionFactory->expects($this->once())
            ->method('create')
            ->willReturn($collectionMock);

        $collectionMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn([$creditMock]);

        $searchResultsMock = $this->getMockForAbstractClass(CreditSearchResult::class);

        $this->searchResultFactory->expects($this->once())->method('create')->willReturn($searchResultsMock);

        $this->assertNull($this->object->getByApplicationId($applicationId));
    }



    /** @test */
    public function testDelete()
    {
        $model = $this->getMockBuilder(Credit::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->creditResource->expects($this->any())
            ->method('delete')
            ->with($model);

        $result = $this->object->delete($model);

        $this->assertEquals(true, $result);
    }


    /** @test */
    public function testGetById()
    {
        $creditId = 5;
        $creditMock = $this->createMock(Credit::class);
        $creditMock->expects(
            $this->once()
        )->method('getId')->willReturn(
            $creditId
        );

        $this->creditFactory->expects(
            $this->once()
        )->method('create')->willReturn(
            $creditMock
        );
        $this->creditResource->expects(
            $this->once()
        )->method('load')->with(
            $creditMock,
            $creditId
        );

        $this->assertEquals($creditMock, $this->object->getById($creditId));
    }


    /** @test */
    public function testGetList()
    {
        $filter = $this->getMockBuilder(\Magento\Framework\Api\Filter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filter->expects($this->any())
            ->method('getConditionType')
            ->willReturn(0);

        $filterGroup = $this->getMockBuilder(\Magento\Framework\Api\Search\FilterGroup::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filterGroup->expects($this->once())
            ->method('getFilters')
            ->willReturn([$filter]);

        $searchCriteriaMock = $this->createMock(SearchCriteriaInterface::class);
        $searchCriteriaMock->expects($this->once())
            ->method('getFilterGroups')
            ->willReturn([$filterGroup]);

        $this->searchCriteriaBuilder->expects($this->any())
            ->method('create')
            ->willReturn($searchCriteriaMock);
        $searchCriteriaMock = $this->searchCriteriaBuilder->create();

        $collectionMock = $this->createMock(Collection::class);

        $this->collectionFactory->expects($this->once())
            ->method('create')
            ->willReturn($collectionMock);

        $collectionMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn([$this->credit]);

        $searchResultsMock = $this->getMockForAbstractClass(CreditSearchResultInterface::class);

        $this->searchResultFactory->expects($this->once())->method('create')->willReturn($searchResultsMock);
        $this->assertEquals(array(), $this->object->getList($searchCriteriaMock));
    }
}
