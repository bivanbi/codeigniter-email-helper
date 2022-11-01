<?php


namespace KignOrg\CodeIgniterEmailHelper\Exceptions;

use Exception;

class EmailPreparationException extends Exception
{
    public array $emailAddresses;

    public function __construct(string $message = "", array $emailAddresses = [])
    {
        parent::__construct($message);
        $this->emailAddresses = $emailAddresses;
    }
}
