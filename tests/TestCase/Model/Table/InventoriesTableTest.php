<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InventoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InventoriesTable Test Case
 */
class InventoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InventoriesTable
     */
    protected $Inventories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Inventories',
        'app.Products',
        'app.Sales',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Inventories') ? [] : ['className' => InventoriesTable::class];
        $this->Inventories = $this->getTableLocator()->get('Inventories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Inventories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\InventoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\InventoriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
