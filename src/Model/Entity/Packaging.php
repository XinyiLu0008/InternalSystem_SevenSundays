<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Packaging Entity
 *
 * @property int $id
 * @property string $title
 * @property string $price
 * @property string $weight
 * @property string $length
 * @property string $width
 * @property string $height
 * @property string $type
 * @property string $sku
 * @property int|null $total_quantity
 * @property string|null $image
 * @property int|null $rop
 * @property int $manufacturer_id
 *
 * @property \App\Model\Entity\Manufacturer $manufacturer
 * @property \App\Model\Entity\Product[] $products
 */
class Packaging extends Entity
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
        'id' => true,
        'title' => true,
        'price' => true,
        'weight' => true,
        'length' => true,
        'width' => true,
        'height' => true,
        'type' => true,
        'sku' => true,
        'total_quantity' => true,
        'image' => true,
        'rop' => true,
        'manufacturer_id' => true,
        'manufacturer' => true,
        'products' => true,
    ];
}
