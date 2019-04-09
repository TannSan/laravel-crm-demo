@if ($paginator->hasPages())
<ul class="pagination mb-0 align-self-center" role="navigation">
    {{-- Previous Page Link --}} @if ($paginator->onFirstPage())
    <li class="page-item disabled" aria-disabled="true">
        <span class="page-link"><i class="fa fa-caret-left" aria-hidden="true"></i></span>
    </li>
    @else
    <li class="page-item">
        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-caret-left" aria-hidden="true"></i></a>
    </li>
    @endif {{-- Next Page Link --}} @if ($paginator->hasMorePages())
    <li class="page-item">
        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-caret-right" aria-hidden="true"></i></a>
    </li>
    @else
    <li class="page-item disabled" aria-disabled="true">
        <span class="page-link"><i class="fa fa-caret-right" aria-hidden="true"></i></span>
    </li>
    @endif
</ul>
@endif