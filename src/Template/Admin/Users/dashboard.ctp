<?php $this->start('sidebar'); ?>
  <?= $this->cell('SideBar'); ?>
<?php $this->end(); ?>


<h1 class="page-header">Dashboard</h1>

  <div>
    <div class="col-xs-6 col-sm-4">
      <h2><i class="fa fa-book" aria-hidden="true"></i> <a href="#"> Reports</a></h2>
      <p>View submitted reports</p>
      <ul class="list-group">
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-file" aria-hidden="true"></i> &nbsp; ADRS', ['controller' => 'Sadrs', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-file-text-o" aria-hidden="true"></i> &nbsp; AEFIS', ['controller' => 'Aefis', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-file-text" aria-hidden="true"></i> &nbsp; SAEFIS', ['controller' => 'Saefis', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-file-o" aria-hidden="true"></i> &nbsp; SAES', ['controller' => 'Adrs', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
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
            echo $this->Html->link('<i class="fa fa-user" aria-hidden="true"></i> &nbsp; Users', ['controller' => 'Users', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-users" aria-hidden="true"></i> &nbsp; Groups', ['controller' => 'Groups', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
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
            echo $this->Html->link('<i class="fa fa-code" aria-hidden="true"></i> &nbsp; Front end Pages', ['controller' => 'Sites', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-file-code-o" aria-hidden="true"></i> &nbsp; Message Templates', ['controller' => 'Messages', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
        <li class="list-group-item">
          <?php
            echo $this->Html->link('<i class="fa fa-file-code-o" aria-hidden="true"></i> &nbsp; Facilities', ['controller' => 'Facilities', 'action' => 'index', 'prefix' => $prefix], array('escape' => false)); 
          ?>
        </li>
      </ul>
    </div>
  </div>
