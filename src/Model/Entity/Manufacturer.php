<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Manufacturer Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $country
 * @property string $email
 * @property string $phone
 * @property string|null $products_type
 * @property string|null $primary_contact_name
 *
 * @property \App\Model\Entity\Packaging[] $packagings
 * @property \App\Model\Entity\Product[] $products
 */
class Manufacturer extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'country' => true,
        'email' => true,
        'phone' => true,
        'products_type' => true,
        'primary_contact_name' => true,
        'packagings' => true,
        'products' => true,
    ];
}
