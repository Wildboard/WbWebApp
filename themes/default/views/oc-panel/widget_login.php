<?php defined('SYSPATH') or die('No direct script access.');?>
<a class="btn btn-success navbar-btn"
	href="<?=Route::url('oc-panel',array('controller'=>'home','action'=>'index'))?>">
	<i class="glyphicon-user glyphicon"></i> 
</a>
<a class="btn dropdown-toggle btn-success navbar-btn"  data-toggle="dropdown"
	href="#"> <span class="caret"></span>
</a>

<ul class="dropdown-menu">
	
	<li><a href="<?=Route::url('oc-panel',array('controller'=>'home','action'=>'index'))?>">
        <i class="glyphicon glyphicon-cog"></i> <?=__('Panel')?></a></li>

    <li><a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'ads'))?>"><i
           class="glyphicon glyphicon-edit"></i> <?=__('My Advertisements')?></a></li>
	
	<li><a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'edit'))?>"><i
		   class="glyphicon glyphicon-lock"></i> <?=__('Edit profile')?></a></li>

    <li><a href="<?=Route::url('profile',array('seoname'=>Auth::instance()->get_user()->seoname))?>">
         <i class="glyphicon glyphicon-eye-open"></i> <?=__('Public profile')?></a></li>

	<li class="divider"></li>
	<li><a
		href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'logout'))?>">
			<i class="glyphicon glyphicon-off"></i> <?=__('Logout')?>
	</a></li>
    <li>
        <a
        href="<?=Route::url('default')?>">
            <i class="glyphicon glyphicon-home"></i> <?=__('Visit Site')?></a>
	</li>
</ul>
