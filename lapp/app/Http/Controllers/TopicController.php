<?php
namespace App\Http\Controllers;

use App;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;

class TopicController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // List of Topics
        $topics = Topic::orderBy('id', 'DESC')->paginate(15);

        // List of applications
        $apps = DB::table('applications')->orderBy('title', 'asc')
            ->get();

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting
                    ->name] = $setting->value;
        }

        $this->ping_google = $settings['ping_google'];
        $this->topic_base = $settings['topic_base'];

        // Pass data to views
        View::share(['topics' => $topics, 'apps' => $apps, 'settings' => $settings]);
    }

    /** Index */
    public function index()
    {
        // Return view
        return view('adminlte::topics.index');
    }

    /** Create */
    public function create()
    {
        // Return view
        return view('adminlte::topics.create');
    }

    /** Store */
    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required|max:255', 'image' => 'required']);

        $topic = new Topic;

        // Check if the picture has been uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/topics/' . $filename);
            Image::make($image)->resize(770, 376)
                ->save($location);
            $topic->image = $filename;
        }

        $topic->slug = null;
        $topic->title = $request->get('title');
        $topic->description = $request->get('description');

        // Fix the empty paragraph problem that caused by the text editor
        if ($topic->description == '<br>' || $topic->description == '<p><br></p>') {
            $topic->description = null;
        }

        $topic->save();

        $topic->update(['title' => $topic->title]);

        DB::table('topic_items')
            ->insert(['list_id' => $topic->id]);

        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->topic_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Clear cache
        Cache::flush();

        // Redirect to topic edit page
        return redirect()->route('topics.edit', $topic->id)
            ->with('success', __('admin.data_added') . ". <a href=\"/admin/topic/$topic->id\">" . __('admin.view_apps_under_topic') . "</a>");
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve topic details
        $topic = Topic::find($id);

        // Return 404 page if topic not found
        if ($topic == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::topics.edit', compact('topic', 'id'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['title' => 'required|max:255']);

        // Retrieve topic details
        $topic = Topic::find($id);

        $topic->title = $request->get('title');
        $topic->description = $request->get('description');

        // Fix the empty paragraph problem that caused by the text editor
        if ($topic->description == '<br>' || $topic->description == '<p><br></p>') {
            $topic->description = null;
        }

        // Check if the picture has been changed
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/topics/' . $filename);
            Image::make($image)->resize(770, 376)
                ->save($location);
            $oldfilename = $topic->image;
            $topic->image = $filename;
            File::delete('images/topics/' . $oldfilename); // Remove old image file

        }

        // Ping Google
        if ($topic->isDirty() && $this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->topic_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        $topic->slug = null;
        $topic->save();
        $topic->update(['title' => $topic->title]);

        // Clear cache
        Cache::flush();

        // Redirect to topic edit page
        return redirect()
            ->route('topics.edit', $topic->id)
            ->with('success', __('admin.data_updated') . ". <a href=\"/admin/topic/$topic->id\">" . __('admin.view_apps_under_topic') . "</a>");
    }

    /** Details */
    public function details(Request $request)
    {
        $request_type = $request->get('request');

        if ($request_type == '1') {
            $search_term = $request->get('search');

            // List of applications
            $apps = DB::table('applications')->orderBy('id', 'desc')->where('title', 'like', "%{$search_term}%")->get();

            foreach ($apps as $row) {
                $response[] = array("value" => $row->id, "label" => $row->title);
            }

            echo json_encode($response);
        }

        if ($request_type == '2') {
            $app_id = $request->get('app_id');

            // Get app details
            $app = DB::table('applications')->where('id', $app_id)->first();

            if (empty($app->image)) {
                $app->image = 'no_image.png';
            }

            $response[] = array("id" => $app->id, "name" => $app->title, "image" => $app->image);

            echo json_encode($response);
        }

    }

    /** Destroy */
    public function destroy($id)
    {
        // Retrieve topic details
        $topic = Topic::find($id);

        if (!empty($topic->image)) {
            if (file_exists(public_path() . '/images/topics/' . $topic->image)) {
                unlink(public_path() . '/images/topics/' . $topic->image);
            }
        }

        $topic->delete();

        DB::delete('delete from topic_items where list_id = ?', [$id]);

        // Clear cache
        Cache::flush();

        // Ping Google
        if ($this->ping_google == '1') {
            $sitemap_url = asset('sitemap/' . $this->topic_base);
            $ch = curl_init("https://www.google.com/webmasters/tools/ping?sitemap=$sitemap_url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        // Redirect to list of topics
        return redirect()
            ->route('topics.index')
            ->with('success', __('admin.data_deleted'));
    }

}
