<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller {

	public function action_index()
	{

	    //template header
	    $this->template->title            = '';
	    // $this->template->meta_keywords    = 'keywords';
	    $this->template->meta_description = Core::config('general.site_description');

	    //setting main view/template and render pages  

	    // swith to decide on ads_in_home
	    $ads = new Model_Ad();
        $ads->where('status','=', Model_Ad::STATUS_PUBLISHED);

        switch (core::config('advertisement.ads_in_home')) 
        {
            case 2:
                $id_ads = array_keys(Model_Visit::popular_ads());
                if (count($id_ads)>0)
                    $ads->where('id_ad','IN', $id_ads);
                
                break;
            case 1:
                $ads->where('featured','IS NOT', NULL)
                ->where('featured','BETWEEN', array(DB::expr('NOW()'), Date::unix2mysql(time() + (core::config('payment.featured_days') * 24 * 60 * 60))))
                ->order_by('featured','desc');
                break;
            case 0:
            default:
                $ads->order_by('published','desc');
                break;
        }

        //if ad have passed expiration time dont show 
        if(core::config('advertisement.expire_date') > 0)
        {
            $ads->where(DB::expr('DATE_ADD( published, INTERVAL '.core::config('advertisement.expire_date').' DAY)'), '>', DB::expr('NOW()'));
        }

        $ads = $ads->limit(Theme::get('num_home_latest_ads', 4))->cached()->find_all();

		$this->ads = $ads;

		$categs = Model_Category::get_category_count();
	
        $this->template->bind('content', $content);
        
        $this->template->content = View::factory('pages/home',array('ads'=>$ads, 
        															'categs'=>$categs,
        															));
		
	}

} // End Welcome
