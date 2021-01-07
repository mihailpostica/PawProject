<?php

namespace App\Http\Controllers;

use App\Models\Categorii;
use App\Models\Continut;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
Use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $id=Auth::id();

            $user=User::with('Categorii')->where(['id'=>$id])->first();
            $categorii=[];
            foreach ($user->categorii as $categorie){
                array_push($categorii, $categorie->id);
            }

            $posts=Continut::with('Utilizator','Categorie','Ratings')->whereIn('categorii_id',$categorii)->latest()->paginate(100);

        if (is_array($posts) || is_object($posts)) {
            foreach ($posts as $post) {
                $ratings = $post->ratings;
                $avgRating = 0;
                $post->setHidden(['ratings']);
                if (is_array($ratings) || is_object($ratings)) {
                    foreach ($ratings as $rating) {
                        $avgRating += $rating->rating;
                    }
                    $count = count($ratings);
                    if($count==0){
                        $count=1;
                    }
                    $post->avgRating = $avgRating / $count;
                }

                }
            }
        return response()->json($posts,200);
    }
    public function indexNoAuth()
    {
        $posts=Continut::with('Utilizator','Categorie','Ratings')->latest()->paginate(100);
        if (is_array($posts) || is_object($posts)) {
            foreach ($posts as $post) {
                $ratings = $post->ratings;
                $avgRating = 0;
                $post->setHidden(['ratings']);
                if (is_array($ratings) || is_object($ratings)) {
                    foreach ($ratings as $rating) {
                        $avgRating += $rating->rating;
                    }
                    $count = count($ratings);
                    if($count==0){
                        $count=1;
                    }
                    $post->avgRating = $avgRating / $count;
                }

            }
        }
        return response()->json($posts,200);
    }

    public function ratings($id){
        $ratings=Rating::where('continut_id', $id)->with('Utilizator')->get();
        return response()->json(['ratings'=>$ratings],200);
    }

    public function addRating(Request $request,$id){
        $rating= Rating::Create([
        'user_id' => Auth::user()->id,
        'continut_id'=>$id,
        'rating'=>$request->rating,
        'descriere'=>$request->descriere]);
        if($rating!=null){
            return response()->json(['rating'=>$rating,'success'=>true],201);
        }
        return response()->json(['success'=>false],500);
    }

    public function currentUserPosts(){

        $user=Auth::user()->id;
        $posts=Continut::where('user_id',$user)->with('Categorie')->latest()->paginate(20);
        return $posts;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules=array(
            'categorii_id' => ['required', 'integer'],
            'titlu' => ['required', 'string', 'max:255'],
            'descriere' => ['required', 'string'],
        );

        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            $messages=$validator->messages();
            $errors=$messages->all();
            return response()->json(['errors'=>$errors,'success'=>false],500);
        }
            $request->request->add(['user_id' => $request->user()->id, 'data' => Carbon::now()->toDateTimeString()]);
            $request->request->add(['verificat'=>false]);
            $post = $request->user()->Continut()->create($request->all());
            return response()->json(['post'=>$post,'success'=>true,'message'=>'Post Created Successfully'], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Continut::where('id', $id)->with('Utilizator','Categorie')->first();
        $user=Auth::user()->id;
        $matchThese = ['continut_id' => $id, 'user_id' => $user];
        $isRated= boolval (Rating::where($matchThese)->first());

        if (!is_null($post) ){
            $post->isRated=$isRated;
            return response()->json(['success' => True,'post'=>$post], 200);
        }else{
            return   response()->json(['success' => False,'message'=>'Not Found'], 404);
        }
    }
    public function showUserPost($id)
    {
        $matchThese=['id'=>'$id','user_id',Auth::user()->id];
        $post = Continut::where([$matchThese])->with('Utilizator','Categorie')->first();

        if (!is_null($post) ){
            return response()->json(['success' => True,'post'=>$post], 200);
        }else{
            return   response()->json(['success' => False,'message'=>'You can not edit this post'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $post=Continut::find($id);
        if ($post->update($request->all())){
        return response()->json(['success' => True,'post'=>$post], 200);
        }else{
            return response()->json(['success' => False,'message'=>'Something Went Wrong'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user=Auth::user()->id;
        $matchThese = ['user_id' => $user, 'id' => $id];
        $post=Continut::where($matchThese)->first();

        if (!is_null($post) ){
            Continut::destroy($post->id);
            return response()->json(['success' => True,'message'=>'Post has been successfully deleted'], 200);
        }else{
            return   response()->json(['success' => True,'message'=>'Not Found'], 404);
        }
    }
    public function uploadImage(Request $request){
        try{
            $request->file('image')->store('public');
            $user=Auth::user();
            $user->update(['imagine'=>$request->image->hashName()]);
            return response()->json(['image'=>$request->image->hashName()],200);
        }catch (Exception $exception){
            return response()->json(['success'=>false,'error'=>$exception->getMessage()],500);
        }
    }

    public function search(Request $request)
    {
        $results = (new Search())
            ->registerModel(Continut::class,function (ModelSearchAspect $modelSearchAspect) use ($request) {
                $modelSearchAspect->addSearchableAttribute('descriere');
                $modelSearchAspect->addSearchableAttribute('titlu');
                $modelSearchAspect->with('Categorie');
                $modelSearchAspect->with('Utilizator');
            })->registerModel(Categorii::class,function (ModelSearchAspect $modelSearchAspect) use ($request) {
                $modelSearchAspect->addSearchableAttribute('nume');
                $modelSearchAspect->with(['Continut','Continut.Utilizator']);
            })
            ->search($request->input('query'));
        return response()->json(['posts'=>$results],200);
    }


}
