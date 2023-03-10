<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Controller\Customer;

use AlyonaKir\Credit\Model\Credit\CreditFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;


class Form extends \Magento\Framework\App\Action\Action
{

    protected $_pageFactory;
    protected $creditFactory;

    protected $creditRepositoryFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context      $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        CreditFactory                              $creditFactory,
        CreditRepositoryFactory                    $creditRepositoryFactory
    )
    {
        $this->creditFactory = $creditFactory;
        $this->creditRepositoryFactory = $creditRepositoryFactory;
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $creditRepository = $this->creditRepositoryFactory->create();
        if (isset($_POST['file']) && isset($_POST['credit_limit'])) {
            $credit = $this->creditFactory->create();
            try {
                $creditData = [
                    'credit_limit' => $_POST['credit_limit'],
                    'file' => $_POST['file']
                ];
                $credit->setData($creditData);
                $creditRepository->save($credit);

            } catch (\Exception $ex) {
                $this->messageManager->addErrorMessage("Something went wrong");
            }
            $this->messageManager->addSuccessMessage("The request will be processed in three days.");
        }

        return $this->_pageFactory->create();
    }
}

