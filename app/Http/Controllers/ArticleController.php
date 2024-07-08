<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
   
    public function index()
    {
        //Mostrar los articulos en el admin
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->simplePaginate(10);
        
        return view('/home', compact('articles'));
    }

    public function create()
    {
        //Obtener categorias publicas
        $categories = Category::select(['id', 'name'])
                                ->where('status', '1')
                                ->get();

        return view('admin.articles.create', compact('categories'));
    }

    public function store(ArticleRequest $request)
    {
        /*
        Formulario:

        1. Titulo = "Articulo 1"
        2. Slug = "articulo-1"
        3. Introduction = "Este es el primer articulo"
        4. Image = "foto.png"
        5. Body = "Primer articulo del curso"
        6. Status = 3
        8. Category_id = 3
        */

        $request->merge([
            'user_id' => 
            Auth::user()->id,
        ]);

        //Guardo la solicitud en una variable
        $article = $request->all();

        //Validar si hay un archivo en el request
        if($request->hasFile('image')){
            $article['image'] = $request->file('image')->store('articles');
        }

        Article::create($article);

        //Redireccionamos al index
        return redirect()->action([ArticleController::class, 'index'])
                            ->with('success-create', 'Artículo creado con éxito');
    }

    public function show(Article $article)
    {
        //
    }

    public function edit(Article $article)
    {
        //
    }

    public function update(Request $request, Article $article)
    {
        //
    }


    public function destroy(Article $article)
    {
        //
    }
}
