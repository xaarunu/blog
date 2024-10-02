<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Like;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogLike extends Component
{
    public $blog;
    public $liked;
    public $likesCount; // Define la variable pública

    public function mount($blog)
    {
        $this->blog = $blog;
        $this->liked = $this->checkIfLiked();
        // Contar el número de likes asociados al blog que son "liked = true"
        $this->likesCount = $this->blog->likes()->where('liked', true)->count(); 
    }

    public function like()
    {
        $like = Like::where('rpe', Auth::user()->rpe)->where('blog_id', $this->blog->id)->first();

        if ($like) {
            $like->liked = !$like->liked; // Cambia el estado de like/dislike
            $like->save();
        } else {
            Like::create([
                'rpe' => Auth::user()->rpe,
                'blog_id' => $this->blog->id,
                'liked' => true,
            ]);
        }

        // Actualiza el estado de liked y el conteo de likes
        $this->liked = $this->checkIfLiked();
        $this->likesCount = $this->blog->likes()->where('liked', true)->count(); // Actualiza el conteo de likes
    }

    public function checkIfLiked()
    {
        return Like::where('rpe', Auth::user()->rpe)
            ->where('blog_id', $this->blog->id)
            ->where('liked', true)
            ->exists();
    }

    public function render()
    {
        return view('livewire.blog-like');
    }
}
