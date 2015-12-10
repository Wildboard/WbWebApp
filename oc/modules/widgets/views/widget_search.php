<?php defined('SYSPATH') or die('No direct script access.');?>
<h3><?=$widget->text_title?></h3>
<div>
<?= FORM::open(Route::url('search'), array('class'=>'form-horizontal', 'method'=>'GET', 'action'=>'','enctype'=>'multipart/form-data'))?>
<!-- if categories on show selector of categories -->
    <div class="form-group">
        <div class="col-xs-10">  
            <?= FORM::label('advertisement', __('Advertisement Title'), array('class'=>'', 'for'=>'advertisement'))?>
            <input type="text" id="title" name="title" class="form-control" value="" placeholder="<?=__('Search')?>">
        </div>
    </div>
<?if($widget->advanced != FALSE):?>
    <?if($widget->cat_items !== NULL):?>
        <div class="form-group">
            
            <div class="col-xs-10">
                <?= FORM::label('category_widget_search', __('Categories'), array('class'=>'', 'for'=>'category_widget_search'))?>
                <select data-placeholder="<?=__('Categories')?>" name="category_widget_search" id="category_widget_search" class="form-control">
                <option></option>
                <?function lili_search($item, $key,$cats){?>
                <?if ( count($item)==0 AND $cats[$key]['id_category_parent'] != 1):?>
                <option value="<?=$cats[$key]['seoname']?>" data-id="<?=$cats[$key]['id']?>"><?=$cats[$key]['name']?></option>
                <?endif?>
                    <?if ($cats[$key]['id_category_parent'] == 1 OR count($item)>0):?>
                    <option value="<?=$key?>"> <?=$cats[$key]['name']?> </option>
                        <optgroup label="<?=$cats[$key]['name']?>">  
                        <? if (is_array($item)) array_walk($item, 'lili_search', $cats);?>
                        </optgroup>
                    <?endif?>
                <?}
                $cat_order = $widget->cat_order_items; 
                array_walk($cat_order , 'lili_search', $widget->cat_items);?>
                </select> 
            </div>
        </div>
    <?endif?>
<!-- end categories/ -->
<!-- locations -->
<?if($widget->loc_items !== NULL):?>
    <?if(count($widget->loc_items) > 1 AND core::config('advertisement.location') != FALSE):?>
        <div class="form-group">
            <div class="col-xs-10">
                <?= FORM::label('location_widget_search', __('Locations'), array('class'=>'', 'for'=>'location_widget_search' ))?>
                <select data-placeholder="<?=__('Locations')?>" name="location_widget_search" id="location_widget_search" class="form-control">
                <option></option>
                <?function lolo_search($item, $key,$locs){?>
                <option value="<?=$locs[$key]['seoname']?>"><?=$locs[$key]['name']?></option>
                    <?if (count($item)>0):?>
                    <optgroup label="<?=$locs[$key]['name']?>">    
                        <? if (is_array($item)) array_walk($item, 'lolo_search', $locs);?>
                        </optgroup>
                    <?endif?>
                <?}
                $loc_order_search = $widget->loc_order_items; 
                array_walk($loc_order_search , 'lolo_search',$widget->loc_items);?>
                </select>
            </div>
        </div>
    <?endif?>
<?endif?>

    <?if(core::config('advertisement.price')):?>
        <div class="form-group">
             
            <div class="col-xs-10"> 
                <label class="" for="price-min"><?=__('Price from')?> </label>
                <input type="text" id="price-min" name="price-min" class="form-control" value="<?=core::get('price-min')?>" placeholder="<?=__('Price from')?>">
            </div>
        </div>

        <div class="form-group">
            
            <div class="col-xs-10">
                <label class="" for="price-max"><?=__('Price to')?></label>
                <input type="text" id="price-max" name="price-max" class="form-control" value="<?=core::get('price-max')?>" placeholder="<?=__('to')?>">
            </div>
        </div>
    <?endif?>
<?endif?>
<!-- Fields coming from custom fields feature -->

<?if($widget->custom != FALSE AND Theme::get('premium')==1):?>
    
        <?if (is_array($widget->custom_fields)):?>
            <?$i=0; foreach($widget->custom_fields as $name=>$field):?>
            <div class="pull-left mr-30">
                <?if($field['searchable']):?>
                    <?if($field['type'] == 'select' OR $field['type'] == 'radio') {
                        $select = array(''=>'');
                        foreach ($field['values'] as $select_name) {
                            $select[$select_name] = $select_name;
                        }
                    }?>
                    <?if($field['type'] == 'checkbox' OR $field['type'] == 'radio'):?><div class="mt-10"></div><?endif?>
                        <?=Form::cf_form_tag('cf_'.$name, array(    
                            'display'   => $field['type'],
                            'label'     => $field['label'],
                            'tooltip'   => (isset($field['tooltip']))? $field['tooltip'] : "",
                            'options'   => (!is_array($field['values']))? $field['values'] : $select,
                            ),NULL,TRUE,TRUE)?>
                            <div class="clear"></div> 
                <?endif?>
                </div>
            <?$i++ ;endforeach?>
        <?endif?>
    
<?endif?>
<!-- /endcustom fields -->
<div class="clearfix"></div>
<div class="page-header"></div>
    <?= FORM::button('submit', __('Search'), array('type'=>'submit', 'class'=>'btn btn-primary', 'action'=>Route::url('search')))?> 
<?= FORM::close()?>
</div>