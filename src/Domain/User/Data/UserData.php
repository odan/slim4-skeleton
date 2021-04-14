<?php

namespace App\Domain\User\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class UserData
{
    public ?int $id = null;

    public ?string $username = null;

    public ?string $password = null;

    public ?string $email = null;

    public ?string $firstName = null;

    public ?string $lastName = null;

    public ?int $userRoleId = null;

    public ?string $locale = null;

    public ?bool $enabled = false;

    /**
     * The constructor.
     *
     * @param array $data The data
     */
    public function __construct(array $data = [])
    {
        $reader = new ArrayReader($data);

        $this->id = $reader->findInt('id');
        $this->username = $reader->findString('username');
        $this->firstName = $reader->findString('first_name');
        $this->lastName = $reader->findString('last_name');
        $this->password = $reader->findString('password');
        $this->email = $reader->findString('email');
        $this->userRoleId = $reader->findInt('user_role_id');
        $this->locale = $reader->findString('locale');
        $this->enabled = $reader->findBool('enabled');
    }
}
