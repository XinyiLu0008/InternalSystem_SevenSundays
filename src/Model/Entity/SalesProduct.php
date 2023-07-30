<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SalesProduct Entity
 *
 * @property int $id
 * @property int $packaging_id
 * @property int $sales_id
 * @property string $price
 * @property int $quantity
 * @property int $inventory_id
 *
 * @property \App\Model\Entity\Packaging $packaging
 * @property \App\Model\Entity\Sale $sale
 * @property \App\Model\Entity\Inventory $inventory
 */
class SalesProduct extends Entity
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
        'packaging_id' => true,
        'sales_id' => true,
        'price' => true,
        'quantity' => true,
        'inventory_id' => true,
        'packaging' => true,
        'sale' => true,
        'inventory' => true,
    ];
}
