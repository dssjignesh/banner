<?php

declare(strict_types=1);

namespace Dss\Banner\Model;

use Exception;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class ImageUploader
{
    public const BASE_TMP_PATH = "wysiwyg/banner/";
    public const BASE_PATH = "wysiwyg/banner/";
    public const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png'];

    /**
     * @var string
     */
    public $baseTmpPath;
    /**
     * @var string
     */
    public $basePath;
    /**
     * @var string[]
     */
    public $allowedExtensions;

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    private $mediaDirectory;
    
    /**
     * ImageUploader constructor.
     * @param Database $coreFileStorageDatabase
     * @param \Magento\Framework\Filesystem $filesystem
     * @param UploaderFactory $uploaderFactory
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        private Database $coreFileStorageDatabase,
        \Magento\Framework\Filesystem $filesystem,
        private UploaderFactory $uploaderFactory,
        private StoreManagerInterface $storeManager,
        private LoggerInterface $logger
    ) {
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->baseTmpPath = self::BASE_TMP_PATH;
        $this->basePath = self::BASE_PATH;
        $this->allowedExtensions = self::ALLOWED_EXTENSIONS;
    }

    /**
     * MoveFileFromTmp
     *
     * @param string $imageName
     *
     * @return string
     * @throws LocalizedException
     */
    public function moveFileFromTmp(string $imageName): string
    {
        $baseTmpPath = $this->getBaseTmpPath();
        $basePath = $this->getBasePath();
        $baseImagePath = $this->getFilePath($basePath, $imageName);
        $baseTmpImagePath = $this->getFilePath($baseTmpPath, $imageName);
        try {
            $this->coreFileStorageDatabase->copyFile(
                $baseTmpImagePath,
                $baseImagePath
            );
            $this->mediaDirectory->renameFile(
                $baseTmpImagePath,
                $baseImagePath
            );
        } catch (Exception $e) {
            throw new LocalizedException(
                __('Something went wrong while saving the file(s).')
            );
        }
        return $imageName;
    }

    /**
     * GetBaseTmpPath
     *
     * @return string
     */
    public function getBaseTmpPath(): string
    {
        return $this->baseTmpPath;
    }

    /**
     * SetBaseTmpPath
     *
     * @param string $baseTmpPath
     */
    public function setBaseTmpPath(string $baseTmpPath)
    {
        $this->baseTmpPath = $baseTmpPath;
    }

    /**
     * GetBasePath
     *
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * SetBasePath
     *
     * @param string $basePath
     */
    public function setBasePath(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * GetFilePath
     *
     * @param string $path
     * @param string $imageName
     *
     * @return string
     */
    public function getFilePath($path, $imageName): string
    {
        return rtrim($path, '/') . '/' . ltrim($imageName, '/');
    }

    /**
     * SaveFileToTmpDir
     *
     * @param void $fileId
     *
     * @return mixed
     *
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function saveFileToTmpDir($fileId): mixed
    {
        $baseTmpPath = $this->getBaseTmpPath();
        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowedExtensions($this->getAllowedExtensions());
        $uploader->setAllowRenameFiles(true);
        $result = $uploader->save($this->mediaDirectory->getAbsolutePath($baseTmpPath));
        if (!$result) {
            throw new LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }

        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['path'] = str_replace('\\', '/', $result['path']);
        $result['url'] = $this->storeManager
                ->getStore()
                ->getBaseUrl(
                    UrlInterface::URL_TYPE_MEDIA
                ) . $this->getFilePath($baseTmpPath, $result['file']);
        $result['name'] = $result['file'];
        if (isset($result['file'])) {
            try {
                $relativePath = rtrim($baseTmpPath, '/') . '/' . ltrim($result['file'], '/');
                $this->coreFileStorageDatabase->saveFile($relativePath);
            } catch (Exception $e) {
                $this->logger->critical($e);
                throw new LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }
        return $result;
    }

    /**
     * GetAllowedExtensions
     *
     * @return string[]
     * @return array
     */
    public function getAllowedExtensions(): array
    {
        return $this->allowedExtensions;
    }

    /**
     * SetAllowedExtensions
     *
     * @param array $allowedExtensions
     */
    public function setAllowedExtensions(array $allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }
    
    /**
     * SaveMediaImage
     *
     * @param Mixed $imageName
     * @param mixed $imagePath
     *
     * @return Mixed
     */
    public function saveMediaImage($imageName, $imagePath): Mixed
    {
        $baseTmpPath = $this->getBaseTmpPath();
        $basePath = $this->getBasePath();
        $baseImagePath = $this->getFilePath($basePath, $imageName);
        $mediaPath = substr($imagePath, 0, strpos($imagePath, "media"));
        $baseTmpImagePath = str_replace($mediaPath . "media/", "", $imagePath);
        if ($baseImagePath == $baseTmpImagePath) {
            return $imageName;
        }
        try {
            $this->mediaDirectory->copyFile(
                $baseTmpImagePath,
                $baseImagePath
            );
        } catch (Exception $e) {
            throw new LocalizedException(
                __('Something went wrong while saving the file(s).')
            );
        }
        return $imageName;
    }
}
