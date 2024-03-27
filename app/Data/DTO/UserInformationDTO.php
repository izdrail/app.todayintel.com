<?php
declare(strict_types=1);
namespace App\Data\DTO;



use Spatie\LaravelData\Data;

/**
 * @method static self fromArray(array $data)
 * @method static self fromJson(string $json)
 * @method static self fromString(string $string)
 * @method static self fromObject(object $object)
 */
class UserInformationDTO extends Data
{

    public ?string $id;

    public ?string $name;

    public ?string $username;

    public ?string $avatar;

    public ?string $provider;

    public ?string $provider_id;

    public ?array $data;

    public ?string $access_token;

}
