<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Like;
use App\Post;
use App\Role;
use App\Setting;
use App\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function setting(Request $request){

        if($request->comment) {
            Setting::where('name','stop comment')->update(['value'=>1]);
        }else{
            Setting::where('name','stop comment')->update(['value'=>0]);
        }
        if ($request->register){
            Setting::where('name','stop register')->update(['value'=>1]);
        }
        else{
            Setting::where('name','stop register')->update(['value'=>0]);
        }
        return redirect()->back();


    }
    public function posts(){
        $posts=Post::latest()->paginate(2);
        $categories=Category::all();
        return view('content.posts',compact('posts','categories'));
    }
    public function singlePost($id){
        $post=Post::find($id);
        $stop_comment=Setting::where('name','stop comment')->value('value');
        return view('content.post',compact('post','stop_comment'));
    }
    public function storePost(Request $request){
        //validate
        $rules=[
            'title'=>'required',
            'body'=>'required',
            'url'=>'required|mimes:png,jpg,jpeg',
        ];
        $message=[
            'title.required'=>'plz enter the title of the post',
            'body.required'=>'plz enter the body of the post',
        ];
        $this->validate($request,$rules,$message);
        //upload & create
        //1-check
        if($request->hasFile('url')){
            $imageExtension=$request->file('url')->getClientOriginalExtension();
            $imageName=time().'image .'.$imageExtension;
            //upload the image to server
            $request->file('url')->storeAs('images',$imageName);
        }
       Post::create([
          'title'=>$request->input('title'),
          'body'=>$request->input('body'),
          'url'=>$imageName,
           'category_id'=>$request->input('category_id'),
           'user_id'=>$request->user()->id,
       ]);

        //return
        return redirect()->back()->with('success','the post added successfully');
    }
    public function storeComment(Request $request,$id){
        //validate
        $rules=[
            'body'=>'required'
        ];
        $message=[
            'body.required'=>'plz enter your comment',
        ];
        $this->validate($request,$rules,$message);
        //create
        $post=Post::findOrFail($id);
        $post->comments()->create($request->all());
        //return
        return redirect()->back()->with('success','comment added successfully');
    }
    public function category($id){
        $category=Category::findOrFail($id);
        $posts=Post::where('category_id',$category->id)->get();

        return view('content.category',compact('posts'));
    }
    public function allCategory(){
        //return view
        return view('content.categories');
    }
    public function postCategory(Request $request){
        //validate
        $rules=[
            'name'=>'required',
        ];
        $message=[
            'name.required'=>'plz enter the category'
        ];
        $this->validate($request,$rules,$message);
        //create
        Category::create($request->all());
        //return redirect
        return redirect('/posts')->with('success','category added successfully');
    }
    public function admin(){
        $users=User::all();
        $stop_comment=Setting::where('name','stop comment')->value('value');
        $stop_register=Setting::where('name','stop register')->value('value');
        return view('content.admin',compact('users','stop_comment','stop_register'));
    }
    public function editor(){
        return view('content.editor');
    }
    public function addRole(Request $request){
//          $user=new User();
//        if($user->where('email',$request['email'])->where('admin_of_admin',1)){
//            return back()->withErrors([
//                'message'=>'not allowed to delete this user ,its the king'
//            ]);
//        }
//        return $request->all();
        $user=User::where('email',$request['email'])->first();
        if($user->admin_of_admin == 1){
            return back()->withErrors([
                'message'=>'not allowed to delete this user ,its the king'
            ]);
        }
        $user->roles()->detach();

        if($request['user']){
            $user->roles()->attach(Role::where('name','user')->first());
        }
        if($request['editor'] ){
            $user->roles()->attach(Role::where('name','editor')->first());
        }
        if($request['admin'] ){
            $user->roles()->attach(Role::where('name','admin')->first());
        }

        return back();

    }
    public function like(Request $request){
        //receive data
        $like_s=$request->like_s;
        $post_id=$request->post_id;
        $change_like=0;
        //determine the record
        $like=Like::where('post_id',$post_id)->where('user_id',auth()->user()->id)->first();
        //if user not make like
        if(!$like){
            Like::create(['like'=>1,'post_id'=>$post_id,'user_id'=>auth()->user()->id]);
            $is_like=1;

//            $like=new Like();
//            $like->post_id=$post_id;
//            $like->user_id=auth()->user()->id;
//            $like->like=1;
//            $like->save();

            //in this case user make like
        }elseif ($like->like==1){
                //delete
            Like::where('user_id',auth()->user()->id)->where('post_id',$post_id)->delete();
            $is_like=0;
        }elseif ($like->like==0){
            Like::where('post_id',$post_id)->where('user_id',auth()->user()->id)->update(['like'=>1]);
            $is_like=1;
            $change_like=1;
        }

        $response=[
            'is_like'=>$is_like,
            'change_like'=>$change_like,
        ];

        return response()->json($response,200);
    }
    public function dislike(Request $request){
        //receive data
        $like_s=$request->like_s;
        $post_id=$request->post_id;
        $change_dislike=0;
        //determine the record
        $dislike=Like::where('post_id',$post_id)->where('user_id',auth()->user()->id)->first();
        //if user not make like
        if(!$dislike){
            Like::create(['like'=>0,'post_id'=>$post_id,'user_id'=>auth()->user()->id]);
            $is_dislike=1;
//            $like=new Like();
//            $like->post_id=$post_id;
//            $like->user_id=auth()->user()->id;
//            $like->like=1;
//            $like->save();

            //in this case user make like
        }elseif ($dislike->like==0){
            //delete
            Like::where('user_id',auth()->user()->id)->where('post_id',$post_id)->delete();
            $is_dislike=0;
        }elseif ($dislike->like==1){
            Like::where('post_id',$post_id)->where('user_id',auth()->user()->id)->update(['like'=>0]);
            $is_dislike=1;
            $change_dislike=1;
        }
        $response=[
            'is_dislike'=>$is_dislike,
            'change_dislike'=>$change_dislike,
        ];
        return response()->json($response,200);
    }


    public function statistics(){
        $users=User::all()->count();
        $posts=Post::all()->count();
        $comments=Comment::all()->count();
        $most_comments=User::withCount('comments')->orderBy('comments_count','desc')->first();  // return user with highest comment
        $likes_count_1=Like::where('user_id',$most_comments->id)->count();
        $user_1_count=$most_comments->comments_count + $likes_count_1;


        $most_likes=User::withCount('likes')->orderBy('likes_count','desc')->first();  // return user with highest like
        $comments_count_2=Comment::where('user_id',$most_likes->id)->count();
        $user_2_count=$most_likes->likes_count + $comments_count_2;

        if($user_1_count > $user_2_count){
            $active_user = $user_1_count->name;
            $active_user_likes=$likes_count_1;
            $active_user_comments=$most_comments->comments_count;
        }else{
            $active_user = $most_likes->name;
            $active_user_likes=$most_likes->likes_count;
            $active_user_comments= $comments_count_2;
        }
        $statistics=array(
          'users'=>$users,
          'posts'=>$posts,
          'comments'=>$comments,
          'active_user'=>$active_user,
          'active_user_likes'=>$active_user_likes,
          'active_user_comments'=>$active_user_comments
        );


        return view('content.statistics',compact('statistics'));
    }
}
