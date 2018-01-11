<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;

/**
 * Adrs Controller
 *
 * @property \App\Model\Table\AdrsTable $Adrs
 *
 * @method \App\Model\Entity\Adr[] paginate($object = null, array $settings = [])
 */
class AdrsController extends AppController
{

    public function initialize() {
       parent::initialize();
       //$this->Auth->allow(['add', 'edit']);   
       $this->loadComponent('Search.Prg', [
            'actions' => ['index', 'restore']
        ]);    
    }

    /**
     * BeforeFilter method
     * Use to format request data
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        //debug($this->request->data);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($this->request->is(['patch', 'post', 'put'])) {
                if (isset($this->request->data['date_of_birth'])) {
                    $this->request->data['date_of_birth'] = implode('-', $this->request->data['date_of_birth']);
                } 
                //date_of_onset_of_reaction
                if (isset($this->request->data['date_of_onset_of_reaction'])) {
                    $this->request->data['date_of_onset_of_reaction'] = implode('-', $this->request->data['date_of_onset_of_reaction']);
                }
                //date_of_end_of_reaction
                if (isset($this->request->data['date_of_end_of_reaction'])) {
                    $this->request->data['date_of_end_of_reaction'] = implode('-', $this->request->data['date_of_end_of_reaction']);
                }
            }
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['AdrLabTests', 'AdrListOfDrugs', 'AdrOtherDrugs', 'Attachments', 'RequestReporters', 'RequestEvaluators', 'Committees', 'Reviews']
        ];
        $query = $this->Adrs
            ->find('search', ['search' => $this->request->query])
            ->where(['status !=' =>  (!$this->request->getQuery('status')) ? 'UnSubmitted' : 'something_not', 'IFNULL(copied, "N") !=' => 'old copy']);
        $designations = $this->Adrs->Designations->find('list', ['limit' => 200]);
        $this->set(compact('designations'));
        $this->set('adrs', $this->paginate($query));

        $_designations = $designations->toArray();
        if ($this->request->params['_ext'] === 'csv') {
            $_serialize = 'query';
            $_header = [ 'id', 'user_id', 'adr_id', 'reference_number', 'assigned_to', 'assigned_by', 'assigned_date', 'mrcz_protocol_number', 'mcaz_protocol_number', 'principal_investigator', 'reporter_name', 'reporter_email', 
            'designation_id',
            'reporter_phone', 'name_of_institution', 'institution_code', 'study_title', 'study_sponsor', 'date_of_adverse_event', 'participant_number', 'report_type', 'date_of_site_awareness', 'date_of_birth', 'age', 'gender', 'study_week', 'visit_number', 'adverse_event_type', 'sae_type', 'sae_description', 'toxicity_grade', 'previous_events', 'previous_events_number', 'total_saes', 'location_event', 'location_event_specify', 'research_involves', 'research_involves_specify', 'name_of_drug', 'drug_investigational', 'patient_other_drug', 'report_to_mcaz', 'report_to_mcaz_date', 'report_to_mrcz', 'report_to_mrcz_date', 'report_to_sponsor', 'report_to_sponsor_date', 'report_to_irb', 'report_to_irb_date', 'medical_history', 'diagnosis', 'immediate_cause', 'symptoms', 'investigations', 'results', 'management', 'outcome', 'd1_consent_form', 'd2_brochure', 'd3_changes_sae', 'd4_consent_sae', 'changes_explain', 'assess_risk', 'submitted', 'submitted_date', 'status', 'created', 'modified',   
            'adr_list_of_drugs.drug_name', 'adr_list_of_drugs.dose', 'adr_list_of_drugs.dose_id', 'adr_list_of_drugs.route_id', 'adr_list_of_drugs.frequency_id', 'adr_list_of_drugs.start_date', 'adr_list_of_drugs.taking_drug', 'adr_list_of_drugs.relationship_to_sae',   
            'adr_other_drugs.drug_name', 'adr_other_drugs.start_date', 'adr_other_drugs.stop_date', 'adr_other_drugs.relationship_to_sae',  
            'adr_lab_tests.lab_test', 'adr_lab_tests.abnormal_result', 'adr_lab_tests.site_normal_range', 'adr_lab_tests.collection_date', 'adr_lab_tests.lab_value', 'adr_lab_tests.lab_value_date', 
                'committees.comments', 'committees.literature_review', 'committees.references_text', 
                'request_evaluators.system_message', 'request_evaluators.user_message', 
                'request_reporters.system_message', 'request_reporters.user_message', 
                'reviews.system_message', 'reviews.user_message', 
                'attachments.file'
            ];
            $_extract = ['id', 'user_id', 'adr_id', 'reference_number', 'assigned_to', 'assigned_by', 'assigned_date', 'mrcz_protocol_number', 'mcaz_protocol_number', 'principal_investigator', 'reporter_name', 'reporter_email',
            function ($row) use($_designations) { return $_designations[$row['designation_id']] ?? '' ; }, //'designation_id',
            'reporter_phone', 'name_of_institution', 'institution_code', 'study_title', 'study_sponsor', 'date_of_adverse_event', 'participant_number', 'report_type', 'date_of_site_awareness', 'date_of_birth', 'age', 'gender', 'study_week', 'visit_number', 'adverse_event_type', 'sae_type', 'sae_description', 'toxicity_grade', 'previous_events', 'previous_events_number', 'total_saes', 'location_event', 'location_event_specify', 'research_involves', 'research_involves_specify', 'name_of_drug', 'drug_investigational', 'patient_other_drug', 'report_to_mcaz', 'report_to_mcaz_date', 'report_to_mrcz', 'report_to_mrcz_date', 'report_to_sponsor', 'report_to_sponsor_date', 'report_to_irb', 'report_to_irb_date', 'medical_history', 'diagnosis', 'immediate_cause', 'symptoms', 'investigations', 'results', 'management', 'outcome', 'd1_consent_form', 'd2_brochure', 'd3_changes_sae', 'd4_consent_sae', 'changes_explain', 'assess_risk', 'submitted', 'submitted_date', 'status', 'created', 'modified',   
                function ($row) { return implode('|', Hash::extract($row['adr_list_of_drugs'], '{n}.drug_name')); }, //'.drug_name', 
                function ($row) { return implode('|', Hash::extract($row['adr_list_of_drugs'], '{n}.dose')); }, //'.dose', 
                function ($row) { return implode('|', Hash::extract($row['adr_list_of_drugs'], '{n}.dose_id')); }, //'.dose_id', 
                function ($row) { return implode('|', Hash::extract($row['adr_list_of_drugs'], '{n}.route_id')); }, //'.route_id', 
                function ($row) { return implode('|', Hash::extract($row['adr_list_of_drugs'], '{n}.frequency_id')); }, //'.frequency_id', 
                function ($row) { return implode('|', Hash::extract($row['adr_list_of_drugs'], '{n}.start_date')); }, //'.start_date', 
                function ($row) { return implode('|', Hash::extract($row['adr_list_of_drugs'], '{n}.taking_drug')); }, //'.taking_drug', 
                function ($row) { return implode('|', Hash::extract($row['adr_list_of_drugs'], '{n}.relationship_to_sae')); }, //'.relationship_to_sae',   
                function ($row) { return implode('|', Hash::extract($row['adr_other_drugs'], '{n}.drug_name')); }, //''.drug_name', 
                function ($row) { return implode('|', Hash::extract($row['adr_other_drugs'], '{n}.start_date')); }, //'.start_date', 
                function ($row) { return implode('|', Hash::extract($row['adr_other_drugs'], '{n}.stop_date')); }, //'.stop_date', 
                function ($row) { return implode('|', Hash::extract($row['adr_other_drugs'], '{n}.relationship_to_sae')); }, //'.relationship_to_sae', 
                function ($row) { return implode('|', Hash::extract($row['adr_lab_tests'], '{n}.lab_test')); }, //'.lab_test', 
                function ($row) { return implode('|', Hash::extract($row['adr_lab_tests'], '{n}.abnormal_result')); }, //'.abnormal_result', 
                function ($row) { return implode('|', Hash::extract($row['adr_lab_tests'], '{n}.site_normal_range')); }, //'.site_normal_range', 
                function ($row) { return implode('|', Hash::extract($row['adr_lab_tests'], '{n}.collection_date')); }, //'.collection_date', 
                function ($row) { return implode('|', Hash::extract($row['adr_lab_tests'], '{n}.lab_value')); }, //'.lab_value', 
                function ($row) { return implode('|', Hash::extract($row['adr_lab_tests'], '{n}.lab_value_date')); }, //'.lab_value_date', 
                function ($row) { return implode('|', Hash::extract($row['committees'], '{n}.comments')); }, //'committees.comments', 
                function ($row) { return implode('|', Hash::extract($row['committees'], '{n}.literature_review')); }, //'.literature_review', 
                function ($row) { return implode('|', Hash::extract($row['committees'], '{n}.references_text')); }, //'.references_text', 
                function ($row) { return implode('|', Hash::extract($row['request_evaluators'], '{n}.system_message')); }, //'.system_message', 
                function ($row) { return implode('|', Hash::extract($row['request_evaluators'], '{n}.user_message')); }, // '.user_message', 
                function ($row) { return implode('|', Hash::extract($row['request_reporters'], '{n}.system_message')); }, //'.system_message', 
                function ($row) { return implode('|', Hash::extract($row['request_reporters'], '{n}.system_message')); }, //'.user_message', 
                function ($row) { return implode('|', Hash::extract($row['reviews'], '{n}.system_message')); }, //'reviews.system_message', 
                function ($row) { return implode('|', Hash::extract($row['reviews'], '{n}.user_message')); }, //'reviews.user_message', 
                function ($row) { return implode('|', Hash::extract($row['attachments'], '{n}.file')); }, //'attachments.file'
            ];

            $this->set(compact('query', '_serialize', '_header', '_extract'));
        }
    }
    public function restore() {
        $this->paginate = [
            'contain' => []
        ];
        
        $query = $this->Adrs
            ->find('search', ['search' => $this->request->query, 'withDeleted'])
            ->where(['deleted IS NOT' =>  null]);
        $designations = $this->Adrs->Designations->find('list', ['limit' => 200]);
        $this->set(compact('designations'));
        $this->set('adrs', $this->paginate($query));
    }
    public function restoreDeleted($id = null)
    {

        $this->request->allowMethod(['post', 'delete', 'get']);
        $adr = $this->Adrs->get($id, ['withDeleted']);
        if ($this->Adrs->restore($adr)) {
            $this->Flash->success(__('The SAE has been restored.'));
        } else {
            $this->Flash->error(__('The SAE could not be restored. Please, try again.'));
        }

        return $this->redirect(['action' => 'restore']);
    }

    /**
     * View method
     *
     * @param string|null $id Adr id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $adr = $this->Adrs->get($id, [
            'contain' => ['AdrLabTests', 'AdrListOfDrugs', 'AdrOtherDrugs', 'Attachments', 'RequestReporters', 'RequestEvaluators', 
                          'Committees', 'Reviews', 
                          'OriginalAdrs', 'OriginalAdrs.AdrListOfDrugs', 'OriginalAdrs.AdrOtherDrugs', 'OriginalAdrs.Attachments'], 'withDeleted'
        ]);

        // $this->viewBuilder()->setLayout('pdf/default');
        if(strpos($this->request->url, 'pdf')) {
            $this->viewBuilder()->helpers(['Form' => ['templates' => 'pdf_form',]]);
            $this->viewBuilder()->options([
                'pdfConfig' => [
                    'orientation' => 'portrait',
                    'filename' => $adr->reference_number.'.pdf'
                ]
            ]);
        }
        
        $evaluators = $this->Adrs->Users->find('list', ['limit' => 200])->where(['group_id' => 4]);
        $users = $this->Adrs->Users->find('list', ['limit' => 200])->where(['group_id IN' => [2, 4]]);
        
        $designations = $this->Adrs->Designations->find('list', ['limit' => 200]);
        $doses = $this->Adrs->AdrListOfDrugs->Doses->find('list');
        $routes = $this->Adrs->AdrListOfDrugs->Routes->find('list');
        $frequencies = $this->Adrs->AdrListOfDrugs->Frequencies->find('list');
        $this->set(compact('adr', 'designations', 'doses', 'routes', 'frequencies', 'evaluators', 'users'));
        $this->set('_serialize', ['adr']);

        $this->set('adr', $adr);
        $this->set('_serialize', ['adr']);
    }


    public function assignEvaluator() {
        $adr = $this->Adrs->get($this->request->getData('adr_pr_id'), []);
        if (isset($adr->id) && $this->request->is('post')) {
            $adr->assigned_by = $this->Auth->user('id');
            $adr->assigned_to = $this->request->getData('evaluator');
            $adr->assigned_date = date("Y-m-d H:i:s");
            $adr->status = 'Assigned';
            $evaluator = $this->Adrs->Users->get($this->request->getData('evaluator'));
            if ($this->Adrs->save($adr)) {
                //Send email and message (if present!!!) to evaluator
                $this->loadModel('Queue.QueuedJobs');    
                $data = [
                    'email_address' => $evaluator->email, 'user_id' => $evaluator->id,
                    'type' => 'manager_assign_evaluator_email', 'model' => 'Adrs', 'foreign_key' => $adr->id,
                    'vars' =>  $adr->toArray()
                ];
                $data['vars']['assigned_by_name'] = $this->Auth->user('name');
                $data['vars']['user_message'] = $this->request->getData('user_message');
                $data['vars']['name'] = $evaluator->name;
                //notify evaluator
                $this->QueuedJobs->createJob('GenericEmail', $data);
                $data['type'] = 'manager_assign_evaluator_notification';
                $this->QueuedJobs->createJob('GenericNotification', $data);
                if ($this->request->getData('user_message')) {
                  $data['type'] = 'manager_assign_evaluator_message';
                  $data['user_message'] = $this->request->getData('user_message');
                  $this->QueuedJobs->createJob('GenericNotification', $data);
                }
                
                //notify manager                
                $data = ['user_id' => $adr->assigned_by, 'model' => 'Adrs', 'foreign_key' => $adr->id,
                    'vars' =>  $adr->toArray()];
                $data['vars']['assigned_to_name'] = $evaluator->name;
                $data['type'] = 'manager_assign_notification';
                $this->QueuedJobs->createJob('GenericNotification', $data);
                //end 
                
               $this->Flash->success('Evaluator '.$evaluator->name.' assigned AEFI '.$adr->reference_number);

                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('Unable to assign evaluator. Please, try again.')); 
                return $this->redirect($this->referer());
            }
        } else {
                $this->Flash->error(__('Unknown AEFI Report. Please correct.')); 
                return $this->redirect($this->referer());
        }
    }


    public function requestEvaluator() {
        $adr = $this->Adrs->get($this->request->getData('adr_pr_id'), []);
        if (isset($adr->id) && $this->request->is('post')) {
            $adr = $this->Adrs->patchEntity($adr, $this->request->getData());

            $adr->status = 'RequestEvaluator';
            $adr->request_evaluators[0]->user_id = $adr->assigned_to;
            $adr->request_evaluators[0]->sender_id = $this->Auth->user('id');  //TODO: Can have view to see all messages where I requested for info
            $adr->request_evaluators[0]->type = 'request_evaluator_info';
            $adr->request_evaluators[0]->model = 'Adrs';
            $adr->request_evaluators[0]->foreign_key = $adr->id;

            //Notification should be sent to assigned_to evaluator if exists
            if ($this->Adrs->save($adr)) {
                //Send email and message (if present!!!) to evaluator
                $this->loadModel('Queue.QueuedJobs');    
                if(!empty($adr->assigned_to)) {
                    $evaluator = $this->Adrs->Users->get($adr->assigned_to);
                    $data = [
                      'email_address' => $evaluator->email, 'user_id' => $evaluator->id,
                      'type' => 'manager_request_evaluator_email', 'model' => 'Adrs', 'foreign_key' => $adr->id,
                        'vars' =>  $adr->toArray()
                    ];
                    $data['vars']['name'] = $evaluator->name;
                    $data['vars']['user_message'] = $adr->request_evaluators[0]->user_message;
                    //notify applicant
                    $this->QueuedJobs->createJob('GenericEmail', $data);
                    $data['type'] = 'manager_request_evaluator_message';
                    $this->QueuedJobs->createJob('GenericNotification', $data);                
                } else {
                    $this->Flash->error(__('Unable to locate evaluator.')); 
                    return $this->redirect($this->referer());
                }

                //end 
                
               $this->Flash->success('Request successfully sent to evaluator for Adr '.$adr->reference_number);

                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('Unable to send request to evaluator. Please, try again.')); 
                return $this->redirect($this->referer());
            }
        } else {
               $this->Flash->error(__('Unknown Adr Report. Please correct.')); 
               return $this->redirect($this->referer());
        }
    }

    public function causality() {
        $adr = $this->Adrs->get($this->request->getData('adr_pr_id'), []);
        if (isset($adr->id) && $this->request->is('post')) {
            $adr = $this->Adrs->patchEntity($adr, $this->request->getData());
            $adr->status = 'Evaluated';
            $adr->reviews[0]->user_id = $this->Auth->user('id');
            $adr->reviews[0]->model = 'Adrs';
            $adr->reviews[0]->category = 'causality';
            //Notification should be sent to manager and assigned_to evaluator if exists
            if ($this->Adrs->save($adr)) {
                //Send email and message (if present!!!) to evaluator
                $this->loadModel('Queue.QueuedJobs');    
                if(!empty($adr->assigned_to)) {
                    $evaluator = $this->Adrs->Users->get($adr->assigned_to);
                    $data = [
                      'email_address' => $evaluator->email, 'user_id' => $evaluator->id,
                      'type' => 'manager_review_assigned_email', 'model' => 'Adrs', 'foreign_key' => $adr->id,
                        'vars' =>  $adr->toArray()
                    ];
                    $data['vars']['name'] = $evaluator->name;
                    $data['vars']['assigned_by_name'] = $this->Auth->user('name');
                    //notify applicant
                    $this->QueuedJobs->createJob('GenericEmail', $data);
                    $data['type'] = 'manager_review_assigned_notification';
                    $this->QueuedJobs->createJob('GenericNotification', $data);                
                } 

                //notify manager                
                $data = ['user_id' => $this->Auth->user('id'), 'model' => 'Adrs', 'foreign_key' => $adr->id,
                    'vars' =>  $adr->toArray()];
                $data['type'] = 'manager_review_notification';
                $this->QueuedJobs->createJob('GenericNotification', $data);
                //end 
                
               $this->Flash->success('Review successfully done for SAE '.$adr->reference_number);

                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('Unable to review report. Please, try again.')); 
                return $this->redirect($this->referer());
            }
        } else {
               $this->Flash->error(__('Unknown SAE Report. Please correct.')); 
               return $this->redirect($this->referer());
        }
    }


    public function requestReporter() {
        $adr = $this->Adrs->get($this->request->getData('adr_pk_id'), []);
        if (isset($adr->id) && $this->request->is('post')) {
            $adr = $this->Adrs->patchEntity($adr, $this->request->getData());
            $adr->status = 'RequestReporter';
            $adr->request_reporters[0]->user_id = $adr->user_id;
            $adr->request_reporters[0]->sender_id = $this->Auth->user('id');  //TODO: Can have view to see all messages where I requested for info
            $adr->request_reporters[0]->type = 'request_reporter_info';
            $adr->request_reporters[0]->model = 'Adrs';
            $adr->request_reporters[0]->foreign_key = $adr->id;
            //Notification should be sent to reporter and assigned_to evaluator if exists
            if ($this->Adrs->save($adr)) {
                //Send email and message (if present!!!) to reporter
                $this->loadModel('Queue.QueuedJobs');    
                if(!empty($adr->user_id)) {
                    $reporter = $this->Adrs->Users->get($adr->user_id);
                    $data = [
                      'email_address' => $reporter->email, 'user_id' => $reporter->id,
                      'type' => 'manager_request_reporter_email', 'model' => 'Adrs', 'foreign_key' => $adr->id,
                        'vars' =>  $adr->toArray()
                    ];
                    $data['vars']['user_message'] = $adr->request_reporters[0]->user_message;
                    //notify applicant
                    $this->QueuedJobs->createJob('GenericEmail', $data);
                    $data['type'] = 'manager_request_reporter_message';
                    $this->QueuedJobs->createJob('GenericNotification', $data);                
                } else {
                    $this->Flash->error(__('Unable to locate reporter.')); 
                    return $this->redirect($this->referer());
                }

                //notify assigned evaluator      
                if(!empty($adr->assigned_to)) {
                    $evaluator = $this->Adrs->Users->get($adr->assigned_to);
                    $data = [
                      'email_address' => $evaluator->email, 'user_id' => $evaluator->id,
                      'type' => 'manager_request_reporter_evaluator_notification', 'model' => 'Adrs', 'foreign_key' => $adr->id,
                        'vars' =>  $adr->toArray()
                    ];
                    $data['vars']['assigned_by_name'] = $this->Auth->user('name');
                    $data['vars']['user_message'] = $adr->request_reporters[0]->user_message;
                    //notify evaluator
                    $this->QueuedJobs->createJob('GenericNotification', $data);                
                }          
                //manager does not get a notificatoin
                //end 
                
               $this->Flash->success('Request successfully sent to reporter for Adr '.$adr->reference_number);

                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('Unable to send request to reporter. Please, try again.')); 
                return $this->redirect($this->referer());
            }
        } else {
               $this->Flash->error(__('Unknown Adr Report. Please correct.')); 
               return $this->redirect($this->referer());
        }
    }

    public function committeeReview() {
        $adr = $this->Adrs->get($this->request->getData('adr_pr_id'), []);
        if (isset($adr->id) && $this->request->is('post')) {
            $adr = $this->Adrs->patchEntity($adr, $this->request->getData());
            $adr->status = (!empty($this->request->data['status'])) ? $this->request->data['status'] : 'Committee';
            $adr->committees[0]->user_id = $this->Auth->user('id');
            $adr->committees[0]->model = 'Adrs';
            $adr->committees[0]->category = 'committee';
            //Notification should be sent to manager and assigned_to evaluator if exists
            if ($this->Adrs->save($adr)) {
                //Send email and message (if present!!!) to evaluator
                $this->loadModel('Queue.QueuedJobs');    
                if(!empty($adr->assigned_to)) {
                    $evaluator = $this->Adrs->Users->get($adr->assigned_to);
                    $data = [
                      'email_address' => $evaluator->email, 'user_id' => $evaluator->id,
                      'type' => 'manager_committee_assigned_email', 'model' => 'Adrs', 'foreign_key' => $adr->id,
                        'vars' =>  $adr->toArray()
                    ];
                    $data['vars']['name'] = $evaluator->name;
                    $data['vars']['assigned_by_name'] = $this->Auth->user('name');
                    //notify applicant
                    $this->QueuedJobs->createJob('GenericEmail', $data);
                    $data['type'] = 'manager_committee_assigned_notification';
                    $this->QueuedJobs->createJob('GenericNotification', $data);                
                } 

                //notify manager                
                $data = ['user_id' => $this->Auth->user('id'), 'model' => 'Adrs', 'foreign_key' => $adr->id,
                    'vars' =>  $adr->toArray()];
                $data['type'] = 'manager_committee_notification';
                $this->QueuedJobs->createJob('GenericNotification', $data);

                //reporter visible notification and email sent when approved
                if(!empty($adr->committees[0]->literature_review) && $adr->status == 'Approved') {
                    $reporter = $this->Adrs->Users->get($adr->user_id);
                    $data = [
                      'email_address' => $adr->reporter_email, 'user_id' => $adr->user_id,
                      'type' => 'reporter_committee_comments_email', 'model' => 'Adrs', 'foreign_key' => $adr->id,
                        'vars' =>  $adr->toArray()
                    ];
                    $data['vars']['literature_review'] = $adr->committees[0]->literature_review;
                    //notify applicant
                    $this->QueuedJobs->createJob('GenericEmail', $data);
                    $data['type'] = 'reporter_committee_comments_notification';
                    $this->QueuedJobs->createJob('GenericNotification', $data);     
                }
                //end 
                
               $this->Flash->success('Committee Review successfully done for Adr '.$adr->reference_number);

                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('Unable to review report. Please, try again.')); 
                return $this->redirect($this->referer());
            }
        } else {
               $this->Flash->error(__('Unknown Adr Report. Please correct.')); 
               return $this->redirect($this->referer());
        }
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $adr = $this->Adrs->newEntity();
        if ($this->request->is('post')) {
            $adr = $this->Adrs->patchEntity($adr, $this->request->getData());
            if ($this->Adrs->save($adr, ['validate' => false])) {
                //update field
		$adr->user_id = $this->Auth->user('id');
                $query = $this->Adrs->query();
                $query->update()
                    ->set(['reference_number' => 'SAE'.$adr->id.'/'.$adr->created->i18nFormat('yyyy')])
                    ->where(['id' => $adr->id])
                    ->execute();
                //
                $this->Flash->success(__('The adr has been saved.'));

                return $this->redirect(['action' => 'edit', $adr->id]);
            }
            $this->Flash->error(__('The adr could not be saved. Please, try again.'));
        }
        $users = $this->Adrs->Users->find('list', ['limit' => 200]);
        $designations = $this->Adrs->Designations->find('list', ['limit' => 200]);
        $this->set(compact('adr', 'users', 'designations'));
        $this->set('_serialize', ['adr']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Adr id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    private function format_dates($adr) {
        //format dates
        if (!empty($adr->date_of_birth)) {
            if(empty($adr->date_of_birth)) $adr->date_of_birth = '--';
            $a = explode('-', $adr->date_of_birth);
            $adr->date_of_birth = array('day'=> $a[0],'month'=> $a[1],'year'=> $a[2]);
        } 
        if (!empty($adr->date_of_onset_of_reaction)) {
            if(empty($adr->date_of_onset_of_reaction)) $adr->date_of_onset_of_reaction = '--';
            $a = explode('-', $adr->date_of_onset_of_reaction);
            $adr->date_of_onset_of_reaction = array('day'=> $a[0],'month'=> $a[1],'year'=> $a[2]);
        }
        if (!empty($adr->date_of_end_of_reaction)) {
            if(empty($adr->date_of_end_of_reaction)) $adr->date_of_end_of_reaction = '--';
            $a = explode('-', $adr->date_of_end_of_reaction);
            $adr->date_of_end_of_reaction = array('day'=> $a[0],'month'=> $a[1],'year'=> $a[2]);
        }        
        return $adr;
    }

    public function clean($id = null) {
        //ensure only one 
        $orig_adr = $this->Adrs->get($id, []);
        if ($orig_adr->copied === 'new copy') {
            $this->Flash->success(__('An editable copy of the report is already available.'));
            return $this->redirect(['action' => 'edit', $id]);
        }
        $adr = $this->Adrs->duplicateEntity($id);
        $adr->adr_id = $id;        
        $adr->user_id = $this->Auth->user('id'); //the report is reassigned to the evaluator... the reporter should only have original report

        if ($this->Adrs->save($adr, ['validate' => false])) {            
            $query = $this->Adrs->query();
            $query->update()
                ->set(['copied' => 'old copy'])
                ->where(['id' => $orig_adr->id])
                ->execute();
            $this->Flash->success(__('The SAE has been successfully copied. make changes and submit.'));
            return $this->redirect(['action' => 'edit', $adr->id]);
        }
        $this->Flash->error(__('The SAE Report could not be copied. Please, try again.'));
        return $this->redirect($this->referer());        
    }

    public function edit($id = null)
    {
        $adr = $this->Adrs->get($id, [
            'contain' => ['AdrListOfDrugs', 'AdrOtherDrugs', 'AdrLabTests', 'Attachments']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $adr = $this->Adrs->patchEntity($adr, $this->request->getData());
            if (!empty($adr->attachments)) {
              for ($i = 0; $i <= count($adr->attachments)-1; $i++) { 
                $adr->attachments[$i]->model = 'Adrs';
                $adr->attachments[$i]->category = 'attachments';
              }
            }
            
            if ($adr->submitted == 1) {
              //save changes button
                $adr->submitted = 2;
              if ($this->Adrs->save($adr, ['validate' => false])) {
                $this->Flash->success(__('The changes to the Report '.$adr->reference_number.' have been saved.'));
                return $this->redirect(['action' => 'edit', $adr->id]);
              } else {
                // debug($adr->errors());
                $this->Flash->error(__('Report '.$adr->reference_number.' could not be saved. Kindly correct the errors and try again.'));
              }
            } elseif ($adr->submitted == 2) {
              //submit to mcaz button
              if ($this->Adrs->save($adr, ['validate' => false])) {
                $this->Flash->success(__('Report '.$adr->reference_number.' has been successfully submitted to MCAZ for review.')); 
                return $this->redirect(['action' => 'view', $adr->id]);
              } else {
                $this->Flash->error(__('Report could not be saved. Kindly correct the errors and try again.'));
              }
            } elseif ($adr->submitted == -1) {
               //cancel button              
                $this->Flash->success(__('Cancel form successful. You may continue editing report later'));
                return $this->redirect(['controller' => 'Users','action' => 'home']);

           } else {
              if ($this->Adrs->save($adr, ['validate' => false])) {
                $this->Flash->success(__('The changes to the Report have been saved.'));
                return $this->redirect(['action' => 'edit', $adr->id]);
              } else {
                $this->Flash->error(__('Report could not be saved. Kindly correct the errors and try again.'));
              }
           }
           
        }
        $adr = $this->format_dates($adr);

        $users = $this->Adrs->Users->find('list', ['limit' => 200]);
        $designations = $this->Adrs->Designations->find('list',array('order'=>'Designations.name ASC'));
        $doses = $this->Adrs->AdrListOfDrugs->Doses->find('list');
        $routes = $this->Adrs->AdrListOfDrugs->Routes->find('list');
        $frequencies = $this->Adrs->AdrListOfDrugs->Frequencies->find('list');
        $this->set(compact('adr', 'users', 'designations', 'doses', 'routes', 'frequencies'));
        // $this->set(compact('adr', 'users', 'designations'));
        $this->set('_serialize', ['adr']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Adr id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function archive($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $adr = $this->Adrs->get($id);
        //update field
        $query = $this->Adrs->query();
        $query->update()
            ->set(['status' => 'Archived'])
            ->where(['id' => $adr->id])
            ->execute();
        $this->Flash->success(__('The SAE has been archived.'));
        //

        return $this->redirect(['action' => 'index']);
    }
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $adr = $this->Adrs->get($id);
        if ($this->Adrs->delete($adr)) {
            $this->Flash->success(__('The adr has been deleted.'));
        } else {
            $this->Flash->error(__('The adr could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
