<?php


namespace KignOrg\CodeIgniterEmailHelper;

use CodeIgniter\Email\Email;
use KignOrg\CodeIgniterEmailHelper\Exceptions\EmailPreparationException;
use KignOrg\CodeIgniterEmailHelper\Exceptions\EmailSendException;

class CodeIgniterEmailAdapter extends Email
{
    private static ?CodeIgniterEmailAdapter $instance = null;
    private array $filePathToCid;

    private function __construct($config = null)
    {
        parent::__construct($config);
    }

    public static function getInstance($config = null): CodeIgniterEmailAdapter
    {
        return new CodeIgniterEmailAdapter($config);
    }

    public static function getSharedInstance($config = null): CodeIgniterEmailAdapter
    {
        if (null === static::$instance) {
            static::$instance = new CodeIgniterEmailAdapter($config);
        }
        return static::$instance;
    }

    public function initialize($config = null): CodeIgniterEmailAdapter
    {
        $this->clear(true);
        $this->filePathToCid = [];
        parent::initialize($config);
        return $this;
    }

    public function setFromAndReturnPath(Contact $from, ?Contact $returnPath): CodeIgniterEmailAdapter
    {
        $returnPath = ($returnPath) ? $returnPath->getEmailAddress() : null;
        $this->setFrom($from->getEmailAddress(), $from->getName(), $returnPath);
        return $this;
    }

    /**
     * @param array $recipient
     * @return CodeIgniterEmailAdapter
     * @throws EmailPreparationException
     */
    public function setRecipient(array $recipient): CodeIgniterEmailAdapter
    {
        $encodedEmail = $this->getEncodedEmailArrayFromContacts($recipient);
        $this->setToHeaderIfNeeded($encodedEmail);
        $this->recipients = $encodedEmail;
        return $this;
    }

    public function setReplyToContact(Contact $replyTo): CodeIgniterEmailAdapter
    {
        $this->setReplyTo($replyTo->getEmailAddress(), $replyTo->getName());
        return $this;
    }

    /**
     * @param array $contacts
     * @return array
     * @throws EmailPreparationException
     */
    public function getEncodedEmailArrayFromContacts(array $contacts): array
    {
        $encoded = [];
        foreach ($contacts as $item) {
            $encoded[] = $this->encodeEmail($item);
        }
        return $encoded;
    }

    /**
     * @param Contact $emailContact
     * @return string
     * @throws EmailPreparationException
     */
    public function encodeEmail(Contact $emailContact): string
    {
        $emailAddress = $this->stringToArray($emailContact->getEmailAddress());
        $emailAddress = $this->cleanEmail($emailAddress);
        $this->exceptOnInvalidEmailAddress($emailAddress);
        $name = $this->prepQEncoding($emailContact->getName());
        return $name . ' <' . $emailAddress[0] . '>';
    }

    /**
     * @param array $emailAddress
     * @throws EmailPreparationException
     */
    private function exceptOnInvalidEmailAddress(array $emailAddress)
    {
        if (true !== $this->validateEmail($emailAddress)) {
            throw new EmailPreparationException("Invalid email address",$emailAddress);
        }
    }

    private function setToHeaderIfNeeded(array $recipientEmailAddress): void
    {
        if ($this->getProtocol() !== 'mail') {
            $this->setHeader('To', implode(', ', $recipientEmailAddress));
        }
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }


    public function getProtocol(): string
    {
        return parent::getProtocol();
    }

    /**
     * @param string $filePath
     * @return string
     * @throws EmailPreparationException
     */
    public function attachInlineFile(string $filePath): string
    {
        if (!isset($this->filePathToCid[$filePath])) {
            $this->attach($filePath, 'inline');
            $this->filePathToCid[$filePath] = $this->setAttachmentCID($filePath);
        }
        return $this->filePathToCid[$filePath];
    }


    /**
     * @param string $file
     * @param string $disposition
     * @param string $newName
     * @param string $mime
     * @return CodeIgniterEmailAdapter
     * @throws EmailPreparationException
     * @noinspection PhpParameterNameChangedDuringInheritanceInspection
     */
    public function attach($file, $disposition = '', $newName = null, $mime = ''): CodeIgniterEmailAdapter
    {
        $result = parent::attach($file, $disposition, $newName, $mime);
        if (false === $result) {
            throw new EmailPreparationException("$file does not exist or unreadable");
        }
        return $this;
    }

    public function getConfig(): array
    {
        return get_class_vars(get_class($this));
    }

    /**
     * @param bool $autoClear
     * @return CodeIgniterEmailAdapter
     * @throws EmailSendException
     */
    public function send($autoClear = true): CodeIgniterEmailAdapter
    {
        $result = parent::send($autoClear);
        if (true !== $result) {
            throw new EmailSendException("Failed to send email");
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function clear($clearAttachments = false): CodeIgniterEmailAdapter
    {
        if ($clearAttachments) {
            $this->filePathToCid = [];
        }
        parent::clear($clearAttachments);
        return $this;
    }

    public function getVars(): array
    {
        return get_object_vars($this);
    }

    public function encodeStringForHeader(string $string): string
    {
        return $this->prepQEncoding($string);
    }
}
