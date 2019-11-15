<?php

namespace App\Domain\User\Data;

use App\Interfaces\DataInterface;
use Selective\ArrayReader\ArrayReader;

/**
 * Data object.
 */
final class UserCreatorData implements DataInterface
{
    /** @var int|null */
    public $id;

    /** @var string|null */
    public $username;

    /** @var string|null */
    public $password;

    /** @var string|null */
    public $email;

    /** @var string|null */
    public $firstName;

    /** @var string|null */
    public $lastName;

    /** @var string|null */
    public $role;

    /** @var string|null */
    public $locale;

    /** @var bool */
    public $enabled = false;

    /**
     * The constructor.
     *
     * @param array $array The array with data
     */
    public function __construct(array $array = [])
    {
        $data = new ArrayReader($array);

        $this->id = $data->findInt('id');
        $this->username = $data->findString('username');
        $this->firstName = $data->findString('first_name');
        $this->lastName = $data->findString('last_name');
        $this->email = $data->findString('email');
        $this->locale = $data->findString('locale');
        $this->role = $data->findString('role');
        $this->enabled = $data->getBool('enabled', false);
    }
}
