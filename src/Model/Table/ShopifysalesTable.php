<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Shopifysales Model
 *
 * @method \App\Model\Entity\Shopifysale newEmptyEntity()
 * @method \App\Model\Entity\Shopifysale newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Shopifysale[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Shopifysale get($primaryKey, $options = [])
 * @method \App\Model\Entity\Shopifysale findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Shopifysale patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Shopifysale[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Shopifysale|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shopifysale saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shopifysale[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Shopifysale[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Shopifysale[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Shopifysale[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ShopifysalesTable extends Table
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

        $this->setTable('shopifysales');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
         ->scalar('Name')
           ->maxLength('Name', 255)
           ->requirePresence('Name', 'create')
            ->notEmptyString('Name');

        $validator
            ->scalar('Email')
            ->maxLength('Email', 255)
            ->requirePresence('Email', 'create')
            ->notEmptyString('Email');

        $validator
            ->scalar('Financial_Status')
            ->maxLength('Financial_Status', 10)
            ->allowEmptyString('Financial_Status');;

        $validator
        ->dateTime('Paid_at')
            ->allowEmptyDateTime('Paid_at');

        $validator
            ->integer('Subtotal')
            ->allowEmptyString('Subtotal');

        $validator
            ->integer('Shipping')
            ->allowEmptyString('Subtotal');

        $validator
            ->integer('Taxes')
            ->allowEmptyString('Subtotal');

        $validator
            ->integer('Total')
            ->allowEmptyString('Subtotal');

        $validator
            ->scalar('LineItem_name')
            ->maxLength('LineItem_name', 255)
            ->requirePresence('LineItem_name', 'create')
            ->notEmptyString('LineItem_name');

        $validator
            ->integer('LineItem_quantity')
            ->requirePresence('LineItem_quantity', 'create')
            ->notEmptyString('LineItem_quantity');

        $validator
            ->integer('LineItem_price')
            ->requirePresence('LineItem_price', 'create')
            ->notEmptyString('LineItem_price');
        $validator
            ->integer('is_ship');

        return $validator;
    }
}
