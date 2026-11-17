@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination" style="display:flex; justify-content:center; margin-top:1.5rem;">
    <ul style="display:flex; list-style:none; padding:0; margin:0; gap:4px; flex-wrap:wrap; align-items:center;">

        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <li style="display:inline-flex;">
                <span style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:8px;border:1px solid #e2e8f0;background:#f8fafc;color:#94a3b8;font-size:0.875rem;font-weight:500;cursor:default;font-family:inherit;">
                    &laquo;
                </span>
            </li>
        @else
            <li style="display:inline-flex;">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:8px;border:1px solid #e2e8f0;background:#fff;color:#334155;font-size:0.875rem;font-weight:500;text-decoration:none;transition:all 0.15s;font-family:inherit;" onmouseover="this.style.background='#eef2ff';this.style.borderColor='#6366f1';this.style.color='#6366f1'" onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='#334155'">
                    &laquo;
                </a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li style="display:inline-flex;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:8px;border:1px solid #e2e8f0;background:#f8fafc;color:#94a3b8;font-size:0.875rem;font-family:inherit;">
                        {{ $element }}
                    </span>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li style="display:inline-flex;">
                            <span aria-current="page" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:8px;border:1px solid #6366f1;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-size:0.875rem;font-weight:700;font-family:inherit;box-shadow:0 2px 8px rgba(99,102,241,0.35);">
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li style="display:inline-flex;">
                            <a href="{{ $url }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:8px;border:1px solid #e2e8f0;background:#fff;color:#334155;font-size:0.875rem;font-weight:500;text-decoration:none;font-family:inherit;" onmouseover="this.style.background='#eef2ff';this.style.borderColor='#6366f1';this.style.color='#6366f1'" onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='#334155'">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <li style="display:inline-flex;">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:8px;border:1px solid #e2e8f0;background:#fff;color:#334155;font-size:0.875rem;font-weight:500;text-decoration:none;font-family:inherit;" onmouseover="this.style.background='#eef2ff';this.style.borderColor='#6366f1';this.style.color='#6366f1'" onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='#334155'">
                    &raquo;
                </a>
            </li>
        @else
            <li style="display:inline-flex;">
                <span style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:8px;border:1px solid #e2e8f0;background:#f8fafc;color:#94a3b8;font-size:0.875rem;font-weight:500;cursor:default;font-family:inherit;">
                    &raquo;
                </span>
            </li>
        @endif

    </ul>
</nav>
@endif
