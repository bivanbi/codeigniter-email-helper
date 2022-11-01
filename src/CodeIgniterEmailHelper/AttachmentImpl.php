<?php


namespace KignOrg\CodeIgniterEmailHelper;


class AttachmentImpl implements Attachment
{
    private string $filePath;
    private ?string $mimeType;
    private ?string $contentDisposition;
    private ?string $attachedFileName;

    public function __construct(string $filePath, string $contentDisposition = null, string $attachedFileName = null, string $mimeType = null)
    {
        $this->filePath = $filePath;
        $this->contentDisposition = $contentDisposition;
        $this->attachedFileName = $attachedFileName;
        $this->mimeType = $mimeType;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function getContentDisposition(): ?string
    {
        return $this->contentDisposition;
    }

    public function getAttachedFileName(): ?string
    {
        return $this->attachedFileName;
    }

}
