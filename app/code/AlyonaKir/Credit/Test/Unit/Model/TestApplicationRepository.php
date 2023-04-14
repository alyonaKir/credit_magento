<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Model;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use PHPUnit\Framework\TestCase;
use \PHPUnit\Framework\MockObject\MockObject;
use AlyonaKir\Credit\Model\ResourceModel\Application\Application\CollectionFactory;
use AlyonaKir\Credit\Model\ResourceModel\Application\Application\Collection;
use AlyonaKir\Credit\Model\ResourceModel\Application\Application as ApplicationResource;
use AlyonaKir\Credit\Model\Application\ApplicationFactory;
use AlyonaKir\Credit\Model\Application\Application;
use AlyonaKir\Credit\Model\Application\ApplicationSearchResultsFactory;
use AlyonaKir\Credit\Api\ApplicationSearchResultInterface;
use AlyonaKir\Credit\Model\Application\ApplicationRepository;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\Filter;

/**
 * @covers ApplicationRepository
 */
class TestApplicationRepository extends TestCase
{

    protected ApplicationRepository|MockObject $object;


    private CollectionFactory|MockObject $collectionFactory;

    private ApplicationResource|MockObject $applicationResource;


    private ApplicationFactory|MockObject $applicationFactory;


    private SearchCriteriaBuilder|MockObject $searchCriteriaBuilder;

    private ApplicationSearchResultsFactory|MockObject $searchResultFactory;

    private Application|MockObject $application;

    protected function setUp(): void
    {
        $this->collectionFactory = $this->createPartialMock(
            CollectionFactory::class,
            ['create']
        );

        $this->applicationResource = $this->getMockBuilder(ApplicationResource::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->applicationFactory = $this->createPartialMock(
            ApplicationFactory::class,
            ['create']
        );


        $this->searchCriteriaBuilder = $this->getMockBuilder(SearchCriteriaBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();


        $this->searchResultFactory = $this->createPartialMock(
            ApplicationSearchResultsFactory::class,
            ['create']
        );

        $this->application = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new ApplicationRepository(
            $this->collectionFactory,
            $this->applicationResource,
            $this->applicationFactory,
            $this->searchCriteriaBuilder,
            $this->searchResultFactory
        );

    }

    /** @test */
    public function testSave()
    {
        $model = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->applicationResource->expects($this->any())
            ->method('save')
            ->with($model);

        $result = $this->object->save($model);

        $this->assertSame($model, $result);
    }

    /** @test */
    public function testDelete()
    {
        $model = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->applicationResource->expects($this->any())
            ->method('delete')
            ->with($model);

        $result = $this->object->delete($model);

        $this->assertEquals(true, $result);
    }


    /** @test */
    public function testGetById()
    {
        $ApplicationId = 5;
        $ApplicationMock = $this->createMock(Application::class);
        $ApplicationMock->expects(
            $this->once()
        )->method('getId')->willReturn(
            $ApplicationId
        );

        $this->applicationFactory->expects(
            $this->once()
        )->method('create')->willReturn(
            $ApplicationMock
        );
        $this->applicationResource->expects(
            $this->once()
        )->method('load')->with(
            $ApplicationMock,
            $ApplicationId
        );

        $this->assertEquals($ApplicationMock, $this->object->getById($ApplicationId));
    }


    /** @test */
    public function testGetList()
    {
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
            ->willReturn([$this->application]);

        $searchResultsMock = $this->getMockForAbstractClass(ApplicationSearchResultInterface::class);

        $this->searchResultFactory->expects($this->once())->method('create')->willReturn($searchResultsMock);
        $this->assertEquals(array(), $this->object->getList($searchCriteriaMock));
    }
}
