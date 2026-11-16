
<div class="category-node">

    <div class="category-row">

        {{-- CHỌN DANH MỤC --}}
        <label class="filter-option {{ (string) $selectedCategory === (string) $category->category_id ? 'selected' : '' }}">

            <input
                type="radio"
                name="category"
                value="{{ $category->category_id }}"
                {{ (string) $selectedCategory === (string) $category->category_id ? 'checked' : '' }}
                onchange="this.form.submit()"
            >

            <span>{{ $category->name }}</span>

            @if ((string) $selectedCategory === (string) $category->category_id)
                <i class="bi bi-check2"></i>
            @endif

        </label>

        {{-- NÚT XỔ DANH MỤC CON --}}
        @if ($category->children->isNotEmpty())

            <button
                type="button"
                class="category-toggle"
                aria-expanded="false"
                aria-label="Mở danh mục con"
            >
                <i class="bi bi-chevron-down"></i>
            </button>

        @endif

    </div>

    {{-- DANH MỤC CON --}}
    @if ($category->children->isNotEmpty())

        <div class="category-children">

            @foreach ($category->children as $child)

                @include('products.partials.category-item', [
                    'category' => $child,
                    'selectedCategory' => $selectedCategory
                ])

            @endforeach

        </div>

    @endif

</div>
