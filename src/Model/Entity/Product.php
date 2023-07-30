<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $title
 * @property string $price
 * @property string $weight
 * @property string|null $capacity
 * @property string $length
 * @property string $width
 * @property string $height
 * @property \Cake\I18n\FrozenDate $order_time
 * @property int|null $shelf_life
 * @property string $sku
 * @property string|null $image
 * @property string|null $availability
 * @property int|null $rop
 * @property int|null $total_quantity
 * @property int $packaging_id
 * @property int $manufacturer_id
 * @property int $categories_products_id
 *
 * @property \App\Model\Entity\Packaging $packaging
 * @property \App\Model\Entity\Manufacturer $manufacturer
 * @property \App\Model\Entity\CategoriesProduct $categories_product
 * @property \App\Model\Entity\Inventory[] $inventories
 */
class Product extends Entity
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
        'title' => true,
        'price' => true,
        'weight' => true,
        'capacity' => true,
        'length' => true,
        'width' => true,
        'height' => true,
        'order_time' => true,
        'shelf_life' => true,
        'sku' => true,
        'image' => true,
        'availability' => true,
        'rop' => true,
        'total_quantity' => true,
        'packaging_id' => true,
        'manufacturer_id' => true,
        'categories_products_id' => true,
        'packaging' => true,
        'manufacturer' => true,
        'categories_product' => true,
        'inventories' => true
    ];
}
