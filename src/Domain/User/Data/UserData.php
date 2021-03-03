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
     * @param array|false $items The items
     *
     * @return UserData[] The list of users
     */
    public static function toList($items): array
    {
        $users = [];

        foreach ((array)$items as $data) {
            $users[] = new UserData($data);
        }

        return $users;
    }

    /**
     * Convert to array.
     *
     * @return array The data
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'user_role_id' => $this->userRoleId,
            'locale' => $this->locale,
            'enabled' => $this->enabled,
        ];
    }
}
