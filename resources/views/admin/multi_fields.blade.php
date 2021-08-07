<multi-fields 
    v-bind:fieldsin = '@json($items)'
    v-bind:products = '@json($products)'
    prefix = "{{ $prefix }}"
    title = "{{ $title ?? '' }}"
></multi-fields>