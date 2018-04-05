<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * Saefis Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\DesignationsTable|\Cake\ORM\Association\BelongsTo $Designations
 * @property \App\Model\Table\SaefiListOfVaccinesTable|\Cake\ORM\Association\HasMany $SaefiListOfVaccines
 *
 * @method \App\Model\Entity\Saefi get($primaryKey, $options = [])
 * @method \App\Model\Entity\Saefi newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Saefi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Saefi|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Saefi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Saefi[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Saefi findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SaefisTable extends Table
{
    use SoftDeleteTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('saefis');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
        // add Duplicatable behavior
        $this->addBehavior('Duplicatable.Duplicatable', [
            'contain' => ['SaefiListOfVaccines', 'AefiListOfVaccines', 'Attachments', 'RequestReporters', 'RequestEvaluators', 'Committees', 
                          'SaefiComments', 'SaefiComments.Attachments',  
                          'Committees.Users', 'Committees.SaefiComments', 'Committees.SaefiComments.Attachments', 
                          'ReportStages', 'AefiCausalities', 'AefiCausalities.Users', 'Reports',
                          'OriginalSaefis', 'OriginalSaefis.SaefiListOfVaccines', 'OriginalSaefis.Attachments', 'OriginalSaefis.Reports'],
            'remove' => ['created', 'modified', 'saefi_list_of_vaccines.created',  'attachments.created', 'reports.created',
                          'saefi_list_of_vaccines.modified',  'attachments.modified', 'reports.modified'],
            // mark invoice as copied
            'set' => [
                'copied' => 'new copy'
            ]
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Designations', [
            'foreignKey' => 'designation_id'
        ]);
        $this->belongsTo('Provinces', [
            'foreignKey' => 'province_id'
        ]);
        $this->belongsTo('OriginalSaefis', [
            'foreignKey' => 'saefi_id',
            'dependent' => true,
            'conditions' => array('OriginalSaefis.copied' => 'old copy')
        ]);

        $this->hasMany('SaefiComments', [
            'className' => 'Comments',
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'conditions' => array('SaefiComments.model' => 'Saefis'),
        ]);
        
        $this->hasMany('SaefiListOfVaccines', [
            'foreignKey' => 'saefi_id'
        ]);
        $this->hasMany('AefiListOfVaccines', [
            'foreignKey' => 'saefi_id'
        ]);
        $this->hasMany('AefiCausalities', [
            'foreignKey' => 'saefi_id'
        ]);

        $this->hasMany('ReportStages', [
            'className' => 'ReportStages',
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'conditions' => array('ReportStages.model' => 'Saefis'),
        ]);
        $this->hasMany('Attachments', [
            'className' => 'Attachments',
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'conditions' => array('Attachments.model' => 'Saefis', 'Attachments.category' => 'attachments'),
        ]);
        $this->hasMany('Reports', [
            'className' => 'Attachments',
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'conditions' => array('Reports.model' => 'Saefis', 'Reports.category' => 'reports'),
        ]);


        $this->hasMany('Reviews', [
            'className' => 'Reviews',
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'conditions' => array('Reviews.model' => 'Saefis', 'Reviews.category' => 'causality'),
        ]);
        $this->hasMany('Committees', [
            'className' => 'Reviews',
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'conditions' => array('Committees.model' => 'Saefis', 'Committees.category' => 'committee'),
        ]);
        $this->hasMany('RequestReporters', [
            'className' => 'Notifications',
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'conditions' => array('RequestReporters.model' => 'Saefis', 'RequestReporters.type' => 'request_reporter_info'),
        ]);
        $this->hasMany('RequestEvaluators', [
            'className' => 'Notifications',
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'conditions' => array('RequestEvaluators.model' => 'Saefis', 'RequestEvaluators.type' => 'request_evaluator_info'),
        ]);

    }

    /**
    * @return \Search\Manager
    */
    public function searchManager()
    {
        $searchManager = $this->behaviors()->Search->searchManager();
        $searchManager
            ->value('status')
            ->like('reference_number')
            ->compare('created_start', ['operator' => '>=', 'field' => ['created']])
            ->compare('created_end', ['operator' => '<=', 'field' => ['created']])
            ->compare('report_date_start', ['operator' => '>=', 'field' => ['report_date']])
            ->compare('report_date_end', ['operator' => '<=', 'field' => ['report_date']])
            ->value('status_on_date')
            ->value('pregnant')
            ->value('infant')
            ->value('delivery_procedure')
            ->like('reporter_name')
            ->like('mobile')
            ->like('reporter_email')
            ->value('designation_id')
            ->like('patient_name');

        return $searchManager;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name_of_vaccination_site')
            ->notEmpty('name_of_vaccination_site', ['message' => 'Name of vaccination site required']);

        $validator
            ->scalar('designation_id')
            ->notEmpty('designation_id', ['message' => 'Designation required']);

        $validator
            ->scalar('reporter_name')
            ->notEmpty('reporter_name', ['message' => 'Reporter name required']);

        $validator
            ->scalar('patient_name')
            ->notEmpty('patient_name', ['message' => 'Patient name required']);

        $validator
            ->scalar('gender')
            ->notEmpty('gender', ['message' => 'Gender required']);

        $validator
            ->scalar('signs_symptoms')
            ->notEmpty('signs_symptoms', ['message' => 'Signs and symptoms required']);

        $validator->allowEmpty('suspected_drug', function ($context) {
            // return !$context['data']['is_taxable'];
            if (isset($context['data']['aefi_list_of_vaccines'])) {
                foreach ($context['data']['aefi_list_of_vaccines'] as $val){
                    if ($val['suspected_drug'] == 1) {
                        return true;
                    }
                }
            }
            return false;
        }, ['message' => 'Kindly select at least one suspected vaccine']);


        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['designation_id'], 'Designations'));

        return $rules;
    }
}
