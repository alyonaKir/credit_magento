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
        $this->saveData();
        return $this->_pageFactory->create();
    }

    private function saveData():void
    {
        $creditRepository = $this->creditRepositoryFactory->create();
        if (isset($_FILES['file']) && isset($_POST['credit_limit'])) {
            try {
                $credit = $this->creditFactory->create();
                $flag = 0;
                if ($_FILES['file']['type'] == 'application/pdf') {
                    $uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/upload/";
                    $uploadfile = $uploaddir . basename($_FILES['file']['name']);
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                        $flag = 1;
                    }
                    $creditData = [
                        'credit_limit' => $_POST['credit_limit'],
                        'file' => ($flag) ? $uploadfile : "no file",
                        'user_id' => $_SESSION['customer_base']['customer_id']
                    ];
                    $credit->setData($creditData);
                    $creditRepository->save($credit);
                } else {
                    $this->messageManager->addErrorMessage("Wrong file type");
                    return;
                }
            } catch (\Exception $ex) {
                $this->messageManager->addErrorMessage("Something went wrong");
            }
            $this->messageManager->addSuccessMessage("The request will be processed in three days.");
        }
    }
}

