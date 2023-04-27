<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Controller\Adminhtml\Info;

use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use Magento\Backend\App\Action\Context;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use Magento\Framework\Registry;
use Magento\Backend\App\Action;

class Edit extends Action
{
    protected $_coreRegistry = null;
    protected $_publicActions = ['edit'];

    protected $creditRepository;
    protected $creditFactory;


    public function __construct(
        Context       $context,
        Registry      $coreRegistry,
        CreditRepositoryFactory $creditRepositoryFactory,
        CreditFactory $creditFactory
    )
    {
        $this->creditRepository = $creditRepositoryFactory->create();
        $this->creditFactory = $creditFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    public function execute(): void
    {

        $formModel = $this->creditFactory->create();
        $formId = $this->getRequest()->getParam('id');

        if ($formId) {
            $fromModel = $this->creditRepository->getById((int)$formId);
            $this->_coreRegistry->register('credit_form', $fromModel);
        }

        $this->_view->loadLayout();
        $this->_setActiveMenu('AlyonaKir_Credit::module');
        $breadcrumbTitle = __('Edit Form');
        $breadcrumbLabel = __('Edit Form');

        $this->_view->getPage()->getConfig()->getTitle()->prepend($fromModel->getId() ? __('Edit Form') : __('New Form'));
        $this->_addBreadcrumb($breadcrumbLabel, $breadcrumbTitle);
        $_SESSION['id'] = $formId;
        $this->_view->renderLayout();
    }
}
