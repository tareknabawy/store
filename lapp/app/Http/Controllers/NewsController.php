<?php
namespace App\Http\Controllers;

use App;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;

class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting
                    ->name] = $setting->value;
        }

        $this->ping_google = $settings['ping_google'];
        $this->news_base = $settings['news_base'];

        // Pass data to views
        View::share(['settings' => $settings]);
    }

    /** Index */
    public function index()
    {
        // List of news
        $news = News::orderBy('id', 'DESC')->paginate(10);

        // Return view
        return view('adminlte::news.index', compact('news'));
    }

    /** Create */
    public function create()
    {
        // Return view
        return view('adminlte::news.create');
    }

    /** Store */
    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required|max:255', 'description' => 'required|max:755', 'details' => 'required', 'image' => 'required']);

        $news = new News;
        $news->title = $request->get('title');
        $news->description = $request->get('description');
        $news->description = strip_tags($news->description);
        $news->details = $request->get('details');
        $news->slug = null;

        // Check if the picture has been uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/news/' . $filename);
            Image::make($image)->resize(770, 450)
                ->save($location);
            $news->image = $filename;
        }

        $news->save();
        $news->update(['title' => $news->title]);

        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->news_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Clear cache
        Cache::flush();

        // Redirect to news edit page
        return redirect()->route('news.edit', $news->id)
            ->with('success', __('admin.data_added'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve news details
        $news = News::find($id);

        // Return 404 page if news not found
        if ($news == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::news.edit', compact('news', 'id'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['title' => 'required|max:255', 'description' => 'required|max:755', 'details' => 'required']);

        // Retrieve news details
        $news = News::find($id);
        $news->title = $request->get('title');
        $news->description = $request->get('description');
        $news->description = strip_tags($news->description);
        $news->details = $request->get('details');

        // Check if the picture has been changed
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/news/' . $filename);
            Image::make($image)->resize(770, 450)
                ->save($location);
            $oldfilename = $news->image;
            $news->image = $filename;
            File::delete('images/news/' . $oldfilename); // Remove old image file

        }

        // Ping Google
        if ($news->isDirty() && $this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->news_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        $news->slug = null;
        $news->save();
        $news->update(['title' => $news->title]);

        // Clear cache
        Cache::flush();

        // Redirect to news edit page
        return redirect()
            ->route('news.edit', $news->id)
            ->with('success', __('admin.data_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {
        // Retrieve news details
        $news = News::find($id);

        $tagged = $news->tagged;
        $tags = $news->tags;
        $tags_slugs                 = $news->tags->where('count',1)->pluck('slug')->toArray();
        $tags_slugs_more_than1      = $news->tags->where('count','>',1);
        $tagging_tagged             = \App\TaggingTagged::whereIn('tag_slug',$tags_slugs)->delete();
        \App\TaggingTag::whereIn('id',$news->tags->where('count',1)->pluck('id')->toArray())->delete();
        foreach($tags_slugs_more_than1 as $reduced_tag){
            \App\TaggingTag::where('id',$reduced_tag->id)->update(['count'=>$reduced_tag->count-1]);
        }

        if (!empty($news->image)) {
            if (file_exists(public_path() . '/images/news/' . $news->image)) {
                unlink(public_path() . '/images/news/' . $news->image);
            }
        }

        $news->delete();

        // Clear cache
        Cache::flush();

        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->news_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Redirect to list of news
        return redirect()
            ->route('news.index')
            ->with('success', __('admin.data_deleted'));
    }

}
