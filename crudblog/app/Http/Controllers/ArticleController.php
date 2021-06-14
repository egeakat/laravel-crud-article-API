<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Article;
use App\Models\User;

use Illuminate\Database\Eloquent\ModelNotFoundException;
class ArticleController extends Controller
{
    //
    public function getLatestArticles(Request $request){
        return Article::orderByDesc('created_at')->with('user')->paginate(5);
        
    }
    
    public function getArticle(Request $request, $id){
        try{
            return Article::findOrFail($id);
            
        }
        catch(ModelNotFoundException $e){
            return abort(404, 'article not found');
        }
    }

    public function createArticle(Request $request){
        $request->validate([
            'headline'=>'required|max:255',
            'content'=>'required|max:10000'
        ]);

        return $request->user()->articles()->create([
            'headline' => $request->get('headline'),
            'content' => $request->get('content')
        ]);
    }

    public function deleteArticle(Request $request, $id){
       if($request->user()->articles()->find($id)){
        Article::destroy($id);
        return response()->json(['message'=>'Deleted successfully'],200);
       }

       else{
        return response()->json(['message'=>'Article not found'],404);
       }
    }

    public function editArticle(Request $request, $id){

        $request->validate([
            'headline'=>'required|max:255',
            'content'=>'required|max:10000'
        ]);

        try{
            $article = $request->user()->articles()->findOrFail($id);
            $article->headline = $request->get('headline');
            $article->content = $request->get('content');
            $article->save();
            return $article;
        }
        catch(ModelNotFoundException $e){
            return abort(404, 'article not found');
        }
       
     }
}
