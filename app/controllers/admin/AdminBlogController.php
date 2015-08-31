<?php
use Intervention\Image\ImageManagerStatic as Image;

class AdminBlogController extends BaseController {

    public function index(){
        $blog_posts = BlogPost::orderBy("id", "DESC")->paginate(15);
        return View::make("admin.blog.index", array(
            "blog_posts" => $blog_posts,
        ));
    }

    public function post($id){
        if(strtolower(trim($id)) == "new"){
            $post = false;
        } else {
            $post = BlogPost::where("id", "=", $id)->first();
            if(!isset($post->id) || $post->id < 1){
                return App::abort("404");
            }
        }

        return View::make("admin.blog.post", array(
            "post" => $post,
            "id"   => $id,
        ));
    }

    public function post_action($id){
        if(Input::get("post_id") && Input::get("post_id") > 0){
            $post = BlogPost::where("id", "=", Input::get("post_id"))->first();
            if(!isset($post->id) || $post->id < 1){
                return App::abort("404");
            }
        } else {
            $post = new BlogPost;
            $post->user = Auth::user()->id;
        }

        $post->title  = Input::get("title");
        $post->text   = Input::get("text");
        $post->status = Input::get("status");
        $post->save();


        if(Input::file('picture') && trim(Input::file('picture')) != ""){
            Image::make(Input::file('picture'))->resize(800, null, function($constraint){
                $constraint->aspectRatio();
            })->save(public_path().'/uploads/blog/blog_post_'.$post->id.'.jpg');

            Image::make(Input::file('picture'))->resize(400, null, function($constraint){
                $constraint->aspectRatio();
            })->save(public_path().'/uploads/blog/small_blog_post_'.$post->id.'.jpg');
            $post->picture = 'blog_post_'.$post->id.'.jpg';
            $post->save();
        }

        return Redirect::to("/admin/blog")->with("success", "Successfully saved the blog post.");
    }

    public function delete_action($id){
        $post = BlogPost::where("id", "=", $id)->first();
        if(isset($post->id) && $post->id > 0){
            if($post->picture && trim($post->picture) != ""){
                $filename       = trim(public_path()."/uploads/blog/".$post->picture);
                $filename_small = trim(public_path()."/uploads/blog/small_".$post->picture);
                if(File::exists($filename)){
                    File::delete($filename);
                }
                if(File::exists($filename_small)){
                    File::delete($filename_small);
                }
            }
            $post->delete();
            return Redirect::to("/admin/blog");
        }
        return App::abort("404");
    }

}
