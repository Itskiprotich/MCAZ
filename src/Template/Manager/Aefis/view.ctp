<?php $this->start('sidebar'); ?>
  <?= $this->cell('SideBar'); ?>
<?php $this->end(); ?>

<?php 
  echo $this->Html->link('<button class="btn btn-primary"> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF </button>', ['controller' => 'Aefis', 'action' => 'view', '_ext' => 'pdf', 'prefix' => false, $aefi->id], ['escape' => false]);
  echo $this->element('aefis/reporter_view');
?>