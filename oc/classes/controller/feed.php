<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Feed extends Controller {

	public function action_index()
	{
        $this->auto_render = FALSE;

		$info = array(
						'title' 	=> 'RSS '.Core::config('general.site_name'),
						'pubDate' => date("D, d M Y H:i:s T"),
						'description' => __('Latest published'),
						'generator' 	=> 'Open Classifieds',
		); 
  		
  		$items = array();

  		//last ads, you can modify this value at: general.feed_elements
		$ads = DB::select('a.seotitle')
                ->select(
			array('c.seoname','category'),
			'a.id_ad',
			'a.title','a.description','a.published','a.address','a.price','a.phone','a.website')
                ->from(array('ads', 'a'))
                ->join(array('categories', 'c'),'INNER')
                ->on('a.id_category','=','c.id_category')
                ->where('a.status','=',Model_Ad::STATUS_PUBLISHED)
                ->order_by('published','desc')
                ->limit(Core::config('general.feed_elements'));

        //filter by category aor location
        if (Controller::$category!==NULL)
        {
            if (Controller::$category->loaded()) 
                $ads->where('a.id_category','=',Controller::$category->id_category);
        }

        if (Controller::$location!==NULL)
        {
            if (Controller::$location->loaded())
                $ads->where('a.id_location','=',Controller::$location->id_location);
        }

        $ads = $ads->as_object()->cached()->execute();

        foreach($ads as $a)
        {
            $url= Route::url('ad',  array('category'=>$a->category,'seotitle'=>$a->seotitle));
	    // This is idiotic
	    $feed_entry = array(
	    	'id' => $a->id_ad,
               	'title' 	    => preg_replace('/&(?!\w+;)/', '&amp;', $a->title),
              	'link' 	        => $url,
               	'pubDate'       => Date::mysql2unix($a->published),
//               	'description'   => Text::removebbcode(preg_replace('/&(?!\w+;)/', '&amp;',$a->description)),
               	'description'   => preg_replace('/&(?!\w+;)/', '&amp;',$a->description),
		'category' => $a->category,
		'address' => $a->address,
		'website' => $a->website,
		'phone' => $a->phone,
		'price' => $a->price
		);
    	    $ad_obj = new Model_Ad($a->id_ad);
	    $cc =   $ad_obj->custom_columns();
	    foreach ($cc as $k=>$v) {
	       if ($v['value']) {
        	       $feed_entry[$k] = $v['value'];
	       }
            } 
//	    define('QR_DIR', ROOT.'qrs/');
	    $cur_qr_dir = QR_DIR.$a->id_ad;
	    if (is_dir($cur_qr_dir)) {
   	       $qr_dir = opendir($cur_qr_dir);
	       $qrs = array();
	        $qr_url = "http://".$_SERVER['HTTP_HOST']."/qrs/".$a->id_ad."/";
	        if ($qr_dir) {
	           while (($file = readdir($qr_dir)) !== false) {
                      if ($file == "." || $file == "..") {
                          continue;
                      }                      
                      $type = str_replace($a->id_ad."_", "", $file);
		      $type = str_replace(".png","",$type);
                      $feed_entry['qr_'.$type] = $qr_url.$file;
		   }
	        }


            }
	    $imgs = $ad_obj->get_images();
            $img_cnt = 0;
	    foreach ($imgs as $img) {
	       $dir = $img['image'];
	       $url = 'http://'.$_SERVER['HTTP_HOST']."/".$dir;
	       $img_key = 'image'.$img_cnt;
	       $feed_entry[$img_key] = trim($url);
	       $img_cnt++;	       
            }

            $items[] = $feed_entry;
        }
  	
  		$xml = Feed::create($info, $items);

		$this->response->headers('Content-type','text/xml');
        $this->response->body($xml);
	
	}


    public function action_blog()
    {
        $this->auto_render = FALSE;

        $info = array(
                        'title'     => 'RSS Blog '.Core::config('general.site_name'),
                        'pubDate' => date("D, d M Y H:i:s T"),
                        'description' => __('Latest post published'),
                        'generator'     => 'Open Classifieds',
        ); 
        
        $items = array();

        $posts = new Model_Post();
        $posts = $posts->where('status','=', 1)
                ->order_by('created','desc')
                ->limit(Core::config('general.feed_elements'))
                ->cached()
                ->find_all();
           

        foreach($posts as $post)
        {
            $url= Route::url('blog',  array('seotitle'=>$post->seotitle));

            $items[] = array(
                                'title'         => preg_replace('/&(?!\w+;)/', '&amp;', $post->title),
                                'link'          => $url,
                                'pubDate'       => Date::mysql2unix($post->created),
                                'description'   => Text::removebbcode(preg_replace('/&(?!\w+;)/', '&amp;',$post->description)),
                          );
        }
  
        $xml = Feed::create($info, $items);

        $this->response->headers('Content-type','text/xml');
        $this->response->body($xml);
    
    }


    public function action_info()
    {

        //try to get the info from the cache
        $info = Core::cache('action_info',NULL);

        //not cached :(
        if ($info === NULL)
        {
            $ads = new Model_Ad();
            $total_ads = $ads->count_all();

            $last_ad = $ads->select('published')->order_by('published','desc')->limit(1)->find();
            $last_ad = $last_ad->published;

            $ads = new Model_Ad();
            $first_ad = $ads->select('published')->order_by('published','asc')->limit(1)->find();
            $first_ad = $first_ad->published;

            $views = new Model_Visit();
            $total_views = $views->count_all();

            $users = new Model_User();
            $total_users = $users->count_all();

            $info = array(
                            'site_name'     => Core::config('general.site_name'),
                            'site_url'      => Core::config('general.base_url'),
                            'created'       => $first_ad,   
                            'updated'       => $last_ad,   
                            'email'         => Core::config('email.notify_email'),
                            'version'       => Core::version,
                            'theme'         => Core::config('appearance.theme'),
                            'theme_mobile'  => Core::config('appearance.theme_mobile'),
                            'charset'       => Kohana::$charset,
                            'timezone'      => Core::config('i18n.timezone'),
                            'locale'        => Core::config('i18n.locale'),
                            'currency'      => '',
                            'ads'           => $total_ads,
                            'views'         => $total_views,
                            'users'         => $total_users,
            );

            Core::cache('action_info',$info);
        }
       

        $this->response->headers('Content-type','application/javascript');
        $this->response->body(json_encode($info));

    }


    /**
     * after does nothing since we send an XML
     */
    public function after(){}


} // End feed
