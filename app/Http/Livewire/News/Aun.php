<?php namespace App\Http\Livewire\News;

use App\Models\NewsArticles;
use Livewire\Component;
use \Session;

class Aun extends Component
{
    public $articles;

    
    public function mount()
    {
        $this->articles = NewsArticles::where('user_id', 1)->get();
    }

    public function render()
    {

        return view('livewire.news.aun');
    }
}
