<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SalesProductsFixture
 */
class SalesProductsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'packaging_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sales_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'price' => ['type' => 'decimal', 'length' => 12, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'quantity' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'inventory_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_sales_sales_products' => ['type' => 'index', 'columns' => ['sales_id'], 'length' => []],
            'FK_inventories_sales_products' => ['type' => 'index', 'columns' => ['inventory_id'], 'length' => []],
            'FK_packagings_sales_products' => ['type' => 'index', 'columns' => ['packaging_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_sales_sales_products' => ['type' => 'foreign', 'columns' => ['sales_id'], 'references' => ['sales', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_packagings_sales_products' => ['type' => 'foreign', 'columns' => ['packaging_id'], 'references' => ['packagings', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_inventories_sales_products' => ['type' => 'foreign', 'columns' => ['inventory_id'], 'references' => ['inventories', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'packaging_id' => 1,
                'sales_id' => 1,
                'price' => 1.5,
                'quantity' => 1,
                'inventory_id' => 1,
            ],
        ];
        parent::init();
    }
}
