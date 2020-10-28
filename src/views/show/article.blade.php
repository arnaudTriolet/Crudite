<div class="card">
    <img src="{{ $item->getThumbnail() }}" class="card-img-top img-fluid" alt="Responsive image">
    <div class="card-body">
        <h4 class="card-title">{{ $item->getTitle() }}</h4>
        <p class="card-text">{!! $item->getContent() !!}</p>
    </div>
</div>