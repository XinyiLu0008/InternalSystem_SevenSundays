<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Inventory Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $received_date
 * @property int $quantity
 * @property \Cake\I18n\FrozenDate|null $expiry_date
 * @property int $lifetime
 * @property int $product_id
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Sale[] $sales
 */
class Inventory extends Entity
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
        'received_date' => true,
        'quantity' => true,
        'expiry_date' => true,
        'lifetime' => true,
        'checkbox' => true,
        'product_id' => true,
        'product' => true,
        'sales' => true,
    ];
}
