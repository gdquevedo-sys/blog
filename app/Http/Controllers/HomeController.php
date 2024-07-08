<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        #Obtener los articulos publicos (1)
        $articles = Article::where('status', '1')
                    ->orderBy('id', 'desc')
                    ->simplePaginate(10);

        #Obtener las categorias con estado publico (1) y destacadas (1)
        $navbar = Category::where([
            ['status', '1'],
            ['is_featured', '1'],
        ])->paginate(3);

        return view('home.index', compact('articles', 'navbar'))
            ->simplePaginate(20);
    }

    //Todas las categorias
    public function all(){
        $categories = Category::where('status', '1');
    
        #Obtener las categorias con estado publico (1) y destacadas (1)
        $navbar = Category::where([
            ['status', '1'],
            ['is_featured', '1'],
        ])->paginate(3);

        return view('home.all-categories', compact('categories', 'navbar'));
    }
}
