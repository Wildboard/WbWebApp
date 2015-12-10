<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
	<h1><?=__('New Custom Field')?></h1>
</div>
        
<form class="well form-horizontal"  method="post" action="<?=Route::url('oc-panel',array('controller'=>'fields','action'=>'new'))?>">         
      <?=Form::errors()?>  
      
        <div class="form-group">
            
                <div class="col-sm-4">
                <label class="control-label"><?=__('Name')?></label>
                <input class="form-control" type="text" name="name" placeholder="<?=__('Name')?>" required>
            </div>
        </div>

        <div class="form-group">
            
                <div class="col-sm-4">
                <label class="control-label"><?=__('Label')?></label>
                <input class="form-control" type="text" name="label" placeholder="<?=__('Label')?>" required>
            </div>
        </div>

        <div class="form-group">
            
                <div class="col-sm-4">
                <label class="control-label"><?=__('Tooltip')?></label>
                <input class="form-control" type="text" name="tooltip" placeholder="<?=__('Tooltip')?>" >
            </div>
        </div>

        <div class="form-group">
                        
            <div class="col-sm-4">
                <label class="control-label" for="date"><?=__('Type')?></label>         
                <select name="type"  class="form-control" id="cf_type_fileds" required>
                    <option value="string"><?=__('Text 256 Chars')?></option>
                    <option value="textarea"><?=__('Text Long')?></option>
                    <option value="integer"><?=__('Number')?></option>  
                    <option value="decimal"><?=__('Number Decimal')?></option>
                    <option value="date"><?=__('Date')?></option>
                    <option value="select"><?=__('Select')?></option>
                    <option value="radio"><?=__('Radio')?></option>
                    <option value="checkbox"><?=__('Checkbox')?></option>
                </select>
            </div>
        </div>

        <div class="form-group">
            
            <div class="col-sm-4">
                <label class="control-label"><?=__('Values')?></label>
                <input class="form-control" id="cf_values_input" type="text" name="values" placeholder="<?=__('Comma separated for select')?>">
            </div>
        </div>

        <!-- multycategory selector -->
        <div class="form-group">
        	<div class="col-sm-4">
        		<label class="control-label"><?=__('Categories')?></label>
				<select id="categories" name="categories[]" multiple>
					<option></option>
					<?foreach ($categories as $categ => $ctg):?>
						<?if($categ !== 1):?>
						<option value="<?=$categ?>"><?=$ctg['name']?></option>
						<?endif?>
					<?endforeach?>
				</select>
			</div>
		</div>

        <div class="form-group">
            <div class="col-sm-4">
                <label class="checkbox">
                  <input type="checkbox" name="required"> 
                   <?=__('Required')?>
                </label>
            <div class="help-block"></div></div>
        </div>

        <div class="form-group">
            <div class="col-sm-4">
                <label class="checkbox">
                  <input type="checkbox" name="searchable"> 
                   <?=__('Searchable')?>
                </label>
            <div class="help-block"></div></div>
        </div>
      
      <div class="form-actions">
        <a href="<?=Route::url('oc-panel',array('controller'=>'fields','action'=>'index'))?>" class="btn btn-default"><?=__('Cancel')?></a>
        <button type="submit" class="btn btn-primary"><?=__('Create')?></button>
      </div>
</form>
