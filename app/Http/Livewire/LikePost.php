<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post;
    public $islike;
    public $likes;
//     constructor de livewire se ejecuta al llamar el componente de livewire
    public function mount($post){
        $this->islike = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like()
    {
        if ($this->post->checkLike(auth()->user())) {
            $this->post->likes()->where('post_id',$this->post->id)->delete();
            $this->islike = false;
            $this->likes--;
        }else{
            $this->post->likes()->create([
               'user_id' => auth()->user()->id,
            ]);
            $this->islike = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
