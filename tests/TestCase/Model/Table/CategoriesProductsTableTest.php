<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategoriesProductsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategoriesProductsTable Test Case
 */
class CategoriesProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CategoriesProductsTable
     */
    protected $CategoriesProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CategoriesProducts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CategoriesProducts') ? [] : ['className' => CategoriesProductsTable::class];
        $this->CategoriesProducts = $this->getTableLocator()->get('CategoriesProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CategoriesProducts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CategoriesProductsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
