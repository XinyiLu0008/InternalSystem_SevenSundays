<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \App\Model\Table\PackagingsTable&\Cake\ORM\Association\BelongsTo $Packagings
 * @property \App\Model\Table\ManufacturersTable&\Cake\ORM\Association\BelongsTo $Manufacturers
 * @property \App\Model\Table\CategoriesProductsTable&\Cake\ORM\Association\BelongsTo $CategoriesProducts
 * @property \App\Model\Table\InventoriesTable&\Cake\ORM\Association\HasMany $Inventories
 *
 * @method \App\Model\Entity\Product newEmptyEntity()
 * @method \App\Model\Entity\Product newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product get($primaryKey, $options = [])
 * @method \App\Model\Entity\Product findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Product[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProductsTable extends Table
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

        $this->setTable('products');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Packagings', [
            'foreignKey' => 'packaging_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Manufacturers', [
            'foreignKey' => 'manufacturer_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('CategoriesProducts', [
            'foreignKey' => 'categories_products_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Inventories', [
            'foreignKey' => 'product_id',
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
            ->decimal('capacity')
            ->allowEmptyString('capacity');

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
            ->integer('order_time')
            ->requirePresence('order_time', 'create')
            ->notEmptyString('order_time');

        $validator
            ->integer('shelf_life')
            ->allowEmptyString('shelf_life');

        $validator
            ->scalar('sku')
            ->maxLength('sku', 10)
            ->requirePresence('sku', 'create')
            ->notEmptyString('sku');

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
            ->scalar('availability')
            ->maxLength('availability', 20)
            ->allowEmptyString('availability');

        $validator
            ->integer('rop')
            ->allowEmptyString('rop');

        $validator
            ->integer('total_quantity')
            ->allowEmptyString('total_quantity');

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
        $rules->add($rules->existsIn(['manufacturer_id'], 'Manufacturers'), ['errorField' => 'manufacturer_id']);
        $rules->add($rules->existsIn(['categories_products_id'], 'CategoriesProducts'), ['errorField' => 'categories_products_id']);
        $rules->add($rules->isUnique(['title']), ['errorField' => 'title',  'message' => 'There is already a Product with this name, please enter a different name.']);
        $rules->add($rules->isUnique(['sku']), ['errorField' => 'sku',  'message' => 'There is already a Product with this SKU, please enter a different SKU.']);
        return $rules;
    }
}
