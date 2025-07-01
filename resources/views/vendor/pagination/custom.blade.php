@if ($paginator->hasPages())
    <div class="paginator-wrapper">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="paginator-btn disabled"><i class="fa-solid fa-chevron-right"></i>
                <p>Previous</p>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="paginator-btn">
                <i class="fa-solid fa-chevron-right"></i>
                <p>Previous</p>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($paginator->links()->elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a href="javascript:void(0);" class="paginator-btn">.</a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="javascript:void(0);" class="paginator-btn active-paginator-btn">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}" class="paginator-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="paginator-btn">
                <p>Next</p> <i class="fa-solid fa-chevron-right"></i>
            </a>
        @else
            <span class="paginator-btn disabled">
                <p>Next</p> <i class="fa-solid fa-chevron-right"></i>
            </span>
        @endif
    </div>
@endif
