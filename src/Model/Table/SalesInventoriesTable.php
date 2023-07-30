<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SalesInventories Model
 *
 * @property \App\Model\Table\SalesTable&\Cake\ORM\Association\BelongsTo $Sales
 * @property \App\Model\Table\InventoriesTable&\Cake\ORM\Association\BelongsTo $Inventories
 *
 * @method \App\Model\Entity\SalesInventory newEmptyEntity()
 * @method \App\Model\Entity\SalesInventory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SalesInventory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SalesInventory get($primaryKey, $options = [])
 * @method \App\Model\Entity\SalesInventory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SalesInventory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SalesInventory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SalesInventory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SalesInventory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SalesInventory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SalesInventory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SalesInventory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SalesInventory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SalesInventoriesTable extends Table
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

        $this->setTable('sales_inventories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sales', [
            'foreignKey' => 'sale_id',
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
        $rules->add($rules->existsIn(['sale_id'], 'Sales'), ['errorField' => 'sale_id']);
        $rules->add($rules->existsIn(['inventory_id'], 'Inventories'), ['errorField' => 'inventory_id']);

        return $rules;
    }
}
