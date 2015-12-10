<?php defined('SYSPATH') or die('No direct script access.');?>


	<div class="page-header">
		<h1><?=__('Migration')?></h1>
    <p><?=__("Your PHP time limit is")?> <?=ini_get('max_execution_time')?> <?=__("seconds")?>
        <a href="http://open-classifieds.com/2013/12/09/how-to-upgrade-1-7-x1-8-x-to-2-x/" target="_blank">How to 1.7.x/1.8.x to 2.x</a>
    </p>
	</div>
	<form class="well form-horizontal"  method="post" action="<?=Route::url('oc-panel',array('controller'=>'tools','action'=>'migration'))?>">         
          <?=Form::errors()?>        
      <div class="form-group">
        <label class="control-label col-sm-2"><?=__("Host name")?>:</label>
        <div class="col-sm-4">
        <input  type="text" name="hostname" value="<?=$db_config['connection']['hostname']?>" class="col-md-3"  />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2"><?=__("User name")?>:</label>
        <div class="col-sm-4">
        <input  type="text" name="username"  value="<?=$db_config['connection']['username']?>" class="col-md-3"   />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2"><?=__("Password")?>:</label>
        <div class="col-sm-4">
        <input type="text" name="password" value="" class="col-md-3" />   
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2"><?=__("Database name")?>:</label>
        <div class="col-sm-4">
        <input type="text" name="database" value="<?=$db_config['connection']['database']?>"  class="col-md-3"  />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2"><?=__("Database charset")?>:</label>
        <div class="col-sm-4">
        <input type="text" name="charset" value="<?=$db_config['charset']?>"  class="col-md-3"   />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2"><?=__("Table prefix")?>:</label>
        <div class="col-sm-4">
        <input type="text" name="table_prefix" value="oc_" class="col-md-3" />
        </div>
      </div>

      <div class="form-actions">
      	<a href="<?=Route::url('oc-panel')?>" class="btn btn-default"><?=__('Cancel')?></a>
        <button type="submit" class="btn btn-primary"><?=__('Migrate')?></button>
      </div>
	</form>    