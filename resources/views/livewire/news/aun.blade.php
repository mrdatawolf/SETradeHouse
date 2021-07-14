<div>
    <div class="card-columns">
        @foreach($articles as $article)
        <div class="card">
            <div class="card-header">
                <h2><?=$article->title;?></h2>
            </div>
            <div class="card-body">
                <?=$article->body;?>
            </div>
        </div>
        @endforeach
    </div>
</div>
