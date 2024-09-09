@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination">
            <!-- Previous Page Link -->
            @if ( $paginator->onFirstPage() )
                <span class="pagination-arrow disabled">
                    <img src="{{ asset('assets/svgs/right-arrow.svg') }}" style="transform: rotateY(180deg)">
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-arrow">
                    <img src="{{ asset('assets/svgs/right-arrow.svg') }}" style="transform: rotateY(180deg)">
                </a>
            @endif

            <!-- Pagination Numbers -->
            @foreach ($paginator->links()->elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-number active">{{ $page }}</span>
                        @else
                            <span class="pagination-number">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </span>
                        @endif
                    @endforeach
                @elseif (is_string($element))
                    <!-- Handle "dots" or other text elements -->
                    <span class="pagination-number">{{ $element }}</span>
                @endif
            @endforeach

            <!-- Next Page Link -->
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-arrow">
                    <img src="{{ asset('assets/svgs/right-arrow.svg') }}">
                </a>
            @else
                <span class="pagination-arrow disabled">
                    <img src="{{ asset('assets/svgs/right-arrow.svg') }}">
                </span>
            @endif
        </div>
    </div>
@endif
