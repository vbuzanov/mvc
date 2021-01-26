<?php
namespace Core\Controllers;

use Core\Libs\Exceptions\NotFoundException;
use Core\Models\Article;
use Core\Models\User;
use Core\Views\View;
use Reflection;
use ReflectionObject;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ArticleController extends Controller{

    public function show($id)
    {
        $article = Article::getById($id);
        if(!$article){
            throw new NotFoundException();
        }
        // $author = User::getById($article->user_id);
        View::render('articles/show', compact('article'));
    }

    public function pdf()
    {
        $articles = Article::findAll();
        $html = '';
        foreach($articles as $article){
            $html.= "<h1>{$article->name}</h1>";
            $html.= "<p>{$article->text}</p>";
        }
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetFooter('|Страница {PAGENO} из {nbpg}|');
        $mpdf->WriteHTML($html);
        // $mpdf->Output();
        $mpdf->Output('articles.pdf', 'D');
    }

    public function excel()
    {
        $articles = Article::findAll();
        // echo '<pre>' . print_r($articles, true) . '</pre>';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="hello world.xlsx"');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
  
        for ($i=1; $i <= count($articles); $i++) { 
            $sheet->setCellValue('A'.$i, $articles[$i-1]->name);
            $sheet->setCellValue('B'.$i, $articles[$i-1]->text);
            $sheet->setCellValue('C'.$i, $articles[$i-1]->getAuthor()->name);
            $sheet->setCellValue('D'.$i, $articles[$i-1]->created_at);
        }

        // $sheet->setCellValue('A1', 'Hello World !');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function edit($id)
    {
        $article = Article::getById($id);
        if(!$article){
            throw new NotFoundException();
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
            throw new NotFoundException();
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