<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\CategoryController;

class CategoryController extends Controller
{
    
    public function index()
    {
        //Mostrar categorias en el admin
        $categories = Category::orderBy('id', 'desc')
                                ->simplePaginate(8);

        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        //Retornamos el formulario para crear categorias
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        //Creamos una variable
        $category = $request->all();

        //Validar si hay un archivo
        if($request->hasFile('image')){
            $category['image'] = $request->file('image')->store('categories');
        }

        //Guardar informacion
        category::create($category);

        //Redirigir al index y que muestre categoria creada con exito
        return redirect()->action([CategoryController::class, 'index'])
            ->with('success-create', 'Categoria creada con exito');
    }  
    
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
   
    public function update(CategoryRequest $request, Category $category)
    {
        //Si el usuario sube una imagen
        if($request->hasFile('image')){
            //Eliminar la imagen anterior
            File::delete(public_path('storage/'.$category->image));
            //Asignar la nueva imagen
            $category['image'] = $request->file('image')->store('categories');
        }

        //Actualizar datos
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'is_featured' => $request->is_featured,

        ]);

        //Redireccionamos al index
        return redirect()->action([CategoryController::class, 'index'], compact('category'))
                        ->with('success-update', 'Categoria modificada con exito');
    }
    
    public function destroy(Category $category)
    {
        //Eliminar imagen de la categoria
        if($category->image){
            File::delete(public_path('storage/' . $category->image));
        }

        //Eliminamos la categoria
        $category->delete();

        //Redireccionamos al index
       return redirect()->action([CategoryController::class, 'index'], compact('category'))
                        ->with('success-delete', 'Categoria eliminada con exito');
    }

    //Filtrar articulos por categorias
   public function detail(Category $category){
    
    $articles = Article::where([
        ['category_id', $category->id],
        ['status', '1']
    ])
        ->orderBy('id', 'desc')
        ->SimplePaginate(5);

    $navbar = Category::where([
        ['status',  '1'],
        ['is_featured', '1'],
    ])->paginate(3);
    
    return view('subscriber.categories.detail', compact('articles', 'category', 'navbar'));
    }
}
