<nav aria-label="Bootstrap 5 Pagination">
    <ul class="pagination">

        <!-- Previous Page Link -->
        <li class="page-item {{$paginator->onFirstPage() ? 'disabled' : ''}}" aria-disabled='true'>
            <a @if (!$paginator->onFirstPage()) wire:click="previousPage" @endif class="page-link">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <!-- Elements/Pages/Links -->
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item">
                    <button class="page-link disabled">{{ $element }}</button>
                </li>
            @endif

            <!-- Array Of Links -->
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li class="page-item {{ $page === $paginator->currentPage() ? 'active' : '' }}">
                        <button class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</button>
                    </li>
                @endforeach
            @endif
        @endforeach

        <!-- Next Page Link -->
        <li class="page-item {{!$paginator->hasMorePages() ? 'disabled' : ''}}">
            <a @if ($paginator->hasMorePages()) wire:click="nextPage" @endif class="page-link">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>

    </ul>
</nav>
