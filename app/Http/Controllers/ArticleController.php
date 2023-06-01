<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return view('article.index', [
            'articles' => Article::get(),
        ]);
    }

    public function create()
    {
        return view('article.form');
    }

    public function store(Request $request)
    {
        $inputs = $request->only(['title', 'description']);
        $create = Article::create($inputs);

        if ($create) {
            session()->flash('notif.success', 'Article created successfully!');
            return redirect()->route('article.index');
        }

        return abort(500);
    }

    public function edit($id) {
        $article = Article::find($id);
        return view('article.form', [
            'article' => $article
        ]);
    }

    public function update(Request $request, $id) {
        $inputs = $request->only(['title', 'description']);
        $article = Article::find($id);
        $article->update($inputs);

        if ($article) {
            session()->flash('notif.success', 'Article updated successfully!');
            return redirect()->route('article.index');
        }

        return abort(500);
    }

    public function delete($id)
    {
        $article = Article::find($id);
        $article->delete($article);

        if ($article) {
            session()->flash('notif.success', 'Article deleted successfully!');
            return redirect()->route('article.index');
        }

        return abort(500);
    }
}
