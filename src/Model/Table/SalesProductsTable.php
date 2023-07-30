<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SalesProducts Model
 *
 * @property \App\Model\Table\PackagingsTable&\Cake\ORM\Association\BelongsTo $Packagings
 * @property \App\Model\Table\SalesTable&\Cake\ORM\Association\BelongsTo $Sales
 * @property \App\Model\Table\InventoriesTable&\Cake\ORM\Association\BelongsTo $Inventories
 *
 * @method \App\Model\Entity\SalesProduct newEmptyEntity()
 * @method \App\Model\Entity\SalesProduct newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SalesProduct[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SalesProduct get($primaryKey, $options = [])
 * @method \App\Model\Entity\SalesProduct findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SalesProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SalesProduct[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SalesProduct|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SalesProduct saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SalesProduct[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SalesProduct[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SalesProduct[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SalesProduct[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SalesProductsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sales_products');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Packagings', [
            'foreignKey' => 'packaging_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Sales', [
            'foreignKey' => 'sales_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Inventories', [
            'foreignKey' => 'inventory_id',
            'joinType' => 'INNER',
        ]);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['packaging_id'], 'Packagings'), ['errorField' => 'packaging_id']);
        $rules->add($rules->existsIn(['sales_id'], 'Sales'), ['errorField' => 'sales_id']);
        $rules->add($rules->existsIn(['inventory_id'], 'Inventories'), ['errorField' => 'inventory_id']);

        return $rules;
    }
}
