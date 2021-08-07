<div class="position-relative d-flex flex-column">
    <div class="map-wrapper1 order-2 order-md-1">
        <div class="map-init" style="height: 410px">
            <div id="ya-map" style="width:100%; height: 410px"></div>
        </div>
    </div>
    <script defer>
        let mapLat = {{ getLat() }};
        let mapLng = {{ getLng() }};
        let mapText = '{{ cv('map_text') }}';

    </script>
    <!-- map end -->
    <div class="order-1 order-md-2">
        @include('shared.contacts')
    </div>
</div>
