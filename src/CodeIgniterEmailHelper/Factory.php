<?php


namespace KignOrg\CodeIgniterEmailHelper;


interface Factory
{
    public function contact(string $emailAddress, string $name = null): Contact;
    public function attachment(string $filePath, string $disposition = null, string $attachedFileName = null, string $mimeType = null): Attachment;
    public function emailData(): EmailData;
    public function emailHelper(): EmailHelper;
}