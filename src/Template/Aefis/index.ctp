<?php

use Cake\Utility\Hash;

 $this->start('sidebar'); ?>
  <?= $this->cell('SideBar'); ?>
<?php $this->end(); ?>

<h1 class="page-header"><?= isset($this->request->query['status']) ? $this->request->query['status'] : 'All' ?> AEFIS
    :: <small style="font-size: small;"><i class="fa fa-search-plus" aria-hidden="true"></i> Search, 
              <i class="fa fa-filter" aria-hidden="true"></i>Filter or  
              <i class="fa fa-download" aria-hidden="true"></i>  Download Reports</small>
</h1>

<?= $this->element('aefis/search_mini') ?>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reference_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('report_type', 'Type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php  $filtered = [];
            foreach ($aefis as $sample) : ?>
                <?php
                // check if the  $filtered  is empty
                if (empty($filtered)) {
                    $filtered[] = $sample;
                } else {
                    // 
                    if (!in_array($sample->reference_number, Hash::extract($filtered, '{n}.reference_number'))) {
                        $filtered[] = $sample;
                    }
                }

                ?>
            <?php endforeach;foreach ($filtered as $aefi): ?>
            <tr>
                <td><?= $this->Number->format($aefi->id) ?></td>
                <td><?php
                      echo ($aefi->submitted == 2) ? 
                        $this->Html->link($aefi->reference_number, ['action' => 'view', $aefi->id, 'status' => $aefi->status], ['escape' => false, 'class' => 'btn-zangu']) : 
                        $this->Html->link($aefi->created, ['action' => 'edit', $aefi->id, 'status' => $aefi->status], ['escape' => false, 'class' => 'btn-zangu']) ; ?>
                </td>
                <td><?= h($aefi->status) ?></td>
                <td><?= h($aefi->report_type) ?></td>
                <td><?= h($aefi->modified) ?></td>
                <td>                    
                   <span class="label label-primary">                     
                     <?= $this->Html->link('View', ['action' => 'view', $aefi->id, 'prefix' => $prefix, 'status' => $aefi->status], ['escape' => false, 'class' => 'label-link'])
                     ?>
                    </span> &nbsp;
                   <span class="label label-primary">                    
                     <?= $this->Html->link('PDF', ['action' => 'view', $aefi->id, 'prefix' => $prefix, 'status' => $aefi->status, '_ext' => 'pdf'], ['escape' => false, 'class' => 'label-link'])
                     ?>
                    </span>  &nbsp;
                    <?php if($aefi->submitted == 0 or $aefi->submitted == 1) { ?>
                    <span class="label label-danger">                     
                     <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $aefi->id], ['confirm' => __('Are you sure you want to delete # {0}?', $aefi->id), 'class' => 'label-link']) ?>
                    </span> 
                    <?php } ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginator">
        <ul class="pagination pagination-sm">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
    </div>
    <p><small><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of <b>{{count}}</b> total')]) ?></small></p>
</div>
