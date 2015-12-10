<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
    <h1><?=__('Locations')?></h1>
    <p><?=__("Change the order of your locations. Keep in mind that more than 2 levels nested probably won´t be displayed in the theme (it is not recommended).")?><a href="http://open-classifieds.com/2013/08/22/how-to-add-locations/" target="_blank"><?=__('Read more')?></a></p>
    <a class="btn btn-primary pull-right" href="<?=Route::url('oc-panel',array('controller'=>'location','action'=>'create'))?>">
  <?=__('New location')?></a>
</div>

<ol class='plholder col-md-8' id="ol_1" data-id="1">
<?=_('Home')?>
<?function lili($item, $key,$locs){?>

    <li data-id="<?=$key?>" id="li_<?=$key?>"><i class="glyphicon   glyphicon-move"></i> <?=$locs[$key]['name']?>
        
        <a data-text="<?=__('Are you sure you want to delete? We will move the siblings locations and ads to the parent of this location.')?>" 
           data-id="li_<?=$key?>" 
           class="btn btn-xs btn-danger  pull-right" 
           href="<?=Route::url('oc-panel', array('controller'=> 'location', 'action'=>'delete','id'=>$key))?>">
                    <i class="glyphicon   glyphicon-trash"></i>
        </a>

        <a class="btn btn-xs btn-primary pull-right" 
            href="<?=Route::url('oc-panel',array('controller'=>'location','action'=>'update','id'=>$key))?>">
            <?=__('Edit')?>
        </a>

        <ol data-id="<?=$key?>" id="ol_<?=$key?>">
            <? if (is_array($item)) array_walk($item, 'lili', $locs);?>
        </ol><!--ol_<?=$key?>-->

    </li><!--li_<?=$key?>-->

<?}array_walk($order, 'lili',$locs);?>
</ol><!--ol_1-->

<span id='ajax_result' data-url='<?=Route::url('oc-panel',array('controller'=>'location','action'=>'saveorder'))?>'></span>