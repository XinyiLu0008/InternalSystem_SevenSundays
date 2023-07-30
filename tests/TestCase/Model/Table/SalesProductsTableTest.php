<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SalesProductsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SalesProductsTable Test Case
 */
class SalesProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SalesProductsTable
     */
    protected $SalesProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SalesProducts',
        'app.Packagings',
        'app.Sales',
        'app.Inventories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SalesProducts') ? [] : ['className' => SalesProductsTable::class];
        $this->SalesProducts = $this->getTableLocator()->get('SalesProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SalesProducts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SalesProductsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SalesProductsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
