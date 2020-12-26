<?php
namespace Core\Controllers;

use Core\Models\Article;
use Core\Models\User;
use Core\Views\View;
use Reflection;
use ReflectionObject;

class ArticleController extends Controller{

    public function show($id)
    {
        $article = Article::getById($id);
        if(!$article){
            View::render('errors/404', [], 404);
            return;
        }
        // $author = User::getById($article->user_id);
        View::render('articles/show', compact('article'));
    }
    public function edit($id)
    {
        $article = Article::getById($id);
        if(!$article){
            View::render('errors/404', [], 404);
            return;
        }
        $article->name = $_POST['name'];
        $article->text = $_POST['text'];
        $article->user_id = $_POST['user_id'];
        
        
        $article->save();
        $this->redirect('/');
    }

    function editForm($id)
    {
        $article = Article::getById($id);
        if(!$article){
            View::render('errors/404', [], 404);
            return;
        }
        $users = User::findAll();
        View::render('articles/edit', compact('article', 'users'));
    }

    function add(){
        
        $article = new Article();
        $article->name = $_POST['name']; 
        $article->text = $_POST['text'];
        $article->user_id = $_POST['user_id'];

        $article->save();
        $this->redirect('/');

    }
    function addForm()
    {
        $users = User::findAll();
        View::render('articles/add', compact('users'));
    }

    public function delete($id)
    {
        $article = Article::getById($id);
        $article->delete();
        $this->redirect('/');
    }
}

    





//ORM - Object Relation Mapping
//Singletone - паттерн