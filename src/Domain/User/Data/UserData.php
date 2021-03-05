<?php

namespace App\Domain\User\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class UserData
{
    public ?int $id = null;

    public ?string $username;

    public ?string $password;

    public ?string $email;

    public ?string $firstName;

    public ?string $lastName;

    public ?int $userRoleId;

    public ?string $locale;

    public ?bool $enabled;

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

    /**
     * Convert to array.
     *
     * @param array $items The items
     *
     * @return UserData[] The list of users
     */
    public static function toList(array $items): array
    {
        $users = [];

        foreach ($items as $data) {
            $users[] = new UserData($data);
        }

        return $users;
    }
}
