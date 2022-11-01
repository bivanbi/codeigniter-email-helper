<?php


namespace KignOrg\CodeIgniterEmailHelper;

interface EmailData
{
    public function getConfig();
    public function setConfig($config = null): EmailData;
    public function getSender(): ?Contact;
    public function setSender(Contact $sender): EmailData;
    public function getReturnPath(): ?Contact;
    public function setReturnPath(?Contact $returnPath): EmailData;
    public function getReplyTo(): ?Contact;
    public function setReplyTo(Contact $replyTo): EmailData;
    public function resetRecipient(): EmailData;
    public function setRecipient(array $recipient): EmailData;
    public function getRecipient(): array;
    public function addRecipient(Contact $recipient): EmailData;
    public function resetCc(): EmailData;
    public function setCc(array $recipient): EmailData;
    public function getCc(): array;
    public function addCc(Contact $recipient): EmailData;
    public function resetBcc(): EmailData;
    public function setBcc(array $recipient): EmailData;
    public function getBcc(): array;
    public function addBcc(Contact $recipient): EmailData;
    public function resetAttachment(): EmailData;
    public function setAttachment(array $attachment): EmailData;
    public function getAttachment(): array;
    public function addAttachment(Attachment $attachment): EmailData;
    public function getSubject(): string;
    public function setSubject(string $subject): EmailData;
    public function getHtmlBody(): ?string;
    public function setHtmlBody(string $htmlBody): EmailData;
    public function getTextBody(): string;
    public function setTextBody(string $textBody): EmailData;
}