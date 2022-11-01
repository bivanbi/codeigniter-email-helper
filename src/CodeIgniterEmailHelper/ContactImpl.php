<?php


namespace KignOrg\CodeIgniterEmailHelper;


class ContactImpl implements Contact
{
    private ?string $name;
    private string $emailAddress;

    public function __construct(string $emailAddress, string $name = null)
    {
        $this->emailAddress = $emailAddress;
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

}
