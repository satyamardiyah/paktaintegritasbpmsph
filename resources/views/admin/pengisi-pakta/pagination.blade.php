@if ($paginator->hasPages())
  <nav aria-label="Navigasi halaman">
    <ul class="pagination-list">
      <li>
        @if ($paginator->onFirstPage())
          <span class="pagination-link is-disabled" aria-disabled="true" aria-label="Halaman sebelumnya">‹</span>
        @else
          <a class="pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya">‹</a>
        @endif
      </li>

      @foreach ($elements as $element)
        @if (is_string($element))
          <li><span class="pagination-link is-disabled" aria-disabled="true">{{ $element }}</span></li>
        @endif

        @if (is_array($element))
          @foreach ($element as $page => $url)
            <li>
              @if ($page == $paginator->currentPage())
                <span class="pagination-link is-active" aria-current="page">{{ $page }}</span>
              @else
                <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
              @endif
            </li>
          @endforeach
        @endif
      @endforeach

      <li>
        @if ($paginator->hasMorePages())
          <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya">›</a>
        @else
          <span class="pagination-link is-disabled" aria-disabled="true" aria-label="Halaman berikutnya">›</span>
        @endif
      </li>
    </ul>
  </nav>
@endif
