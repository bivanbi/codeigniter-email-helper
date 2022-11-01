<?php

namespace KignOrg\CodeIgniterEmailHelper;

use KignOrg\CodeIgniterEmailHelper\Exceptions\EmailPreparationException;
use KignOrg\CodeIgniterEmailHelper\Exceptions\EmailSendException;

interface EmailHelper
{
    /**
     * @param EmailData $emailData
     * @return EmailHelper
     * @throws EmailPreparationException
     */
    public function initialize(EmailData $emailData): EmailHelper;

    /**
     * @param bool $autoClear
     * @return EmailHelper
     * @throws EmailPreparationException
     * @throws EmailSendException
     */
    public function send(bool $autoClear = true): EmailHelper;

    /**
     * @param bool $clearAttachments
     * @return $this
     * @throws EmailPreparationException
     */
    public function clear(bool $clearAttachments = false): EmailHelper;

    /**
     * @param array $includeParts List of raw data chunks to include in the output
     *                       Valid options are: 'headers', 'subject', 'body'
     *
     * @return string
     */
    public function getDebugOutput(array $includeParts = ['headers', 'subject', 'body']): string;
}