<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Controller\Customer;

use AlyonaKir\Credit\Model\Application\Application;
use AlyonaKir\Credit\Model\Application\ApplicationFactory;
use AlyonaKir\Credit\Model\Application\ApplicationRepositoryFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Filesystem\DirectoryList;

class Form implements ActionInterface
{

    protected PageFactory $_pageFactory;
    protected ApplicationFactory $applicationFactory;

    protected ApplicationRepositoryFactory $applicationRepositoryFactory;
    protected CreditFactory $creditFactory;
    protected CreditRepositoryFactory $creditRepositoryFactory;

    private File $file;
    private DirectoryList $dir;

    public function __construct(
        Context                      $context,
        PageFactory                  $pageFactory,
        CreditFactory                $creditFactory,
        CreditRepositoryFactory      $creditRepositoryFactory,
        ApplicationFactory           $applicationFactory,
        ApplicationRepositoryFactory $applicationRepositoryFactory,
        File                         $file,
        DirectoryList                $dir,
    )
    {
        $this->applicationFactory = $applicationFactory;
        $this->applicationRepositoryFactory = $applicationRepositoryFactory;
        $this->creditFactory = $creditFactory;
        $this->creditRepositoryFactory = $creditRepositoryFactory;
        $this->_pageFactory = $pageFactory;
        $this->file = $file;
        $this->dir = $dir;
    }

    public function execute(): Page
    {
        $this->saveData();
        return $this->_pageFactory->create();
    }

    private function saveData(): void
    {
        $applicationRepository = $this->applicationRepositoryFactory->create();
        if (isset($_FILES['file']) && isset($_POST['credit_amount'])) {
            try {
                $application = $this->applicationFactory->create();
                $flag = 0;
                if ($_FILES['file']['type'] == 'application/pdf') {

                    $uploaddir = $this->getFileImportFolder();
                    $uploadfile = $uploaddir . basename($_FILES['file']['name']);
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                        $flag = 1;
                    }
                    $applicationData = [
                        'first_name' => $_POST['first_name'],
                        'last_name' => $_POST['last_name'],
                        'email' => $_POST['email'],
                        'phone' => $_POST['phone_number'],
                        'credit_amount' => $_POST['credit_amount'],
                        'file' => ($flag) ? "/pub/upload/" . basename($_FILES['file']['name']) : "no file",
                        'customer_id' => $_SESSION['customer_base']['customer_id']
                    ];
                    $application->setData($applicationData);
                    $applicationRepository->save($application);
                    $creditRepository = $this->creditRepositoryFactory->create();
                    $credit = $this->creditFactory->create();

                    $creditData = [
                        'credit_limit' => $application->getCreditAmount(),
                        'file' => $application->getFile(),
                        'application_id' => $application->getApplicationId()
                    ];
                    $credit->setData($creditData);
                    $creditRepository->save($credit);
                } else {
                    $this->messageManager->addErrorMessage("Wrong file type");
                    return;
                }
            } catch (\Exception $ex) {
                //$this->addErrorMessage("Something went wrong ".$ex);
            }
            //$this->messageManager->addSuccessMessage("The request will be processed in three days.");
        }
    }

    private function getFileImportFolder()
    {
        $upload = $this->dir->getPath('pub') . '/upload';
        if (!file_exists($upload)) {
            $this->file->mkdir($upload);
        }
        return $upload . '/';
    }
}

