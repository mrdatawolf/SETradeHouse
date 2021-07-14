<?php namespace App\Http\Livewire\News;

use App\Models\NewsArticles;
use Livewire\Component;
use \Session;

class Tldr extends Component
{
    public $articles;


    public function mount()
    {
        $this->articles = NewsArticles::where('user_id', 16)->orderBy('created_at')->get();
    }

    public function render()
    {

        return view('livewire.news.tldr');
    }
}
