<?php


namespace KignOrg\CodeIgniterEmailHelper;


class FactoryImpl implements Factory
{
    public function contact(string $emailAddress, string $name = null): Contact
    {
        return new ContactImpl($emailAddress, $name);
    }

    public function emailData(): EmailData
    {
        return new EmailDataImpl();
    }

    public function emailHelper(): EmailHelper
    {
        return new EmailHelperImpl();
    }

    public function constants(): Constants
    {
        return new Constants();
    }

    /** @noinspection PhpParameterNameChangedDuringInheritanceInspection */
    public function attachment(string $filePath, string $contentDisposition = null, string $attachedFileName = null, string $mimeType = null): Attachment
    {
        return new AttachmentImpl($filePath, $contentDisposition, $attachedFileName, $mimeType);
    }
}
