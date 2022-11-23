<?php

namespace App\Http\Controllers\Blog;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Str;
use Mail;
use App\Mail\LikeNotification;

class BlogController
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if($user){
            return $this->showVisiblePosts($user);
        }

        return $this->showPublicPosts();
    }

    private function showPublicPosts(): View
    {
        return view('blog.index')
            ->with('posts', Post::getPublicPosts());
    }

    private function showVisiblePosts(User $user): View
    {
        return view('blog.index')
            ->with('user', $user)
            ->with('posts', Post::getVisiblePosts($user->id));
    }

    public function createPost(): View
    {
        return view('blog.post-form')
            ->with('action', 'add');;
    }


    public function handleCreatePost(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'min:5', 'max:255'],
            'content' => ['required'],
            'published' => ['boolean'],
        ]);

        $payload = $request->only(['title', 'content', 'published']);
        $payload['author_id'] = $request->user()->id;
        $payload['slug'] = Str::slug($request->title, '-');
        $payload['published'] = !isset($request->published);

        $post = Post::create($payload);

        return redirect()->route('index', $post)->with('statusMessage', 'Post has been created!');
    }

    public function viewSinglePost(Request $request, string $slug): View
    {
        return view('blog.detailed')
            ->with('post', Post::getSinglePost($slug, $request->user()))
            ->with('user', $request->user());
    }

    public function editPost(Request $request, string $slug): View
    {
        return view('blog.post-form')
            ->with('post', Post::getSinglePost($slug, $request->user()))
            ->with('action', 'edit');
    }

    public function handelEditPost(Request $request, string $slug): RedirectResponse
    {
        $post = Post::getSinglePost($slug, $request->user());
        $request->validate([
            'title' => ['required', 'min:5', 'max:255'],
            'content' => ['required'],
            'published' => ['boolean'],
        ]);

        $payload = $request->only(['title', 'content', 'published']);
        $payload['published'] = !isset($request->published);

        $post->update($payload);

        return redirect()->route('index', $post)->with('statusMessage', 'Post has been modified!');
    }

    public function deletePost(Request $request, string $slug): View
    {
        return view('blog.post-remove-form')
            ->with('post', Post::getSinglePost($slug, $request->user()));
    }

    public function handleDeletePost(Request $request, string $slug): RedirectResponse
    {
        $post = Post::getSinglePost($slug, $request->user());
        $post->delete();

        return redirect()->route('index')->with('statusMessage', 'Post has been Deleted!');
    }

    public function addPostLike(Request $request, string $slug): RedirectResponse
    {
        $post = Post::getSinglePost($slug, $request->user());

        if($post && $post->canBeLikedByUser($request->user()))
        {
            Like::create([
                'user_id' => $request->user()->id,
                'post_id' => $post->id
            ]);

           $this->notifyAuthor($post);

            return redirect()->route('index')->with('statusMessage', 'Post has been Liked!');
        }

        return redirect()->route('index')->with('statusMessage', 'Something was wrong!');
    }

    public function removePostLike(Request $request, string $slug): RedirectResponse
    {
        $post = Post::getSinglePost($slug, $request->user());

        if($post) {
            $like = $post->getUserLike($request->user());

            if($like) {
                $like->delete();

                return redirect()->route('index')->with('statusMessage', 'Post has been Unliked!');
            }
        }

        return redirect()->route('index')->with('statusMessage', 'Something was wrong!');
    }

    private function notifyAuthor(Post $post): void
    {
        $mailData = [
            'url' => route('blog.view', $post->slug),
        ];

        Mail::to($post->user()->email)->send(new LikeNotification($mailData));
    }
}
