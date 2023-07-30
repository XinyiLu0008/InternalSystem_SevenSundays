<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Webpages Model
 *
 * @method \App\Model\Entity\Webpage newEmptyEntity()
 * @method \App\Model\Entity\Webpage newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Webpage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Webpage get($primaryKey, $options = [])
 * @method \App\Model\Entity\Webpage findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Webpage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Webpage[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Webpage|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Webpage saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Webpage[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Webpage[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Webpage[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Webpage[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class WebpagesTable extends Table
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

        $this->setTable('webpages');
        $this->setDisplayField('title');
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
            ->scalar('title')
            ->maxLength('title', 50)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->allowEmptyString('location');

        return $validator;
    }
}
