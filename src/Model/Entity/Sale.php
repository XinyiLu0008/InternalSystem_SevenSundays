<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sale Entity
 *
 * @property int $id
 * @property string $price
 * @property int|null $quantity
 * @property string $status
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $sales_date
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Inventory[] $inventories
 */
class Sale extends Entity
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
        'price' => true,
        'quantity' => true,
        'status' => true,
        'user_id' => true,
        'sales_date' => true,
        'product_name' => true,
        'product_price' => true,
        'product_id' => true,
        'user' => true,
        'inventories' => true,
    ];
}


