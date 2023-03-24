<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Controller\Customer;

use AlyonaKir\Credit\Model\Credit\CreditFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use Magento\Framework\View\Result\Page;
use \Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Filesystem\DirectoryList;

class Form extends Action
{

    protected PageFactory $_pageFactory;
    protected CreditFactory $creditFactory;

    protected CreditRepositoryFactory $creditRepositoryFactory;

    private File $file;
    private DirectoryList $dir;

    public function __construct(
        Context                 $context,
        PageFactory             $pageFactory,
        CreditFactory           $creditFactory,
        CreditRepositoryFactory $creditRepositoryFactory,
        File $file,
        DirectoryList $dir,
    )
    {
        $this->creditFactory = $creditFactory;
        $this->creditRepositoryFactory = $creditRepositoryFactory;
        $this->_pageFactory = $pageFactory;
        $this->file = $file;
        $this->dir = $dir;
        return parent::__construct($context);
    }

    public function execute(): Page
    {
        $this->saveData();
        return $this->_pageFactory->create();
    }

    private function saveData(): void
    {
        $creditRepository = $this->creditRepositoryFactory->create();
        if (isset($_FILES['file']) && isset($_POST['credit_limit'])) {
            try {
                $credit = $this->creditFactory->create();
                $flag = 0;
                if ($_FILES['file']['type'] == 'application/pdf') {

                    $uploaddir = $this->getFileImportFolder() ;
                    $uploadfile = $uploaddir . basename($_FILES['file']['name']);
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                        $flag = 1;
                    }
                    $creditData = [
                        'credit_limit' => $_POST['credit_limit'],
                        'file' => ($flag) ? "/pub/upload/".basename($_FILES['file']['name']) : "no file",
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

    private function getFileImportFolder()
    {
        $upload = $this->dir->getPath('pub').'/upload';
        if ( ! file_exists($upload)) {
            $this->file->mkdir($upload);
        }
        return $upload . '/';
    }
}

