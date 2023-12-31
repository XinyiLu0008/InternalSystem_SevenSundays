<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PackagingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PackagingsTable Test Case
 */
class PackagingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PackagingsTable
     */
    protected $Packagings;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Packagings',
        'app.Manufacturers',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Packagings') ? [] : ['className' => PackagingsTable::class];
        $this->Packagings = $this->getTableLocator()->get('Packagings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Packagings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PackagingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PackagingsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
