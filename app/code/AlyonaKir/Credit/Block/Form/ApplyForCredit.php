<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Block\Form;

use AlyonaKir\Credit\Model\Credit\Credit;
use Magento\Framework\View\Element\Template;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use AlyonaKir\Credit\Model\Config\Source\PurchaseStatus;
use AlyonaKir\Credit\Model\Application\ApplicationRepositoryFactory;

class ApplyForCredit extends Template
{
    protected CreditRepositoryFactory $creditRepositoryFactory;
    protected ApplicationRepositoryFactory $applicationRepositoryFactory;
    protected PurchaseStatus $purchaseStatus;

    protected Credit $object;

    public function __construct(
        CreditRepositoryFactory $creditRepositoryFactory,
        PurchaseStatus          $purchaseStatus,
        ApplicationRepositoryFactory $applicationRepositoryFactory,
        Credit                  $object,
        Template\Context        $context,
        array                   $data = []
    )
    {
        $this->object = $object;
        $this->purchaseStatus = $purchaseStatus;
        $this->applicationRepositoryFactory = $applicationRepositoryFactory;
        $this->creditRepositoryFactory = $creditRepositoryFactory;
        parent::__construct($context, $data);
    }

    public function getStatus(): int
    {
        $userId = $_SESSION['customer_base']['customer_id'];
        $creditRepository = $this->creditRepositoryFactory->create();
        $applicationRepository = $this->applicationRepositoryFactory->create();
        $credits = $creditRepository->getList();

        foreach ($credits as $credit) {
            $application = $applicationRepository->getById((int)$credit->getApplicationId());
            if( $application->getCustomerId() == $userId && $credit->getPurchaseStatus() != 4)
                return (int)$credit->getPurchaseStatus();
        }
        return -1;
    }

    public function getStatusFromOptionsArray(int $i): string
    {
        $options = $this->purchaseStatus->toOptionArray();
        return $options[$i]['label'];
    }

    public function statusDescribe(int $i): string
    {
        return match ($i) {
            0 => 'Please wait for our decision.',
            1 => 'Now we are checking your application.',
            2 => 'Congratulates. Below you\'ll find all information about your credit.',
            3 => 'Below you\'ll find a reason.'
        };
    }

}
