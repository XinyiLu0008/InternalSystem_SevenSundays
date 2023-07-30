<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shopifysale Entity
 *
 * @property int $id
 * @property string $Name
 * @property string $Email
 * @property string $Financial Status
 * @property \Cake\I18n\FrozenTime $Paid at
 * @property int $Subtotal
 * @property int $Shipping
 * @property int $Taxes
 * @property int $Total
 * @property string $LineItem_name
 * @property int $LineItem_quantity
 * @property int $LineItem_price
 */
class Shopifysale extends Entity
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
        'Name' => true,
        'Email' => true,
        'Financial_Status' => true,
        'Paid_at' => true,
        'Subtotal' => true,
        'Shipping' => true,
        'Taxes' => true,
        'Total' => true,
        'LineItem_name' => true,
        'LineItem_quantity' => true,
        'LineItem_price' => true,
        'is_ship' => true,
    ];
}
