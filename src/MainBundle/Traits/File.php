<?php

namespace MainBundle\Traits;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class File
 * @package MainBundle\Traits
 */
trait File
{
    /**
     * @Assert\Image(
     *     maxSize="1000000",
     *     mimeTypes = {
     *              "image/png",
     *              "image/jpeg",
     *              "image/jpg",
     *              "image/gif",
     *              "application/pdf",
     *              "application/x-pdf",
     *              "image/vnd-wap-wbmp",
     *              "application/msword",
     *              "application/vnd.oasis.opendocument.text",
     *              "application/doc"
     *          },
     *     minWidthMessage = "file.max_extension",
     *     minHeightMessage = "file.min_extension",
     *     mimeTypesMessage = "file.extension_error",
     * )
     */
    protected $file;

    /**
     * @ORM\Column(name="file_original_name", type="string", length=160, nullable=true)
     * @Groups({"files"})
     */
    protected $fileOriginalName;

    /**
     * @ORM\Column(name="file_name", type="string", length=70, nullable=true)
     * @Groups({"files"})
     */
    protected $fileName;

    /**
     * @var integer
     * @ORM\Column(name="file_size", type="integer", nullable=true)
     * @Groups({"files"})
     */
    protected $fileSize;

    /**
     * @ORM\Column(name="type", type="string")
     * @Groups({"files"})
     */
    protected $type = 'jpeg';

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set FileOriginalName
     *
     * @param string $fileOriginalName
     * @return $this
     */
    public function setFileOriginalName($fileOriginalName)
    {
        $this->fileOriginalName = $fileOriginalName;

        return $this;
    }

    /**
     * Get fileOriginalName
     *
     * @return string
     */
    public function getFileOriginalName()
    {
        return $this->fileOriginalName;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return $this
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set fileSize
     *
     * @param integer $fileSize
     * @return $this
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    /**
     * Get fileSize
     *
     * @return integer
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * This function is used to return file web path
     *
     * @return string
     * @VirtualProperty()
     * @Groups({"files"})
     */
    public function getDownloadLink()
    {
        return $this->fileName ? '/' . $this->getUploadDir() . '/' . $this->getPath() . '/' . $this->fileName : null;
    }

    /**
     * @return string
     */
    public function getAbsolutePath()
    {
        return $this->getUploadRootDir() . '/' . $this->getPath() .'/';
    }

    /**
     * This function is used to return file web path
     *
     * @return string
     */
    public function getUploadRootDir()
    {
        return __DIR__. '/../../../web/' . $this->getUploadDir();
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return 'files';
    }

    /**
     * Upload folder name
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads';
    }

    /**
     * @ORM\PreRemove
     */
    public function preRemove()
    {
        // get origin file path
        $filePath = $this->getAbsolutePath() . $this->getFileName();

        // check file and remove
        if (file_exists($filePath) && is_file($filePath)){
            unlink($filePath);
        }
    }

    /**
     * @return array
     */
    public function getImageSize()
    {
        //get image size
        $size = @getimagesize($this->getAbsolutePath().$this->getFileName());

        //get image width
        $width = $size[0];

        //get image height
        $height = $size[1];

        return array('width' => $width, 'height' => $height);
    }

}