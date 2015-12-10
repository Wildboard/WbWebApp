<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
	<h1><?=__('Custom Fields')?></h1>


    <?if (Theme::get('premium')!=1):?>
        <p class="well"><span class="label label-info"><?=__('Heads Up!')?></span> 
            <?=__('Custom fields are only available with premium themes!').'<br/>'.__('Upgrade your Open Classifieds site to activate this feature.')?>
            <a class="btn btn-success pull-right" href="<?=Route::url('oc-panel',array('controller'=>'theme'))?>"><?=__('Browse Themes')?></a>
        </p>
    <?endif?>

    <a target='_blank' href='http://open-classifieds.com/2013/10/11/how-to-create-custom-fields/'><?=__('Advertisement Custom Fields')?></a>
    <a class="btn btn-primary pull-right" href="<?=Route::url('oc-panel',array('controller'=>'fields','action'=>'new'))?>">
        <?=__('New field')?>
    </a>
</div>


<ol class='plholder col-md-6' id="ol_1" data-id="1">
<?if (is_array($fields)):?>
<?foreach($fields as $name=>$field):?>
    <li data-id="<?=$name?>" id="<?=$name?>"><i class="glyphicon   glyphicon-move"></i> 
        <?=$name?>        
        <span class="label label-info "><?=$field['type']?></span>

        <a data-text="<?=__('Are you sure you want to delete? All data contained in this field will be deleted.')?>" 
           data-id="li_<?=$name?>" 
           class="btn btn-xs btn-danger  pull-right"  
           href="<?=Route::url('oc-panel', array('controller'=> 'fields', 'action'=>'delete','id'=>$name))?>">
                    <i class="glyphicon   glyphicon-trash"></i>
        </a>

        <a class="btn btn-xs btn-primary pull-right" 
            href="<?=Route::url('oc-panel',array('controller'=>'fields','action'=>'update','id'=>$name))?>">
            <?=__('Edit')?>
        </a>
    </li>
<?endforeach?>
<?endif?>
</ol><!--ol_1-->

<span id='ajax_result' data-url='<?=Route::url('oc-panel',array('controller'=>'fields','action'=>'saveorder'))?>'></span>
<div class="clearfix"></div>


    <div class="page-header">
        <h1><?=__('Optional Fields')?></h1>
        <p><?=__('Optional Advertisement Fields')?></p>
    </div>
    <?= FORM::open(Route::url('oc-panel',array('controller'=>'settings', 'action'=>'form')).'?define=cf', array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'))?>
        <fieldset>
            <div class="form-group">
              <?= FORM::label('phone', __('Phone'), array('class'=>'control-label col-sm-2', 'for'=>'phone'))?>
              <div class="col-sm-4">
                
                <?= FORM::select('phone', array(FALSE=>"FALSE",TRUE=>"TRUE"),core::config('advertisement.phone'), array(
                'placeholder' => "", 
                'class' => 'tips form-control', 
                'id' => 'phone', 
                'data-content'=> __("Phone field"),
                'data-trigger'=>"hover",
                'data-placement'=>"right",
                'data-toggle'=>"popover",
                'data-original-title'=>__("Displays the field Phone in the Ad form."),
                ))?> 
              </div>
            </div>
            <div class="form-group">
            <?= FORM::label('website', __('Website'), array('class'=>'control-label col-sm-2', 'for'=>'website'))?>
            <div class="col-sm-4">
                
                <?= FORM::select('website', array(FALSE=>"FALSE",TRUE=>"TRUE"),core::config('advertisement.website'), array(
                'placeholder' => "http://foo.com/", 
                'class' => 'tips form-control', 
                'id' => 'website', 
                'data-content'=> __("Website field"),
                'data-trigger'=>"hover",
                'data-placement'=>"right",
                'data-toggle'=>"popover",
                'data-original-title'=>__("Displays the field Website in the Ad form."),
                ))?> 
              </div>
            </div>
            <div class="form-group">
              <?= FORM::label('location', __('Location'), array('class'=>'control-label col-sm-2', 'for'=>'location'))?>
              <div class="col-sm-4">
                
                <?= FORM::select('location',array(FALSE=>"FALSE",TRUE=>"TRUE"), core::config('advertisement.location'), array(
                'placeholder' => "", 
                'class' => 'tips form-control', 
                'id' => 'location', 
                'data-content'=> __("Displays location select"),
                'data-trigger'=>"hover",
                'data-placement'=>"right",
                'data-toggle'=>"popover",
                'data-original-title'=>__("Displays the Select Location in the Ad form."),
                ))?> 
              </div>
            </div>
            <div class="form-group">
              <?= FORM::label('price', __('Price'), array('class'=>'control-label col-sm-2', 'for'=>'price'))?>
              <div class="col-sm-4">
                
                <?= FORM::select('price', array(FALSE=>"FALSE",TRUE=>"TRUE"),core::config('advertisement.price'), array(
                'placeholder' => "", 
                'class' => 'tips form-control', 
                'id' => 'price', 
                'data-content'=> __("Price field"),
                'data-trigger'=>"hover",
                'data-placement'=>"right",
                'data-toggle'=>"popover",
                'data-original-title'=>__("Displays the field Price in the Ad form."),
                ))?> 
              </div>
            </div>
            <div class="form-group">
              <?= FORM::label('upload_file', __('Upload file'), array('class'=>'control-label col-sm-2', 'for'=>'upload_file'))?>
              <div class="col-sm-4">
                
                <?= FORM::select('upload_file',array(FALSE=>"FALSE",TRUE=>"TRUE"), core::config('advertisement.upload_file'), array(
                'placeholder' => "", 
                'class' => 'tips form-control', 
                'id' => 'upload_file', 
                ))?>
              </div>
            </div>
            <div class="form-group">
              <?= FORM::label('captcha', __('Captcha'), array('class'=>'control-label col-sm-2', 'for'=>'captcha'))?>
              <div class="col-sm-4">
                
                <?= FORM::select('captcha', array(FALSE=>"FALSE",TRUE=>"TRUE"), core::config('advertisement.captcha'), array(
                'placeholder' => "http://foo.com/", 
                'class' => 'tips form-control', 
                'id' => 'captcha', 
                'data-content'=> __("Enables Captcha"),
                'data-trigger'=>"hover",
                'data-placement'=>"right",
                'data-toggle'=>"popover",
                'data-original-title'=>__("Captcha appears in the form."),
                ))?> 
              </div>
            </div>
            <div class="form-group">
              <?= FORM::label('address', __('Address'), array('class'=>'control-label col-sm-2', 'for'=>'address'))?>
              <div class="col-sm-4">
                
                <?= FORM::select('address', array(FALSE=>"FALSE",TRUE=>"TRUE"),core::config('advertisement.address'), array(
                'placeholder' => "", 
                'class' => 'tips form-control', 
                'id' => 'address', 
                'data-content'=> __("Address field"),
                'data-trigger'=>"hover",
                'data-placement'=>"right",
                'data-toggle'=>"popover",
                'data-original-title'=>__("Displays the field Address in the Ad form."),
                ))?> 
              </div>
            </div>
            <div class="form-actions">
                <?= FORM::button('submit', 'Update', array('type'=>'submit', 'class'=>'btn btn-primary', 'action'=>Route::url('oc-panel',array('controller'=>'settings', 'action'=>'form')).'?define=cf'))?>
            </div>
      </fieldset>
    <?FORM::close()?>
