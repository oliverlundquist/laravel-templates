<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use App\Templates;

Route::get('/', function (Request $request) {
    if (($templatePreviewId = $request->input('preview_template_id')) !== null) {
        return view('index', ['contents' => (new Templates)->where('id', $templatePreviewId)->value('contents')]);
    }
    return view('index', ['contents' => (new Templates)->where('active', 1)->value('contents')]);
});

Route::get('csrf', function () {
    return csrf_token();
});

Route::get('/templates', function () {
    return view('templates', ['contents' => (new Templates)->take(10)->get()]);
});

Route::get('/templates/{id}', function (string $id) {
    return (new Templates)->find($id);
});

Route::post('/templates/activate/{id}', function (string $id) {
    $templates = new Templates;
    $templates->where('active', 1)->update(['active' => 0]);
    $templates->where('id', $id)->update(['active' => 1]);
    return redirect('/templates');
});

Route::get('/editor/{id}', function () {
    return view('editor', ['contents' => (new Templates)->find('id')]);
});

Route::post('/widget', function (Request $request) {
    $instance  = str_random(8);
    $widget    = $request->input('widget');
    $version   = $request->input('version');
    $styles    = (bool) $request->input('styles');
    $settings  = (object) $request->input('settings', $default = []);
    $template  = (string) view('widgets.' . $widget . '-' . $version, compact('instance', 'widget', 'version', 'styles', 'settings'));

    return [
        'widget'   => $widget,
        'version'  => $version,
        'instance' => $instance,
        'content'  => $template
    ];
});

Route::post('/save', function (Request $request) {
    $template           = new Templates;
    $template->version  = '1.0';
    $template->page     = 'toppage';
    $template->contents = json_encode($request->input('contents'));
    $template->save();

    return ['status' => 'ok!'];
});
