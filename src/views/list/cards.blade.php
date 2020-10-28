<div class="row row-nop cardlist">
    @if ($collection->count())
        @foreach ($collection as $item)
            <div class="col-sm-3 mb-2 pl-1 pr-1">
                <div class="card">
                    <div class="card-img-top">
                        <img class="card-img lazy" data-src="{{ $item->getThumbnail() }}" alt="">
                    </div>
                    <div class="card-body">
                        <a href="{{ $item->getUrl()}}" title='{{ $item->getTitle() }}'>
                            <h4 class="card-title">{{ $item->getTitle() }}</h4>
                        </a>
                        <p class="card-text">{{ $item->getExtract() }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>Sorry but there's nothing to show</p>
    @endif
</div>