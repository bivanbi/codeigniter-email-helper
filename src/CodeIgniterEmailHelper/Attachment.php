<?php


namespace KignOrg\CodeIgniterEmailHelper;


interface Attachment
{
    public function __construct(string $filePath, string $disposition = null, string $attachedFileName = null, string $mimeType = null);
    public function getFilePath(): ?string;
    public function getContentDisposition(): ?string;
    public function getAttachedFileName(): ?string;
    public function getMimeType(): ?string;
}