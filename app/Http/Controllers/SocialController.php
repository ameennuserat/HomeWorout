<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Reply;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\Trainees;
use App\Models\Post_image;
use Illuminate\Http\Request;
use App\Models\Post_reaction;
use App\Models\Reply_reaction;
use App\Models\Comment_reaction;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
 public function addpost(Request $request){
    $id=Auth::id();
    $post=Post::create([
        'user_id'=>$id,
        'body'=>$request->body,
    ]);

       if($request->photo!== null){

$photos = [];

foreach ($request->photo as $key => $value) {
    $photo_extension = $value->getClientOriginalExtension();
    $photo_name = time() .'.'. $photo_extension;
    $path = 'postimages';
    $value->move($path, $photo_name);
    $photos[] = [
        'post_id' => $post->id,
        'photo' => $photo_name,
    ];
}

Post_image::insert($photos);
}

return response()->json(['success' => true]);

 }


 public function deletepost(Request $request){
    $id=Auth::id();
    Post::where('user_id',$id)->where('id',$request->post_id)->delete();

    return response()->json(['success' => true]);
 }



 public function post_react(Request $request){
    $id=Auth::id();
    $react=Post_reaction::create([
        'user_id'=>$id,
        'post_id'=>$request->post_id,
    ]);
    //where('user_id', $id)->
    $post = Post::where('id', $request->post_id)->first();
    $num_reaction = $post->reaction_number;
    $new_num = $post->update([
        'reaction_number' => $num_reaction + 1,
    ]);
   return response()->json(['success' => true]);

 }

 public  function addcomment(Request $request){
    $id=Auth::id();
    $comment=Comment::create([
        'user_id'=>$id,
        'body'=>$request->body,
        'post_id'=>$request->post_id
    ]);
    return response()->json(['success' => true]);

 }


 public function deletecomment(Request $request){
    $id=Auth::id();
    Comment::where('user_id',$id)->where('id',$request->comment_id)->delete();
    return response()->json(['success' => true]);

}

public function updatecomment(Request $request){
    $id=Auth::id();
    $comment = Comment::where('user_id', $id)->where('id', $request->comment_id)->first();
    $new_comment = $comment->update([
        'body' => $request->body,
    ]);
    return response()->json(['success' => true]);

}


public function react_comment(Request $request){
    $id=Auth::id();
    $react=Comment_reaction::create([
        'user_id'=>$id,
        'comment_id'=>$request->comment_id,
    ]);

    $comment = Comment::where('id', $request->comment_id)->first();
    $num_reaction = $comment->reaction_number;
    $new_num = $comment->update([
        'reaction_number' => $num_reaction + 1,
    ]);
   return response()->json(['success' => true]);

}
//delete react
public function delete_reaction_on_post(Request $request){
    $id=Auth::id();
    Post_reaction::where('user_id',$id)->where('post_id',$request->post_id)->delete();
    $post = Post::where('user_id', $id)->where('id', $request->post_id)->first();
    $num_reaction = $post->reaction_number;
    $new_num = $post->update([
        'reaction_number' => $num_reaction - 1,
    ]);
   return response()->json(['success' => true]);
}


public function delte_reaction_on_comment(Request $request){
    $id=Auth::id();
    Comment_reaction::where('user_id',$id)->where('comment_id',$request->comment_id)->delete();
    $co = Comment::where('user_id', $id)->where('id', $request->comment_id)->first();
    $num_reaction = $co->reaction_number;
    $new_num = $co->update([
        'reaction_number' => $num_reaction - 1,
    ]);
   return response()->json(['success' => true]);

}

public function delete_reaction_on_reply(Request $request){
    $id=Auth::id();
    Reply_reaction::where('user_id',$id)->where('reply_id',$request->reply_id)->delete();
    $reply = Reply::where('user_id', $id)->where('id', $request->reply_id)->first();
    $num_reaction = $reply->reaction_number;
    $new_num = $reply->update([
        'reaction_number' => $num_reaction - 1,
    ]);

   return response()->json(['success' => true]);

}
//////////////

public function addreply(Request $request){
    $id=Auth::id();
    $reply=Reply::create([
        'user_id'=>$id,
        'body'=>$request->body,
        'comment_id'=>$request->comment_id
    ]);
    return response()->json(['success' => true]);

}


public function updatereply(Request $request){
    $id=Auth::id();
    $reply = Reply::where('user_id', $id)->where('id', $request->reply_id)->first();
    $new_reply = $reply->update([
        'body' => $request->body,
    ]);
    return response()->json(['success' => true]);

}

public function deletereply(Request $request){
    $id=Auth::id();
    Reply::where('user_id',$id)->where('id',$request->reply_id)->delete();
    return response()->json(['success' => true]);
}

public function react_on_reply(Request $request){
    $id=Auth::id();
    $react=Reply_reaction::create([
        'user_id'=>$id,
        'reply_id'=>$request->reply_id,
    ]);

    $reply = Reply::where('id', $request->reply_id)->first();
    $num_reaction = $reply->reaction_number;
    $new_num = $reply->update([
        'reaction_number' => $num_reaction + 1,
    ]);
   return response()->json(['success' => true]);


}
public function display_posts(){
    $posts = Post::orderBy('created_at', 'desc')->get();
    $d = array();
    foreach ($posts as $p) {
        $user= User::where('id', $p->user_id)->first();
        $idt = Trainees::where('user_id', $p->user_id)->value('id');
        $profile=Profile::where('trainees_id', $idt)->first();
        $photoaspost=Post_image::where('post_id', $p->id)->get();
        $photo_posts = [];
        foreach ($photoaspost as $photo) {
            $photo_posts[] = $photo->photo;
        }
        $postData=[
             'id'=>$p->id,
             'body'=>$p->body,
             'photo_post'=>$photo_posts,
             'reaction_number'=>$p->reaction_number,
             'created_at'=>$p->created_at,
             'user_id'=>$p->user_id,
             'user_name'=>$user->name,
             'profile_photo'=>$profile->photo,



           ];
        $d[] = $postData;

    }
    return response()->json($d);
}



public function display_comments(Request $request){
    $post = Post::with('comment')->find($request->post_id);
    $comments = $post->comment;
    $d = array();
    foreach ($comments as $c) {
        $user= User::where('id', $c->user_id)->first();
        $idt = Trainees::where('user_id', $c->user_id)->value('id');
        $profile=Profile::where('trainees_id', $idt)->first();
        $commentData=[
             'id'=>$c->id,
             'body'=>$c->body,
             'reaction_number'=>$c->reaction_number,
             'created_at'=>$c->created_at,
             'user_id'=>$c->user_id,
             'user_name'=>$user->name,
             'profile_photo'=>$profile->photo,
           ];
        $d[] = $commentData;

    }
    return response()->json($d);

}

public function display_replies(Request $request){
    $comment = Comment::with('reply')->find($request->comment_id);
    $replies = $comment->reply;
    $d = array();
    foreach ($replies as $r) {
        $user= User::where('id', $r->user_id)->first();
        $idt = Trainees::where('user_id', $r->user_id)->value('id');
        $profile=Profile::where('trainees_id', $idt)->first();
        $commentData=[
             'id'=>$r->id,
             'body'=>$r->body,
             'reaction_number'=>$r->reaction_number,
             'created_at'=>$r->created_at,
             'user_id'=>$r->user_id,
             'user_name'=>$user->name,
             'profile_photo'=>$profile->photo,
           ];
        $d[] = $commentData;

    }
    return response()->json($d);


}

public function who_react_onpost(Request $request){
 $reaction=Post_reaction::where('post_id',$request->post_id)->get();
 $react = array();
 foreach($reaction as $re){
    $user= User::where('id', $re->user_id)->first();
    $idt = Trainees::where('user_id', $re->user_id)->value('id');
    $profile=Profile::where('trainees_id', $idt)->first();
    $data=[
     'id'=>$re->id,
     'user_id'=>$re->user_id,
     'user_name'=>$user->name,
     'profile_photo'=>$profile->photo
    ];
    $react[]=$data;

 }
 return response()->json($react);
}

public function who_react_oncomment(Request $request){
    $reaction=Comment_reaction::where('comment_id',$request->comment_id)->get();
    $react = array();
    foreach($reaction as $re){
       $user= User::where('id', $re->user_id)->first();
       $idt = Trainees::where('user_id', $re->user_id)->value('id');
       $profile=Profile::where('trainees_id', $idt)->first();
       $data=[
        'id'=>$re->id,
        'user_id'=>$re->user_id,
        'user_name'=>$user->name,
        'profile_photo'=>$profile->photo
       ];
       $react[]=$data;

    }
    return response()->json($react);
   }


   public function who_react_onreply(Request $request){
    $reaction=Reply_reaction::where('reply_id',$request->reply_id)->get();
    $react = array();
    foreach($reaction as $re){
       $user= User::where('id', $re->user_id)->first();
       $idt = Trainees::where('user_id', $re->user_id)->value('id');
       $profile=Profile::where('trainees_id', $idt)->first();
       $data=[
        'id'=>$re->id,
        'user_id'=>$re->user_id,
        'user_name'=>$user->name,
        'profile_photo'=>$profile->photo
       ];
       $react[]=$data;

    }
    return response()->json($react);
   }


}
