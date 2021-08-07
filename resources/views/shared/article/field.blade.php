@switch($field['type'] ?? '')
    @case('image')
        @if ($field['value'] ?? '')
        <div class="mb-4 mx-auto col-md-{{ $field['wide'] ?? 12 }} field-image">
            <img data-src="{{ asset($field['value']) }}" alt="" class="lazy img-fluid">
        </div>
        @endif
        @break
    @case('ckeditor')
        <div class="mb-4 mx-auto col-md-{{ $field['wide'] ?? 12 }} field-text">
            {!! rv(str_replace('%date%',($promoDate ?? ''),$field['value'] ?? '')) !!}
        </div>
        @break
    @case('product_text')
        <div class="mb-4 mx-auto col-md-{{ $field['wide'] ?? 12 }} field-product">
            <div class="row">
                <div class="col-md-6 {{ ($field['value']['position'] ?? '') == 'left' ? 'order-2' : '' }}">
                    {!! rv(str_replace('%date%',($promoDate ?? ''),$field['value']['text'] ?? '')) !!}
                </div>
                <div class="col-md-6 {{ ($field['value']['position'] ?? '') == 'left' ? 'order-1' : '' }}">
                    @isset($field['value']['product'])
                        @php
                            $product = \App\Models\Product::find($field['value']['product'])
                        @endphp
                        @if ($product)
                            @include('shared.product.teaser',['product'=> $product,'category'=>$product->categories->first()])
                        @endif
                    @endisset
                </div>
            </div>
        </div>
        @break
    @case('two_text')
        <div class="mb-4 mx-auto col-md-{{ $field['wide'] ?? 12 }} field-columns">
            <div class="row">
                <div class="col-md-6">
                    {!! rv(str_replace('%date%',($promoDate ?? ''),$field['value']['left'] ?? '')) !!}
                </div>
                <div class="col-md-6">
                    {!! rv(str_replace('%date%',($promoDate ?? ''),$field['value']['right'] ?? '')) !!}
                </div>
            </div>
        </div>
        @break
    @case('html')
        <div class="mb-4 mx-auto col-md-{{ $field['wide'] ?? 12 }} field-html">
            {!! rv(str_replace('%date%',($promoDate ?? ''),$field['value']?? '')) !!}
        </div>
        @break
    @default
@endswitch
