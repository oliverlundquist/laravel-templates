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

Route::get('/', function () {
    return view('index', ['contents' => (new Templates)
                ->where('active', 1)->where('page', 'toppage')->orderBy('updated_at', 'desc')->value('contents')]);
});

Route::get('/editor', function () {
    return view('editor');
});

Route::get('/widgets/{name}', function (string $name) {
    return view('widgets.' . $name);
});

Route::post('/save', function (Request $request) {
    $template           = new Templates;
    $template->version  = '1.0';
    $template->page     = 'toppage';
    $template->contents = json_encode($request->input('contents'));
    $template->save();

    return ['status' => 'ok!'];
});
