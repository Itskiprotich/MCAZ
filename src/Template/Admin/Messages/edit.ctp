<?php
  $this->Html->script('ckeditor_2/ckeditor', ['block' => true]);
?>

<?php $this->start('sidebar'); ?>
  <ul class="nav nav-sidebar">
    <li class="active"><?= $this->Html->link('Overview', ['controller' => 'Users', 'action' => 'dashboard', 'prefix' => $prefix], array('escape' => false)); ?></li>
    <li>
      <?= $this->Html->link('ADRS', ['controller' => 'Sadrs', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); ?>
    </li>
    <li>
      <?= $this->Html->link('AEFIS', ['controller' => 'Aefis', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); ?>
    </li>
    <li>
      <?= $this->Html->link('SAEFIS', ['controller' => 'Saefis', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); ?>
    </li>
    <li>
      <?= $this->Html->link('SAES', ['controller' => 'Adrs', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); ?>
    </li>
  </ul>
<?php $this->end(); ?>


<h1 class="page-header">Messages</h1>


<?= $this->Html->link('<i class="fa fa-file-code-o" aria-hidden="true"></i> Add Message Template', ['controller' => 'messages', 'action' => 'add', 'prefix' => 'admin'], array('escape' => false, 'class' => 'btn btn-info')); ?> &nbsp;
<?= $this->Html->link('List Message Templates', ['controller' => 'messages', 'action' => 'index', 'prefix' => 'admin'], array('escape' => false, 'class' => 'btn btn-success')); ?> &nbsp;
<hr>

<div class="row">
    <?= $this->Form->create($message) ?>
    <fieldset>
        <legend><?= __('Add Message') ?></legend>
        <div class="col-md-6">
            <?php
                echo $this->Form->control('name');
                echo $this->Form->control('subject');
            ?>
        </div>
        <div class="col-md-6">
            <?php
            echo $this->Form->control('style', ['type' => 'select', 'options' => ['info' => 'light-blue', 'warning' => 'orange', 'success' => 'green', 'danger' => 'red'], 'empty' => true]);
            echo $this->Form->control('priority', ['type' => 'select', 'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5], 'empty' => true]);
            ?>
        </div> 
        <div class="col-md-12">
            <?php
                echo $this->Form->control('content', ['label' => 'Message template',                    
                        'templates' =>[     
                          'label' => '<label {{attrs}}>{{text}}</label>',
                          'input' => '<input class="form-control" type="{{type}}" name="{{name}}"{{attrs}}/>',
                          'textarea' => '<textarea class="form-control" rows="2" name="{{name}}"{{attrs}}>{{value}}</textarea>',]]);
                // echo $this->Form->control('type');
                echo $this->Form->input('type', ['options' => ['email' => 'email', 'notification' => 'notification',
                            'message' => 'message']]); 
                echo $this->Form->control('description');
            ?>
        </div>     
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script type="text/javascript">
        CKEDITOR.replace( 'content', {uiColor: '#CCEAEE'}); //, {uiColor: '#CCEAEE'}
</script>