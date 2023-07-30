<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Manufacturers Model
 *
 * @property \App\Model\Table\PackagingsTable&\Cake\ORM\Association\HasMany $Packagings
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\HasMany $Products
 *
 * @method \App\Model\Entity\Manufacturer newEmptyEntity()
 * @method \App\Model\Entity\Manufacturer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Manufacturer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Manufacturer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Manufacturer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Manufacturer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Manufacturer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Manufacturer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Manufacturer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Manufacturer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Manufacturer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Manufacturer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Manufacturer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ManufacturersTable extends Table
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

        $this->setTable('manufacturers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Packagings', [
            'foreignKey' => 'manufacturer_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('Products', [
            'foreignKey' => 'manufacturer_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('country')
            ->maxLength('country', 50)
            ->allowEmptyString('country');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->add('phone', 'valid', ['rule' => 'numeric', 'message' => 'Phone number must be numeric'])
            ->maxLength('phone', 15)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');

        $validator
            ->scalar('products_type')
            ->maxLength('products_type', 50)
            ->allowEmptyString('products_type');

        $validator
            ->scalar('primary_contact_name')
            ->maxLength('primary_contact_name', 100)
            ->allowEmptyString('primary_contact_name');

        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }
}
