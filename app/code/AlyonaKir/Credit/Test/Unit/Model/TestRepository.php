<?php
declare(strict_types=1);

use Magento\Framework\Api\SearchCriteriaBuilder;
use PHPUnit\Framework\TestCase;
use \PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \AlyonaKir\Credit\Model\CreditRepository
 */
class TestRepository extends TestCase
{

    protected $object;


    private $collectionFactory;

    private $creditResource;


    private $creditFactory;


    private $searchCriteriaBuilder;

    private $searchResultFactory;

    protected function setUp(): void
    {
        $this->collectionFactory = $this->getMockBuilder(\AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\CollectionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->collectionFactory
            ->method('create')
            ->willReturn($this->createMock(\AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\Collection::class));

        $this->creditResource = $this->getMockBuilder(\AlyonaKir\Credit\Model\ResourceModel\Credit\Credit::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->creditFactory = $this->getMockBuilder(\AlyonaKir\Credit\Model\Credit\CreditFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->creditFactory
            ->method('create')
            ->willReturn($this->createMock(\AlyonaKir\Credit\Model\Credit\Credit::class));


        $this->searchCriteriaBuilder = $this->getMockBuilder(SearchCriteriaBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();


        $this->searchResultFactory = $this->getMockBuilder(\AlyonaKir\Credit\Model\Credit\CreditSearchResultFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchResultFactory
            ->method('create')
            ->willReturn($this->createMock(\AlyonaKir\Credit\Model\Credit\CreditSearchResult::class));

        $this->object = new \AlyonaKir\Credit\Model\Credit\CreditRepository(
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
        $model = $this->getMockBuilder(\AlyonaKir\Credit\Model\Credit\Credit::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->creditResource->expects($this->any())
            ->method('save')
            ->with($model);

        $result = $this->object->save($model);

        $this->assertSame($model, $result);
    }

    /** @test */
    public function testDelete()
    {
        $model = $this->getMockBuilder(\AlyonaKir\Credit\Model\Credit\Credit::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->creditResource->expects($this->any())
            ->method('delete')
            ->with($model);

        $result = $this->object->delete($model);

        $this->assertEquals(true, $result);
    }
}
