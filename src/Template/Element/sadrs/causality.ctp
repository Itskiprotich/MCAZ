<?php
  use Cake\Utility\Hash;

  $checked = '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
  $nChecked = '<i class="fa fa-square-o" aria-hidden="true"></i>';
?>

<div class="row">
    <div class="col-xs-12">
      <!-- <p>insert causality assessment table here... collapsible. Collapsed by default</p> -->
      <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
         Causality Assessment Rules
      </a>
      <div class="collapse" id="collapseExample">
        <div class="well">
          <h3>WHO Causality classification of Adverse Events<br>
              (AE) definitions categories used by MCAZ and PVCT Committee
              </h3>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Causality Classification</th>
                <th>WHO Causality classification of Adverse Events <br>
                   (AE) definitions categories used by MCAZ and PVCT Committee
                </th>
                <th>DAIDS Investigator causality classification of <br>
                    (AE) definition categories commonly used for clinical trials
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Certain </td>
                <td>Event or laboratory test abnormality, with plausible time
relationship to drug intake
• Cannot be explained by disease or other drugs
• Response to withdrawal plausible (pharmacologically,
pathologically)
• Event definitive pharmacologically or phenomenologically (i.e. an
objective and specific medical disorder or a recognised
pharmacological phenomenon)
• Rechallenge satisfactory, if necessary</td>
                <td>Definitely Related: the exposure to the study 
agent and adverse event are related in time, and a 
direct association can be demonstrated (e.g. the 
adverse experience has been identified as a 
known toxicity of the study agent product, and 
the study agent is clearly responsible for the 
event.          </td>
</tr>
<tr><td>
Probable/
Likely</td><td>
Event or laboratory test abnormality, with reasonable time
relationship to drug intake
• Unlikely to be attributed to disease or other drugs
• Response to withdrawal clinically reasonable
• Rechallenge not required</td><td>
Probably related: The administration the study 
agent/procedures & adverse event are considered 
reasonably related in time and the event is more 
likely explained by the study agent than other 
causes.</td>
</tr>
<tr><td>
Possible</td><td>
Event or laboratory test abnormality, with reasonable time
relationship to drug intake
• Could also be explained by disease or other drugs
• Information on drug withdrawal may be lacking or unclear</td><td>
Possibly related: The adverse event and the administration of the study agent/procedures are reasonably related in time, and the adverse event can be explained equally well by causes other than the study agent/procedures.
</td>
</tr>
<tr><td>
Unlikely</td><td>
Event or laboratory test abnormality, with a time to drug intake
that makes a relationship improbable (but not impossible)
• Disease or other drugs provide plausible explanations</td><td>
Probably not related: A potential relationship between the study agent/procedures and the adverse event could exist (i.e. the possibility cannot be excluded) but the adverse event is most likely explained by causes other than the study agent/procedures.
</td>
</tr>
<tr><td>
Conditional/
Unclassified</td><td>
Event or laboratory test abnormality
• More data for proper assessment needed, or
• Additional data under examination</td><td>
Not related: The adverse event is clearly explained by another cause not related to the study agent/procedures.
</td></tr>
<tr><td>
Unassessable/
Unclassifiable</td><td>
Report suggesting an adverse reaction
• Cannot be judged because information is insufficient or
contradictory
• Data cannot be supplemented or verified</td><td>
Pending:
*May be used as a temporary assessment only for death
*Used only if data necessary to determine the relationship to study agent/procedures is being collected
*A final assessment of relationship should be 
within 3 business days after reporting the death
*If no final assessment is made within 3 business days by site, event will be assesses as possibly related to study agent/procedures
*Any additional information received at a later 
time including an autopsy (post-mortem) report
should be submitted as follow up report</td></tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>

 <?php foreach ($sadr->reviews as $review) {  ?>
      <div class="row">
        <div class="col-xs-12">          
          <div class="ctr-groups">
            <p class="topper"><small><em class="text-success">reviewed on: <?= $review['created'] ?> by <?= $review->user->name ?></em></small></p>
            <div class="amend-form">
                <?php
                //echo $this->Html->link('<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download PDF ', ['controller' => 'Applications', 'action' => 'committee', '_ext' => 'pdf', $review->id], ['escape' => false, 'class' => 'btn btn-xs btn-success active topright']);


                $template = $this->Form->getTemplates();
                $this->Form->resetTemplates();
                echo $this->Form->postLink(
                    '<span class="label label-info">Edit</span>',
                    [],
                    ['data' => ['review_id' => $review->id], 'escape' => false, 
                     'confirm' => __('Are you sure you want to edit review {0}?', $review->id)]
                );
                $this->Form->setTemplates($template);

                ?>
              <div class="row">
                <div class="col-xs-8">
                
                      
                        <form>
                          <div class="form-group">
                            <label class="control-label">Literature Review</label>
                            <div>
                              <p class="form-control-static"><?= $review->literature_review ?></p>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Comments</label>
                            <div>
                              <p class="form-control-static"><?= $review->comments ?></p>
                            </div>
                          </div> 
                          <div class="form-group">
                            <label class="control-label">References Text:</label>
                            <div>
                            <p class="form-control-static"><?= $review['references_text'] ?></p>
                            </div> 
                          </div> 
                          <div class="form-group">
                            <label class="control-label">File</label>
                            <div class="">
                              <p class="form-control-static text-info text-left"><?php
                                   echo $this->Html->link($review->file, substr($review->dir, 8) . '/' . $review->file, ['fullBase' => true]);
                              ?></p>
                            </div>
                          </div> 

                          <div class="form-group">
                            <div class="control-label">
                              <label><?= ($review->signature) ? $checked : $nChecked; ?> Signature</label>
                            </div>
                            <div>
                              <h4 class="form-control-static text-info text-left"><?php          
                                echo ($review->signature) ? "<img src='".$this->Url->build(substr($review->user->dir, 8) . '/' . $review->user->file, true)."' style='width: 30%;' alt=''>" : '';
                              ?></h4>
                            </div>
                          </div>

                          </form>  <br>

                          <?php if($review->chosen == 1) { ?>
                            <div class="form-group">
                              <div class="control-label">
                                <label>Manager's Signature</label>
                              </div>
                              <div>
                                <h4 class="form-control-static text-info text-left"><?php          
                                  echo "<img src='".$this->Url->build(substr(Hash::combine($users->toArray(), '{n}.id', '{n}.dir')[$sadr->assigned_by], 8) . '/' . Hash::combine($users->toArray(), '{n}.id', '{n}.file')[$sadr->assigned_by], true)."' style='width: 30%;' alt=''>";
                                ?></h4>
                              </div>
                            </div>                          
                          <?php 
                            //If the current user did not submit the review and review final submission not yet done
                            } elseif($review->user_id != $this->request->session()->read('Auth.User.id') && $sadr->signature != 1) { 
                                $template = $this->Form->getTemplates();
                                $this->Form->resetTemplates();
                                echo $this->Form->postLink('<span class="label label-info">Attach signature?</span>', 
                                  ['action' => 'attachSignature', $review->id, 'prefix' => $prefix], 
                                  ['escape' => false, 'confirm' => 'Are you sure you want to attach your signature to assessment?', 'class' => 'label-link']);
                                $this->Form->setTemplates($template);                              
                            } 
                          ?>                 
                  
                  
                </div>

                <!-- include comments -->
                <div class="col-xs-4 lefty">
                  <?php //pr($review->comments) ?>
                  <?php echo $this->element('comments/list', ['comments' => $review->sadr_comments]) ?> 
                  <?php if(!in_array("FinalStage", Hash::extract($sadr->report_stages, '{n}.stage')) && !empty($sadr->assigned_to)) { ?>
                  <?php  
                        echo $this->element('comments/add', [
                          'model' => ['model_id' => $sadr->id, 'foreign_key' => $review->id, 
                                      'model' => 'Sadrs', 'category' => 'causality', 'url' => 'add-from-causality/sadrs']]) 
                  ?>
                  <?php } ?>
                </div>
            </div>  
          </div>
          </div>
        </div>
      </div>
    <?php } ?>

    <?php if($sadr->signature != 1) { ?>
    <div class="col-xs-12">
      <hr>
          <?php echo $this->Form->create($sadr, ['url' => ['action' => 'causality']]);
                // $i = count($sadr['reviews']);
           ?>
            <div class="row">
              <div class="col-xs-12"><h5 class="text-center">Causality Assessment</h5></div>
              <div class="col-xs-12">
	          	<?php
                    echo $this->Form->control('sadr_pr_id', ['type' => 'hidden', 'value' => $sadr->id, 'escape' => false, 'templates' => 'table_form']);
	                  echo $this->Form->control('reviews.'.$ekey.'.id', ['type' => 'hidden', 'escape' => false, 'templates' => 'table_form']);
                    echo $this->Form->control('reviews.'.$ekey.'.literature_review', ['escape' => false, 'templates' => 'app_form']);
                    echo $this->Form->control('reviews.'.$ekey.'.comments', ['escape' => false, 'templates' => 'app_form']);
                    echo $this->Form->control('reviews.'.$ekey.'.references_text', ['escape' => false, 'templates' => 'app_form']);
	            ?>
         	    </div>          
            </div>

            <div class="row">
              <div class="col-xs-6">
                <?php
                  // if ($prefix == 'manager') {                  
                  //     echo $this->Form->control('reviews.'.$ekey.'.signature', ['type' => 'checkbox', 'label' => 'Attach signature', 'escape' => false, 'templates' => 'app_form']);
                  // } else {
                      echo "<div class='control-label'><label>Signature<label></div>";
                      echo $this->Form->control('reviews.'.$ekey.'.signature', ['type' => 'hidden', 'value' => 1, 'templates' => 'table_form']);
                  // }
                ?>
              </div>
              <div class="col-xs-4">
                <?php          
                  echo "<img src='".$this->Url->build(substr($this->request->session()->read('Auth.User.dir'), 8) . '/' . $this->request->session()->read('Auth.User.file'), true)."' style='width: 70%;' alt=''>";
                ?>
              </div>
              <div class="col-xs-2"> </div>
            </div>
            <br>

            <div class="form-group"> 
                <div class="col-sm-offset-4 col-sm-8"> 
                  <button type="submit" class="btn btn-primary active" id="registerUser"><i class="fa fa-plus" aria-hidden="true"></i> Review</button>
                </div> 
              </div>
         <?php echo $this->Form->end() ?>
    </div>
    <?php } ?>
  </div>