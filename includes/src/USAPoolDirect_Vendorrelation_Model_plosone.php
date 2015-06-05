<?php

class PlosonController extends \BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	public function getIndex()//site_id in argument
	{	
		//include magpierss for parse rss page
		require __DIR__.'/magpierss/rss_fetch.inc';
		 error_reporting(E_ERROR);
		 
		$site_array = array();
		$url_array = array();
		$array_url = array();
		$rss_data = array();
		$arr_url  = array();
		$site_id = '';
		$first_url_id = '';
		$first_url_rss = '';
		$url ='';
		$updatae_flag = '0';
		$array_rss_url_ids = array(); //to make delete array
		//get all rss urls from sites
		$sites = Site::all(array('id','rss'));		//echo $sites; exit;	
		//decode the result 
		$site_array = json_decode($sites);
		echo "<pre>"; print_r($site_array); //exit;	
		
		//get all rss_urls 
		$rss_url = RssUrl::all(array('id','url'));		//echo $sites; exit;
		//decode the result 
		$url_array = json_decode($rss_url);
		foreach($url_array as $value){
			$array_url[] = $value->url;
			$array_rss_url_ids[] = $value->id;
		}
		echo "<hr><pre>"; print_r($array_url);print_r($array_rss_url_ids); //exit;	
		
		if(isset($site_array) && !empty($site_array))
		{
			foreach($site_array as $site_value)
			{	
				//get site id of rss 
				if($site_value->rss != '' && !in_array($site_value->rss, $array_url))
				{ 
					$site_id = $site_value->id;
					$url = $site_value->rss;
					break;
				}
				elseif($site_value->rss != '' && $first_url_id =='')
				{
					$first_url_id = $site_value->id;
					$first_url_rss = $site_value->rss;
				}
				else{}
			}
			//echo "siteid=".$site_id." <hr> ".$url." <hr>";echo "<br/><hr>".$first_url_id." <hr>1strss ".$first_url_rss."<br/> ".$updatae_flag;
			if($site_id == ''){$site_id = $first_url_id;  $url = $first_url_rss; $updatae_flag = '1'; }
		}
		echo "siteid=".$site_id."  ".$url." ";echo "<br/>".$first_url_id."  ".$first_url_rss."<br/>updateflage ".$updatae_flag."<hr><hr>";
		//exit;
		
		$rss = new \rss();		//echo "<pre>"; print_r($rss); exit;
		$col = array('url');
		
		$site = Rss::all($col);
		if(isset($site) && !empty($site))
		{
			$url_arr = json_decode($site);
			foreach($url_arr as $value){$arr_url[] = $value->url;}
		}
		echo "url arr<pre>";	print_r($arr_url); 	// exit;	
		
		
		//get the row as per site id 
		//$siteTypes = Site::find($site_id);		//echo $siteTypes; exit;	//site_id in argumen
		
		//decode the result 
		//$site_array = json_decode($siteTypes);
		//echo "<pre>";		print_r($site_array); exit;
		
		//$site_id = $site_array->id;
		if($site_id != '' && $url !='')
		{
			$created_at = date('Y-m-d H:i:s');
			//parse the rss
			//$url = $site_array->rss;
			$rss = fetch_rss($url);
			if($rss)
			{
				//echo "<pre>";print_r($rss); exit;	
		
				$index = 0;
				foreach ($rss->items as $item ) {
					
					if(!in_array($item['link'], $arr_url))
					{
						$description = '';
						if(isset($item['description'])){$description  = ($item['description']);}
						$rss_data[$index] = array(
										  'site_id'     => $site_id,
										  'title'       => ($item['title']),
										  'url'         => ($item['link']),
										  'description' => ($description),
										  'status'      => '0',
										  'created_at'  => $created_at
										  );
						$index++;
					}
				}
			}//end of rss if
			
			//echo "<li><a href=$url>".$rss_data[$index]['title']."</a><br>".$rss_data[$index]['description']."</li><br>";
						
		}
		echo "<hr><hr>Rss data<pre>"; print_r($rss_data); //exit;
		//$updatae_flag = '1';
		//if there is no record mathch
		if($updatae_flag == '1')
		{
			$rss_url = new \RssUrl();//echo "<pre>"; print_r($rss_url); exit;
			$site = $rss_url->destroy($array_rss_url_ids);
			echo $site."asdfasf";
			//$rss_url = RssUrl::delete();
			echo "<pre>"; print_r($site); exit;
			
			//$rss_url->destroy();
			echo "deletesdfasdf"; exit;
		}
		elseif(!empty($rss_data))
		{
			$rss = new \rss();//echo "<pre>"; print_r($rss); exit;
			$rss->insert($rss_data);
			
			$rss_url_table = new \RssUrl();//echo "<pre>"; print_r($rss); exit;
			$rss_url_table->insert(array('url'=> $url));
			echo "successfull";exit;	
		}
		else{
			$rss_url_table = new \RssUrl();//echo "<pre>"; print_r($rss); exit;
			$rss_url_table->insert(array('url'=> $url));
		}
		//echo "asd<pre>"; print_r($rss_data); exit;
	
		/*$rss = fetch_rss($site_array->rss);	
		echo "<pre>";		print_r($rss); exit;*/
		//$article = Article::find(1);echo $article; 
		//$setting = Auth::user()->setting; echo $setting;
		echo "In ploson controller...."; exit;
		//return View::make('crawl');
		
	}
	
	public function getPlosone()
	{echo "hello..Plosone."; exit;
		return View::make('hello');
	}
	
	

}