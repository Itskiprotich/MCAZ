<?php $this->start('sidebar'); ?>
  <ul class="nav nav-sidebar">
    <li><?= $this->Html->link('Overview', ['controller' => 'Users', 'action' => 'dashboard', 'prefix' => $prefix], array('escape' => false)); ?></li>
    <li>
      <?= $this->Html->link('ADRS', ['controller' => 'Sadrs', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); ?>
    </li>
    <li>
      <?= $this->Html->link('AEFIS', ['controller' => 'Aefis', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); ?>
    </li>
    <li>
      <?= $this->Html->link('SAEFIS', ['controller' => 'Saefis', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); ?>
    </li>
    <li class="active">
      <?= $this->Html->link('SAES', ['controller' => 'Adrs', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); ?>
    </li>
  </ul>
<?php $this->end(); ?>

<h1 class="page-header">ADRS</h1>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reference_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name_of_institution') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reporter_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reporter_email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reporter_phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adrs as $adr): ?>
            <tr>
                <td><?= $this->Number->format($adr->id) ?></td>
                <td><?= h($adr->reference_number) ?></td>
                <td><?= h($adr->name_of_institution) ?></td>
                <td><?= h($adr->reporter_name) ?></td>
                <td><?= h($adr->reporter_email) ?></td>
                <td><?= h($adr->reporter_phone) ?></td>
                <td><?= h($adr->created) ?></td>
                <td><?= $this->Html->link('View', ['action' => 'view', $adr->id, 'prefix' => $prefix], array('escape' => false)); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
