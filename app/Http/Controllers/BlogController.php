<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    use ApiResponser;

    public function bloglist(Request $request)
    {
        try {
            $limit = $request->limit ?? null;
            $cat = DB::table('blog_categories')->where('slug', $request->cat_slug)->first();
            $author = DB::table('authors')->where('author_slug', $request->author_slug)->first();
            // return $request->tag_slug;

            $tag = DB::table('blog_tag_map')
                ->join('blog_tags', 'blog_tags.id', '=', 'blog_tag_map.tag_id')
                ->where('blog_tags.slug', $request->tag_slug)
                ->pluck('blog_tag_map.blog_id');


            // return $tag;

            if ($cat) {
                $blogs = Blog::where('category_id', $cat->id)
                    ->join('blog_categories', 'blog_categories.id', '=', 'blogs.category_id')
                    ->join('authors', 'authors.id', '=', 'blogs.author_id')
                    ->select('blogs.*', 'blog_categories.category_name', 'authors.author_name as author', 'authors.author_slug as author_slug')
                    ->orderBy('blogs.id', 'desc')
                    ->get();
            } elseif ($author) {
                $blogs = Blog::where('author_id', $author->id)
                    ->join('blog_categories', 'blog_categories.id', '=', 'blogs.category_id')
                    ->join('authors', 'authors.id', '=', 'blogs.author_id')
                    ->select('blogs.*', 'blog_categories.category_name', 'authors.author_name as author', 'authors.author_slug as author_slug')
                    ->orderBy('blogs.id', 'desc')
                    ->get();
            } elseif ($tag->count() != 0) {
                $blogs = Blog::whereIn('blogs.id', $tag)
                    ->join('blog_categories', 'blog_categories.id', '=', 'blogs.category_id')
                    ->join('authors', 'authors.id', '=', 'blogs.author_id')
                    ->select('blogs.*', 'authors.author_name as author', 'authors.author_slug as author_slug', 'blog_categories.category_name')
                    ->orderBy('blogs.id', 'desc')
                    ->get();
            } else {
                $blogs = Blog::orderBy('id', 'desc')->join('blog_categories', 'blog_categories.id', '=', 'blogs.category_id')
                    ->join('authors', 'authors.id', '=', 'blogs.author_id')
                    ->limit($limit)
                    ->select('blogs.*', 'blog_categories.category_name', 'authors.author_name as author', 'authors.author_slug as author_slug')
                    ->orderBy('blogs.id', 'desc')
                    ->get();
            }

            // return $blogs;

            // Categories with blog count
            $categories = DB::table('blog_categories')
                ->leftJoin('blogs', 'blogs.category_id', '=', 'blog_categories.id')
                ->select(
                    'blog_categories.id',
                    'blog_categories.category_name',
                    'blog_categories.slug',
                    DB::raw('count(blogs.id) as total')
                )
                ->groupBy('blog_categories.id', 'blog_categories.category_name', 'blog_categories.slug')
                ->having('total', '>', 0)
                ->get();

            $data = [
                'blogs' => $blogs,
                'categories' => $categories,
            ];

            return ApiResponser::successResponse($data, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
        } catch (Exception $e) {
            return ApiResponser::errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
        }
    }


    public function blogdetails(Request $request)
    {
        try {

            $blogs = Blog::where('blogs.slug', $request->slug)
                ->join('blog_categories', 'blog_categories.id', '=', 'blogs.category_id')
                ->join('authors', 'authors.id', '=', 'blogs.author_id')
                ->select('blog_categories.category_name', 'authors.author_name as author', 'authors.author_slug as author_slug', 'blogs.*')
                ->with('tags')
                ->first();

            // Related Blogs
            $relatedBlogs = [];

            if ($blogs) {
                $relatedBlogs = Blog::where('category_id', $blogs->category_id)
                    ->where('id', '!=', $blogs->id)
                    ->select('id', 'title', 'slug', 'thumb_image', 'short_description', 'created_at')
                    ->latest()
                    ->limit(3)
                    ->get();
            }

            // Categories with blog count
            $categories = DB::table('blog_categories')
                ->leftJoin('blogs', 'blogs.category_id', '=', 'blog_categories.id')
                ->select(
                    'blog_categories.id',
                    'blog_categories.category_name',
                    'blog_categories.slug',
                    DB::raw('count(blogs.id) as total')
                )
                ->groupBy('blog_categories.id', 'blog_categories.category_name', 'blog_categories.slug')
                ->having('total', '>', 0)
                ->get();

            $data = [
                'blogs' => $blogs,
                'categories' => $categories,
                'related_blogs' => $relatedBlogs
            ];

            return ApiResponser::successResponse($data, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
        } catch (Exception $e) {
            return ApiResponser::errorResponse($e->getMessage(), Response::HTTP_PARTIAL_CONTENT);
        }
    }
}
