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

Route::get('/widgets/{name}', function (string $name) {
    return view('widgets.' . $name);
});

Route::post('/save', function (Request $request) {
    $template           = new Templates;
    $template->version  = '1';
    $template->page     = 'toppage';
    $template->contents = json_encode($request->input('contents'));
    $template->save();

    return ['status' => 'ok!'];
});
