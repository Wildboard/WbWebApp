<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="col-md-3 hidden-phone">
	<div class="well sidebar-nav">
        <button type="button" class="btn btn-default btn-sidebar-menu">
                <span class="glyphicon glyphicon-align-justify"></span>
        </button>
		<ul class="nav nav-list">
                
				<?//Theme::admin_link(__('Market'), 'market','index','oc-panel','glyphicon glyphicon-gift')?>
                <?Theme::admin_link(__('Advertisements'),'ad','index','oc-panel','glyphicon glyphicon-th-large')?>
                <? if(core::config('general.moderation') == 1 OR // moderation on  
                      core::config('general.moderation') == 4 OR // email confiramtion with moderation
                      core::config('general.moderation') == 5):  // payment with moderation?>
				<?Theme::admin_link(__('Moderation'),'ad','moderate','oc-panel','glyphicon glyphicon-ban-circle')?>
                <? endif?>
				<?Theme::admin_link(__('Categories'),'category','index','oc-panel','glyphicon  glyphicon-tags')?>
				<?Theme::admin_link(__('Locations'),'location','index','oc-panel','glyphicon  glyphicon-map-marker')?>
				<?Theme::admin_link(__('Orders'), 'order','index','oc-panel','glyphicon  glyphicon-shopping-cart')?>
                <? if($user->id_role==Model_Role::ROLE_ADMIN):?><div class="divider"></div><?endif?>
                <?if (core::config('general.blog')==1):?>
                    <?Theme::admin_link(__('Blog'), 'blog','index','oc-panel','glyphicon  glyphicon-pencil')?>
                <?endif?>
                <?Theme::admin_link(__('Page'), 'content','list?type=page&locale_select='.core::config('i18n.locale'),'oc-panel','glyphicon  glyphicon-file')?>
                <?Theme::admin_link(__('Email'), 'content','list?type=email&locale_select='.core::config('i18n.locale'),'oc-panel','glyphicon  glyphicon-envelope')?>
                <?Theme::admin_link(__('Translations'), 'translations','index','oc-panel','glyphicon  glyphicon-globe')?>
                <?Theme::admin_link(__('Newsletters'), 'newsletter','index','oc-panel','glyphicon  glyphicon-envelope')?>

                <? if($user->id_role==Model_Role::ROLE_ADMIN):?><div class="divider"></div><?endif?>

                <?Theme::admin_link(__('Themes'), 'theme','index','oc-panel','glyphicon  glyphicon-picture')?>
                <?if (Theme::has_options()) 
                        Theme::admin_link(__('Theme Options'), 'theme','options','oc-panel','glyphicon  glyphicon-wrench')?>     
                <?Theme::admin_link(__('Widgets'), 'widget','index','oc-panel','glyphicon glyphicon-move')?>   
                <?Theme::admin_link(__('Menu'), 'menu','index','oc-panel','glyphicon  glyphicon-list')?> 
                <?Theme::admin_link(__('Custom Fields'), 'fields','index','oc-panel','glyphicon  glyphicon-plus-sign')?>
                <?Theme::admin_link(__('Social Auth'), 'social','index','oc-panel','glyphicon  glyphicon-thumbs-up')?>
                <? if($user->id_role==Model_Role::ROLE_ADMIN):?><div class="divider"></div><?endif?>

			<?if ($user->has_access_to_any('settings,config')):?>
				<li class="dropdown-sidebar sbp <?=(in_array(Request::current()->controller(),array('settings','config'))) ?'active':''?>">
                <a class="dropdown-toggle"><i class="glyphicon glyphicon-edit"></i><?=__('Settings')?><i class="glyphicon glyphicon-chevron-down pull-right"></i></a>
                    <ul class="submenu">
    				    <?Theme::admin_link(__('General'), 'settings','general')?>
    				    <?Theme::admin_link(__('Payment'), 'settings','payment')?>
    				    <?Theme::admin_link(__('Email'), 'settings','email')?>
    				    <?Theme::admin_link(__('Advertisement'), 'settings','form')?>
                    </ul>
                </li>
			<?endif?>

            <?if ($user->has_access_to_any('user,role,access')):?>
                <li class="dropdown-sidebar sbp <?=(in_array(Request::current()->controller(),array('user','role','access'))) ?'active':''?>">
                <a class="dropdown-toggle"><i class="glyphicon glyphicon-user"></i><?=__('Users')?><i class="glyphicon glyphicon-chevron-down pull-right"></i></a>
                    <ul class="submenu">
                      <?Theme::admin_link(__('Users'),'user')?>
                      <?Theme::admin_link(__('User Roles'),'role')?>
                      <?Theme::admin_link(__('Roles access'),'access')?>
                    </ul>
                </li>
            <? endif ?>

			<?if ($user->has_access_to_any('tools')):?>
				<li class="dropdown-sidebar sbp <?=(Request::current()->controller()=='tools') ?'active':''?>">
                <a class="dropdown-toggle"><i class="glyphicon glyphicon-wrench"></i><?=__('Tools')?><i class="glyphicon glyphicon-chevron-down pull-right"></i></a>
                    <ul class="submenu">
                        <?Theme::admin_link(__('Updates'), 'update','index')?>
                        <?Theme::admin_link(__('Sitemap'), 'tools','sitemap')?>
                        <?Theme::admin_link(__('Migration'), 'tools','migration')?>
                        <?Theme::admin_link(__('Optimize'), 'tools','optimize')?>
                        <?Theme::admin_link(__('Cache'), 'tools','cache')?>
                        <?Theme::admin_link(__('Logs'), 'tools','logs')?>
                        <?Theme::admin_link(__('PHP Info'), 'tools','phpinfo')?>
                    </ul>
                </li>
			<?endif?>

			<? if($user->has_access_to_any('profile') AND $user->id_role!=Model_Role::ROLE_ADMIN):?><div class="divider"></div>
				<li class="nav-header"><i class="glyphicon glyphicon-user"></i><?=__('Profile')?></li>
				<?Theme::admin_link(__('Edit profile'), 'profile','edit')?>
                <?Theme::admin_link(__('My Advertisements'), 'profile','ads')?>
                <?Theme::admin_link(__('Stats'),'profile','stats')?>
                <?Theme::admin_link(__('Subscriptions'),'profile','subscriptions')?>
				<li><a
					href="<?=Route::url('profile',array('seoname'=>$user->seoname))?>">
					<?=__('Public profile')?>
				</a>
				</li>
			<?endif?>
            <div class="divider"></div>
			<?if (Theme::get('premium')!=1):?>
    			<li><a href="http://open-classifieds.com/?utm_source=<?=URL::base()?>&utm_medium=oc_sidebar&utm_campaign=<?=date('Y-m-d')?>">Open Classifieds</a></li>   
    			<li class="ml-10"><script type="text/javascript">if (typeof geoip_city!="function")document.write("<scr"+"ipt type=\"text/javascript\" src=\"http://j.maxmind.com/app/geoip.js\"></scr"+"ipt>");
                    document.write("<scr"+"ipt type=\"text/javascript\" src=\"http://api.adserum.com/sync.js?a=6&f=3&w=200&h=200\"></scr"+"ipt>");
                    </script>
                </li>
    			
                <li class="ml-10"><a href="https://twitter.com/openclassifieds"
                    onclick="javascript:_gaq.push(['_trackEvent','outbound-widget','http://twitter.com']);"
                    class="twitter-follow-button" data-show-count="false"
                    data-size="large">Follow @openclassifieds</a><br />
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></li>
			<?endif?>
		</ul>
        
	</div>
	<!--/.well -->
</div>
<!--/span-->
