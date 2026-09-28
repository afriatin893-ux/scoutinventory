@if ($paginator->hasPages())
    <div class="pagination-info">
        Menampilkan
        <strong>{{ $paginator->firstItem() }}</strong>
        -
        <strong>{{ $paginator->lastItem() }}</strong>
        dari
        <strong>{{ $paginator->total() }}</strong>
        data
    </div>

    <nav class="pagination-buttons" role="navigation" aria-label="Pagination">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="page-btn disabled">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-btn" rel="prev">‹</a>
        @endif

        {{-- Nomor halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-btn disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-btn" rel="next">›</a>
        @else
            <span class="page-btn disabled">›</span>
        @endif
    </nav>
@endif
