@if ($results->isEmpty())
    <div class="pp-post-item mb-2">
        <p>Tidak ada hasil ditemukan.</p>
    </div>
@else
    @foreach ($results as $item)
        <div class="pp-post-item mb-2">
            <div class="pp-post-img">
                <img src="{{ $item->images[0]['image_path'] }}" alt="Image" width="80">
            </div>
            <div class="pp-post-info">
                <h6><a href="{{ route('user.news.detail', $item->id) }}">{{ Str::limit($item->title, 50) }}</a></h6>
                <span><i class="las la-calendar"></i>
                    {{ \Carbon\Carbon::parse($item->published)->format('d M Y') }}
                </span>
            </div>
        </div>
    @endforeach
@endif
