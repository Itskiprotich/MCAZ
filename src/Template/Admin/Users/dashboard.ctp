<?php $this->start('sidebar'); ?>
  <?= $this->cell('SideBar'); ?>
<?php $this->end(); ?>



<h1 class="page-header">Dashboard</h1>

  <div>
    <div class="col-xs-6 col-sm-4">
      <h2><i class="fa fa-file-text-o" aria-hidden="true"></i> <a href="#"> Reports</a></h2>
      <p>View submitted reports</p>
      <ul class="list-group">
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-thermometer-0" aria-hidden="true"></i> ADRS', ['controller' => 'Sadrs', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-thermometer-1" aria-hidden="true"></i> AEFIS', ['controller' => 'Aefis', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-thermometer-2" aria-hidden="true"></i> SAEFIS', ['controller' => 'Saefis', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-thermometer-3" aria-hidden="true"></i> SAES', ['controller' => 'Adrs', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
      </ul>
    </div>
    <div class="col-xs-6 col-sm-4 placeholder">
      <h2><i class="fa fa-user-circle-o" aria-hidden="true"></i> <a href="#"> Users</a></h2>
      <p>Manage users</p>
      <ul class="list-group">
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-user" aria-hidden="true"></i> Users', ['controller' => 'Users', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-users" aria-hidden="true"></i> Groups', ['controller' => 'Groups', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
      </ul>
    </div>
    <div class="col-xs-6 col-sm-4 placeholder">
      <h2><i class="fa fa-briefcase" aria-hidden="true"></i> <a href="#"> Content</a></h2>
      <p>Change frontend text and content.</p>
      <ul class="list-group">
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-home" aria-hidden="true"></i> Home page', ['controller' => 'Users', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-address-card-o" aria-hidden="true"></i> Message Templates', ['controller' => 'Messages', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
      </ul>
    </div>
  </div>
