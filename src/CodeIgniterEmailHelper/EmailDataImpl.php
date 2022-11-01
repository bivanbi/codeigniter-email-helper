<?php


namespace KignOrg\CodeIgniterEmailHelper;

use Config\Email;

class EmailDataImpl implements EmailData
{
    private Email|array|null $config = null;

    /** @var Contact */
    private Contact $sender;
    private ?Contact $returnPath;
    private ?Contact $replyTo;

    private array $recipient = [];
    private array $carbonCopyRecipient = [];
    private array $blindCarbonCopyRecipient = [];

    private string $subject = '';

    private string $htmlBody = '';
    private string $textBody = '';

    private array $attachment = [];

    /**
     * @return null|array|Email
     */
    public function getConfig(): array|Email|null
    {
        return $this->config;
    }

    /**
     * @param null|array|Email $config
     * @return $this
     */
    public function setConfig($config = null): EmailData
    {
        $this->config = $config;
        return $this;
    }


    public function getSender(): ?Contact
    {
        return $this->sender;
    }

    public function setSender(Contact $sender): EmailData
    {
        $this->sender = $sender;
        return $this;
    }


    public function getReturnPath(): ?Contact
    {
        return $this->returnPath;
    }

    public function setReturnPath(?Contact $returnPath): EmailData
    {
        $this->returnPath = $returnPath;
        return $this;
    }


    public function getReplyTo(): ?Contact
    {
        return $this->replyTo;
    }

    public function setReplyTo(Contact $replyTo): EmailData
    {
        $this->replyTo = $replyTo;
        return $this;
    }


    public function resetRecipient(): EmailData
    {
        $this->recipient = [];
        return $this;
    }

    public function setRecipient(array $recipient): EmailData
    {
        $this->recipient = $recipient;
        return $this;
    }

    public function getRecipient(): array
    {
        return $this->recipient;
    }

    public function addRecipient(Contact $recipient): EmailData
    {
        $this->recipient[] = $recipient;
        return $this;
    }


    public function resetCc(): EmailData
    {
        $this->carbonCopyRecipient = [];
        return $this;
    }

    public function setCc(array $recipient): EmailData
    {
        $this->carbonCopyRecipient = $recipient;
        return $this;
    }

    public function getCc(): array
    {
        return $this->carbonCopyRecipient;
    }

    public function addCc(Contact $recipient): EmailData
    {
        $this->carbonCopyRecipient[] = $recipient;
        return $this;
    }


    public function resetBcc(): EmailData
    {
        $this->blindCarbonCopyRecipient = [];
        return $this;
    }

    public function setBcc(array $recipient): EmailData
    {
        $this->blindCarbonCopyRecipient = $recipient;
        return $this;
    }

    public function getBcc(): array
    {
        return $this->blindCarbonCopyRecipient;
    }

    public function addBcc(Contact $recipient): EmailData
    {
        $this->blindCarbonCopyRecipient[] = $recipient;
        return $this;
    }


    public function resetAttachment(): EmailData
    {
        $this->attachment = [];
        return $this;
    }

    public function setAttachment(array $attachment): EmailData
    {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttachment(): array
    {
        return $this->attachment;
    }

    public function addAttachment(Attachment $attachment): EmailData
    {
        $this->attachment[] = $attachment;
        return $this;
    }


    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): EmailData
    {
        $this->subject = $subject;
        return $this;
    }

    public function getHtmlBody(): ?string
    {
        return $this->htmlBody;
    }

    public function setHtmlBody(string $htmlBody): EmailData
    {
        $this->htmlBody = $htmlBody;
        return $this;
    }

    public function getTextBody(): string
    {
        return $this->textBody;
    }

    public function setTextBody(string $textBody): EmailData
    {
        $this->textBody = $textBody;
        return $this;
    }

}
