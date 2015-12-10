<?php defined('SYSPATH') or die('No direct script access.');?>
<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav">
    <div class="container">
        <div class="navbar-header">        </div> 

            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#mobile-menu-panel">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="<?=Route::url('oc-panel',array('controller'=>'home'))?>"><i class="glyphicon glyphicon-th-large"></i> <?=__('Panel')?></a>
            <div class="btn-group pull-right ml-20">
                <?=View::factory('oc-panel/widget_login')?>
            </div>

            <div class="navbar-collapse collapse" id="mobile-menu-panel">
                <ul class="nav navbar-nav">
                    <?=Theme::admin_link(__('Market'), 'market','index','oc-panel','glyphicon glyphicon-gift')?>
                    <? if(core::config('general.moderation') == 1 OR // moderation on  
                          core::config('general.moderation') == 4 OR // email confiramtion with moderation
                          core::config('general.moderation') == 5):  // payment with moderation?>
                    <?=Theme::admin_link(__('Moderation'),'ad','moderate','oc-panel','glyphicon glyphicon-ban-circle')?>
                    <? endif?>
                	<?=Theme::admin_link(__('Stats'),'stats','index','oc-panel','glyphicon glyphicon-align-left')?>
                    <?=Theme::admin_link(__('Widgets'),'widget','index','oc-panel','glyphicon glyphicon-move')?>
                    <?=Theme::admin_link(__('Cache'),'tools','cache','oc-panel','  glyphicon-cog glyphicon')?>
                    <? if(Auth::instance()->get_user()->id_role==Model_Role::ROLE_ADMIN):?>
            	    <li  class="dropdown ">
                        <a href="#" class="dropdown-toggle"
            		      data-toggle="dropdown"><i class="glyphicon glyphicon-plus"></i> <?=__('New')?> <b class="caret"></b></a>
                    	<ul class="dropdown-menu">
                            <?=Theme::admin_link(__('Bog post'),'blog','create')?>
                            <?=Theme::admin_link(__('Category'),'category','create')?>
                            <?=Theme::admin_link(__('Location'),'location','create')?>
                            <?=Theme::admin_link(__('Page'),'content','create')?>
                    		<li class="divider"></li>
                    		<li><a href="<?=Route::url('post_new')?>">
                    			<i class="glyphicon  glyphicon-pencil"></i> <?=__('Publish new')?></a>	</li>
                    	</ul>
            	   </li> 
                   <?else:?>
                    <li><a href="<?=Route::url('post_new')?>">
                                <i class="glyphicon glyphicon-pencil"></i> <?=__('Publish new')?></a>
                    </li>
                   <?endif?>
                </ul>
                <div class=""></div>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?=Route::url('default')?>">
                                <i class="  glyphicon-home glyphicon"></i>
                            <?=_('Visit Site')?>
                        </a>
                    </li>
                </ul>
            </div> <!--/.nav-collapse -->
    </div><!--/.container -->
</header><!--/.navbar -->
