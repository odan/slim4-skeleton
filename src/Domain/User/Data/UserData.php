<?php

namespace App\Domain\User\Data;

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
        $this->id = !empty($data['id']) ? (int)$data['id'] : null;
        $this->username = !empty($data['username']) ? (string)$data['username'] : null;
        $this->firstName = !empty($data['first_name']) ? (string)$data['first_name'] : null;
        $this->lastName = !empty($data['last_name']) ? (string)$data['last_name'] : null;
        $this->password = !empty($data['password']) ? (string)$data['password'] : null;
        $this->email = !empty($data['email']) ? (string)$data['email'] : null;
        $this->userRoleId = !empty($data['user_role_id']) ? (int)$data['user_role_id'] : null;
        $this->locale = !empty($data['locale']) ? (string)$data['locale'] : null;
        $this->enabled = !empty($data['enabled']) ? (bool)$data['enabled'] : null;
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
