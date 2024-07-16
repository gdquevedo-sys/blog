<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
   
    public function index()
    {
        //Realizamos la consulta para obtener los comentarios en el panel de administracion
        $comments = DB::table('comments')
                ->join('articles', 'comments.article_id', '=', 'articles.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.value', 'comments.description',
                'articles.title', 'users.name')
                ->where('articles.user_id', '=', Auth::user()->id)
                ->orderBy('articles.id', 'desc')
                ->get();
        
        return view('admin.comments.index', compact('comments'));
    }
   
    public function create()
    {
        //
    }
    
    public function store(CommentRequest $request)
    {
        //Verificar si en el articulo ya existe un comentario del usuario
        $result = Comment::where('user_id', Auth::user()->id)
                            ->where('article_id', $request->article_id)->exists();

        //Consulta para obtener el slug y estado del articulo comentado
        $article = Article::select('status', 'slug')->find($request->article_id);

        //Si no existe y si el estado del articulo es publico, comentar.
        if(!$result and $article->status == 1){
            Comment::create([
                'value' => $request->value,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'article_id' => $request->article_id,
            ]);
            return redirect()->action([ArticleController::class, 'show'], [$article->slug]);
        }else{
            return redirect()->action([ArticleController::class, 'show'], [$article->slug])
                            ->with('success-error', 'Solo puedes comentar una vez');
        }
    }
   
    public function show(Comment $comment)
    {
        //
    }
   
    public function edit(Comment $comment)
    {
        //
    }
  
    public function update(Request $request, Comment $comment)
    {
        //
    }
    
    public function destroy(Comment $comment)
    {
        $comment->delete();

        //Lo redirigimos a la vista
        return redirect()->action([CommentController::class, 'index'], compact('comment'))
                ->with('success-delete', 'Comentario eliminado con exito');
    }
}
