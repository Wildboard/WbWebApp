<?php defined('SYSPATH') or die('No direct script access.');?>
<?=Form::errors()?>
<div class="well recomentadion clearfix">
    <?= FORM::open(Route::url('search'), array('class'=>'form-inline', 'method'=>'GET', 'action'=>''))?>
        <fieldset>
         
                <div class="form-group">
                <?= FORM::label('advertisement', __('Advertisement Title'), array('class'=>'', 'for'=>'advertisement'))?>
                <div class="control mr-30">
                    <input type="text" id="title" name="title" class="form-control" value="<?=core::get('title')?>" placeholder="<?=__('Title')?>">
                </div>
                </div>

                <div class="form-group">
                <?= FORM::label('category', __('Category'), array('class'=>'', 'for'=>'category' ))?>
                    <div class="control mr-30">
                        <select name="category" id="category" class="form-control disable-chosen" value="<?=core::get('category')?>" data-placeholder="<?=__('Category')?>">
                        <option></option>
                        <?function lili($item, $key,$cats){?>
                        <option value="<?=$cats[$key]['seoname']?>" data-id="<?=$cats[$key]['id']?>"><?=$cats[$key]['name']?></option>
                            <?if (count($item)>0):?>
                            <optgroup label="<?=$cats[$key]['name']?>">    
                                <? if (is_array($item)) array_walk($item, 'lili', $cats);?>
                                </optgroup>
                            <?endif?>
                        <?}array_walk($order_categories, 'lili',$categories);?>
                        </select>
                    </div>
                </div>

                <?if(core::config('advertisement.location') != FALSE AND count($locations) > 1):?>
                    <div class="form-group">
                        <?= FORM::label('location', __('Location'), array('class'=>'', 'for'=>'location' , 'multiple'))?>        
                        <div class="control mr-30">
                            <select name="location" id="location" class="form-control" data-placeholder="<?=__('Location')?>">
                            <option></option>
                            <?function lolo($item, $key,$locs){?>
                            <option value="<?=$locs[$key]['seoname']?>"><?=$locs[$key]['name']?></option>
                                <?if (count($item)>0):?>
                                <optgroup label="<?=$locs[$key]['name']?>">    
                                    <? if (is_array($item)) array_walk($item, 'lolo', $locs);?>
                                    </optgroup>
                                <?endif?>
                            <?}array_walk($order_locations, 'lolo',$locations);?>
                            </select>
                        </div>
                    </div>
                <?endif?>
            	
            	<?if(core::config('advertisement.price')):?>
                <div class="form-group">
                    <label class="" for="price-min"><?=__('Price from')?> </label> 
                    <div class="control mr-30"> 
                        <input type="text" id="price-min" name="price-min" class="form-control" value="<?=core::get('price-min')?>" placeholder="<?=__('Price from')?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="" for="price-max"><?=__('Price to')?></label>
                    <div class="control mr-30">
                        <input type="text" id="price-max" name="price-max" class="form-control" value="<?=core::get('price-max')?>" placeholder="<?=__('to')?>">
                    </div>
                </div>
                <?endif?>
            <div class="clear"></div> 
            <?= FORM::button('submit', __('Search'), array('type'=>'submit', 'class'=>'btn btn-primary pull-right', 'action'=>Route::url('search')))?> 
    </fieldset>
    <?= FORM::close()?>
</div>

<?if (count($ads)>0):?>
    <h3><?=__('Search results')?></h3>
    <?=View::factory('pages/ad/listing',array('pagination'=>$pagination,'ads'=>$ads,'category'=>NULL, 'location'=>NULL, 'user'=>$user))?>
<?endif?>