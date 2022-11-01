<?php


namespace KignOrg\CodeIgniterEmailHelper;


interface Contact
{
    public function __construct(string $emailAddress, string $name = null);
    public function getName(): ?string;
    public function getEmailAddress(): ?string;
}