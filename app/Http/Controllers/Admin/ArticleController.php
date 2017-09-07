<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    //
    public function index()
    {
        return view('admin/article/index')->withArticles(Article::all());
    }

    public function create()
    {
        return view('admin/article/create');
    }

    public function edit($id)
    {
        return view('admin/article/edit')->withArticle(Article::find($id));
    }

    public function store(Request $request)
    {
        // 数据验证
        $this->validate($request, [
            'title' => 'required|unique:articles|max:255',//必填,在表中唯一、最大长度255
            'body' => 'required',//必填
        ]);
        //通过Article Model插入一条数据进 article表
        $article = new Article;//初始化article对象
        $article->title = $request->get('title');//将post的title值赋給article的title属性
        $article->body = $request->get('body');
        $article->user_id = $request->user()->id;//获取当前Auth系统中注册的用户,并且将id赋給article的user_id属性

        //将数据保存到数据库,通过判断保存结果,控制页面进行跳转
        if ($article->save())
        {
            //跳转到文章管理页
            return redirect('admin/article');
        }
        else
        {
            //保存失败,跳回原页面,保存用户输入,给出提示
            return redirect()->back()->withInput()->withErrors('保存失败!');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|unique:articles,title,' .$id. '|max:255',
            'body' => 'required',
        ]);

        $article = Article::find($id);
        $article->title = $request->get('title');
        $article->body = $request->get('body');

        if ($article->save())
        {
            return redirect('admin/article');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors('更新失败!');
        }
    }

    public function destroy($id)
    {
        Article::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功!');
    }
}
