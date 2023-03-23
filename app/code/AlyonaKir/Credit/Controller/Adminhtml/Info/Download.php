<?php

namespace AlyonaKir\Credit\Controller\Adminhtml\Info;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\DirectoryList;
use Psr\Log\LoggerInterface;

class Download extends Action
{
    protected $downloader;
    protected $logger;
    protected $directory;

    public function __construct(Context $context,
                                FileFactory $fileFactory,
                                LoggerInterface $logger,
                                DirectoryList $directory)
    {
        $this->logger = $logger;
        $this->downloader = $fileFactory;
        $this->directory = $directory;
        parent::__construct($context);
    }

    public function execute()
    {
        $fileContaner = explode('/', $_SESSION['path']);

        $fileName =  array_pop($fileContaner);
        $filePath = $_SESSION['path'];

        try {
            return $this->downloader->create($fileName, [
                'type' => 'filename',
                'value' => $filePath,
            ],
                \Magento\Framework\App\Filesystem\DirectoryList::MEDIA,
                'application/octet-stream');
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
         return true;
    }
}
