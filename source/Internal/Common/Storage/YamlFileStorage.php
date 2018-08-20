<?php
declare(strict_types = 1);

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Common\Storage;

use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlFileDao
 */
class YamlFileStorage implements ArrayStorageInterface
{
    /**
     * @var FileLocatorInterface
     */
    private $fileLocator;

    /**
     * @var string
     */
    private $filePath;

    /**
     * YamlFileStorage constructor.
     * @param FileLocatorInterface $fileLocator
     * @param string               $filePath
     */
    public function __construct(FileLocatorInterface $fileLocator, string $filePath)
    {
        $this->fileLocator = $fileLocator;
        $this->filePath = $filePath;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return Yaml::parse(
            $this->getLocatedFilePath()
        );
    }

    /**
     * @param array $data
     */
    public function save(array $data)
    {
        file_put_contents(
            $this->getLocatedFilePath(),
            Yaml::dump($data)
        );
    }

    /**
     * @return string
     */
    private function getLocatedFilePath()
    {
        try {
            $filePath = $this->fileLocator->locate($this->filePath);
        } catch (FileLocatorFileNotFoundException $exception) {
            touch($this->filePath);
            $filePath = $this->fileLocator->locate($this->filePath);
        }

        return $filePath;
    }
}
