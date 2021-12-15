<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
class SiteMapController extends Controller
{
    public $items_per_page = 100 ;
    public $data;
	
    public function __construct($foo = null)
    {
        $this->data= collect([
            [
                'name'=>"apps",
                'index_route_name'=>"apps.index",
                'show_route_name'=>"app.show",
                'data'=>\App\Application::query(),
            ],
            [
                'name'=>"pages",
                'index_route_name'=>"pages.index",
                'show_route_name'=>"page.show",
                'data'=>\App\Page::query(),
            ],
            [
                'name'=>"categories",
                'index_route_name'=>"categories.index",
                'show_route_name'=>"category.show",
                'data'=>\App\Category::query(),
            ],
            [
                'name'=>"platforms",
                'index_route_name'=>"platforms.index",
                'show_route_name'=>"platform.show",
                'data'=>\App\Platform::query(),
            ],
            [
                'name'=>"topics",
                'index_route_name'=>"topics.index",
                'show_route_name'=>"topic.show",
                'data'=>\App\Topic::query(),
            ],
            [
                'name'=>"news",
                'index_route_name'=>"news.index",
                'show_route_name'=>"news.show",
                'data'=>\App\News::query(),
            ],
            [
                'name'=>"topicitems",
                'index_route_name'=>"topicitems.index",
                'show_route_name'=>"topicitem.show",
                'data'=>\App\TopicItem::query(),
            ],
            
        ]);
    }
    public function sitemap_init(Request $request){
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 2021 05:00:00 GMT");
    }
    public function viewer(Request $request,$name,$page){
        $request->merge([
            'name'=>$name,
            'page'=>$page
        ]);
		
		
        $request->validate([
            'name'=>'required|in:'.implode(',',$this->data->pluck('name')->toArray()),
            'page'=>'required|integer|min:0,max:10000'
    ]);
        $urls  = [];
        $items = $this->data->where('name',$request->name)->first()['data']->paginate($this->items_per_page);
        $route = $this->data->where('name',$request->name)->first()['show_route_name'];
		
    foreach($items as $item){
			
			 /** Sitemap link pages, application, news,*/
			 
            
			
	$url='<url>
		<loc>'.route($route,$item->slug).'</loc>
		<lastmod>'.gmdate(DateTime::W3C, strtotime($item->updated_at)).'</lastmod>';

    if(isset($item->image) && $item->image!=null)
        $url.='<image:image>
            <image:loc>'.env('APP_URL').'/images/'.$item->image.'</image:loc>
            <image:title>'.$item->slug.'</image:title>
            <image:caption>'.$item->slug.'</image:caption>
        </image:image>';

	$url.='</url>';
			
			
			
    array_push($urls,$url);
        } 
        $urls=implode( '',$urls);
        return response('<urlset
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" 
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd"
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        >'.$urls.'</urlset>', 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
	
	 /** Sitemap link categories*/
	
	
    public function generator($items=[]){
        $urls=[];
        foreach($items as $item){
            for($i=0; $i< ceil($item['data']->count()/$this->items_per_page);$i++ ){
				
				
				 
                $url='<sitemap><loc>'.env("APP_URL").'/sitemaps/'.$item['name'].'/'.$i.'/sitemap.xml</loc></sitemap>';
				
				
                array_push($urls,$url);
            }
        }
        $urls=implode('',$urls);
        return response('<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$urls.'</sitemapindex>', 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
    public function sitemap(Request $request)
    {
        $this->sitemap_init($request);
        if(count($this->data))
            return $this->generator($this->data);

    }
}
