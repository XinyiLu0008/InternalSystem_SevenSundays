<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Packagings Model
 *
 * @property \App\Model\Table\ManufacturersTable&\Cake\ORM\Association\BelongsTo $Manufacturers
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\HasMany $Products
 *
 * @method \App\Model\Entity\Packaging newEmptyEntity()
 * @method \App\Model\Entity\Packaging newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Packaging[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Packaging get($primaryKey, $options = [])
 * @method \App\Model\Entity\Packaging findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Packaging patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Packaging[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Packaging|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Packaging saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Packaging[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Packaging[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Packaging[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Packaging[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PackagingsTable extends Table
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

        $this->setTable('packagings');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Manufacturers', [
            'foreignKey' => 'manufacturer_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('Products', [
            'foreignKey' => 'packaging_id',
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
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

        $validator
            ->decimal('weight')
            ->requirePresence('weight', 'create')
            ->notEmptyString('weight');

        $validator
            ->decimal('length')
            ->requirePresence('length', 'create')
            ->notEmptyString('length');

        $validator
            ->decimal('width')
            ->requirePresence('width', 'create')
            ->notEmptyString('width');

        $validator
            ->decimal('height')
            ->requirePresence('height', 'create')
            ->notEmptyString('height');

        $validator
            ->scalar('type')
            ->maxLength('type', 10)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('sku')
            ->maxLength('sku', 10)
            ->requirePresence('sku', 'create')
            ->notEmptyString('sku');

        $validator
            ->integer('total_quantity')
            ->allowEmptyString('total_quantity');

        $validator
            ->allowEmptyFile('image_file')
            ->add( 'image_file', [
                'mimeType' => [
                    'rule' =>
                        [ 'mimeType', [ 'image/jpg', 'image/png', 'image/jpeg' ] ],
                    'message' =>
                        'Please upload only jpg and png.',
                ],
                'fileSize' => [
                    'rule' => [ 'fileSize', '<=', '10MB' ],
                    'message' => 'The size of image file  must be less than 10MB.',

                ],
            ] );

        $validator
            ->integer('rop')
            ->allowEmptyString('rop');

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
        $rules->add($rules->existsIn(['manufacturer_id'], 'Manufacturers'), ['errorField' => 'manufacturer_id']);
        $rules->add($rules->isUnique(['title']), ['errorField' => 'title',  'message' => 'There is already a Packaging with this name, please enter a different name.']);
        $rules->add($rules->isUnique(['sku']), ['errorField' => 'sku',  'message' => 'There is already a Packaging with this SKU, please enter a different SKU.']);
        return $rules;
    }
}
