<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SalesInventoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SalesInventoriesTable Test Case
 */
class SalesInventoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SalesInventoriesTable
     */
    protected $SalesInventories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SalesInventories',
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
        $config = $this->getTableLocator()->exists('SalesInventories') ? [] : ['className' => SalesInventoriesTable::class];
        $this->SalesInventories = $this->getTableLocator()->get('SalesInventories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SalesInventories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SalesInventoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SalesInventoriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
