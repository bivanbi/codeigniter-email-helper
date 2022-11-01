<?php

namespace KignOrg\CodeIgniterEmailHelper;


use KignOrg\CodeIgniterEmailHelper\Exceptions\EmailPreparationException;
use KignOrg\CodeIgniterEmailHelper\Exceptions\EmailSendException;

class EmailHelperImpl implements EmailHelper
{
    const DEBUG_OUTPUT_DEFAULT_INCLUDE = [
        Constants::EMAIL_DEBUG_OUTPUT_HEADERS,
        Constants::EMAIL_DEBUG_OUTPUT_SUBJECT,
        Constants::EMAIL_DEBUG_OUTPUT_BODY
    ];

    private ?EmailData $emailData;
    private ?CodeIgniterEmailAdapter $emailAdapter;

    /**
     * @param EmailData $emailData
     * @return $this
     * @throws EmailPreparationException
     */
    public function initialize(EmailData $emailData): EmailHelper
    {
        $this->emailData = $emailData;
        $this->emailAdapter = CodeIgniterEmailAdapter::getSharedInstance();
        $this->emailAdapter->clear(true);
        $this->emailAdapter->initialize($emailData->getConfig());
        $this->prepare();
        return $this;
    }

    /**
     * @return void
     * @throws EmailPreparationException
     */
    private function prepare(): void
    {
        $this->prepareHeaders();
        $this->prepareBody();
        $this->prepareAttachments();
    }

    /**
     * @throws EmailPreparationException
     */
    private function prepareHeaders()
    {
        $sender = $this->emailData->getSender();
        $returnPath = $this->emailData->getReturnPath();
        $replyTo = $this->emailData->getReplyTo();

        $this->emailAdapter->setFromAndReturnPath($sender, $returnPath);
        $this->emailAdapter->setReplyToContact($replyTo);
        $this->emailAdapter->setRecipient($this->emailData->getRecipient());
        $this->emailAdapter->setSubject($this->emailData->getSubject());
    }


    /**
     * @throws EmailPreparationException
     */
    private function prepareBody(): void
    {
        $html = $this->prepareInlineAttachments();
        $text = $this->emailData->getTextBody();

        if ($html) {
            $this->emailAdapter->setMailType('html');
            $this->emailAdapter->setMessage($html);
            $this->emailAdapter->setAltMessage($text);
        } else {
            $this->emailAdapter->setMessage($text);
        }
    }


    /**
     * @throws EmailPreparationException
     */
    private function prepareAttachments()
    {
        foreach ($this->emailData->getAttachment() as $item) {
            /** @var Attachment $item */
            $this->emailAdapter->attach($item->getFilePath(), $item->getContentDisposition(), $item->getAttachedFileName(), $item->getMimeType());
        }
    }

    /**
     * @return string|null html body with inline attachments replaced
     * @throws EmailPreparationException
     */
    private function prepareInlineAttachments(): ?string
    {
        $inlineAttachment = new HtmlInlineAttachment($this->emailAdapter);
        return $inlineAttachment->parseHtmlAndAttachFiles($this->emailData->getHtmlBody());
    }

    /**
     * @param bool $autoClear
     * @return $this
     * @throws EmailPreparationException
     * @throws EmailSendException
     */
    public function send(bool $autoClear = true): EmailHelper
    {
        $this->exceptIfNotInitialized();
        $this->emailAdapter->send($autoClear);
        return $this;
    }

    /**
     * @param array $includeParts List of raw data chunks to include in the output
     *                       Valid options are: 'headers', 'subject', 'body'
     *
     * @return string
     */
    public function getDebugOutput(array $includeParts = self::DEBUG_OUTPUT_DEFAULT_INCLUDE): string
    {
        return $this->emailAdapter->printDebugger($includeParts);
    }

    /**
     * @param bool $clearAttachments
     * @return $this
     * @throws EmailPreparationException
     */
    public function clear(bool $clearAttachments = false): EmailHelper
    {
        $this->exceptIfNotInitialized();
        $this->emailAdapter->clear($clearAttachments);
        return $this;
    }

    /**
     * @throws EmailPreparationException
     */
    private function exceptIfNotInitialized()
    {
        if (null === $this->emailAdapter || null === $this->emailData) {
            throw new EmailPreparationException("CodeIgniterEmailHelper is not initialized. Call initialize() first.");
        }
    }
}
