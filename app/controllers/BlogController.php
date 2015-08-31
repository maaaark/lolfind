<?php

class BlogController extends \BaseController {

	public function index(){
		$blog_posts = BlogPost::where("status", "=", "100")->orderBy("created_at", "DESC")->paginate(10);
		return View::make("blog.index", array(
			"blog_posts" => $blog_posts,
		));
	}

	public function detail($date, $id, $name){
		$post = BlogPost::where("id", "=", $id)->where("created_at", "LIKE", '%'.trim($date).'%')->first();
		if(isset($post->id) && $post->id > 0){
			if($post->status == 100 || Auth::check() && Auth::user()->hasRole('admin')){
				return View::make("blog.detail", array(
					"post" => $post,
				));
			}
		}
		return App::abort(404);
	}

}