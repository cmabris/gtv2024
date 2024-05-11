<!-- SI QUIERES COMPROBAR QUE FUNCIONA COPIA EL CODIGO A LA VISTA show-point.blade.php -->

<div style="width: 100%; height: 60vh;">
    <div id="map" style="width: 100%; height: 100%;"></div>
</div>

<div class="flex items-center mb-6">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
</div>

@push('scripts')
    <!-- Script para inicializar el mapa Leaflet -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Obtener las coordenadas del primer punto para centrar el mapa
        var firstPoint = {!! json_encode($points->first()) !!};
        var initialLat = firstPoint.latitude;
        var initialLng = firstPoint.longitude;

        // Definir las coordenadas máximas y mínimas para limitar el mapa
        var southWest = L.latLng(-90, -180);
        var northEast = L.latLng(90, 180);
        var bounds = L.latLngBounds(southWest, northEast);

        // Inicializar el mapa Leaflet centrado en la primera coordenada y con límites máximos
        var map = L.map('map', {
            minZoom: 1.5, // Establece el zoom mínimo permitido
            maxZoom: 18, // Establece el zoom máximo permitido
            maxBounds: bounds, // Establece los límites máximos del mapa
            lang: 'es' // Establece el idioma del mapa a español
        }).setView([initialLat, initialLng], 10); // Se ajustó el nivel de zoom a 10

        // Agregar la capa de basemaps al mapa ya que con esta si que aparece en español
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://carto.com/"></a> ',
            noWrap: true // Configuración para evitar que los azulejos se envuelvan horizontalmente
        }).addTo(map);

        // Iterar sobre los puntos y agregar marcadores
        @foreach($points as $point)
        L.marker([{{ $point->latitude }}, {{ $point->longitude }}])
            .addTo(map)
            .bindPopup('Distancia: {{ $point->distance }} km<br>Latitud: {{ $point->latitude }}<br>Longitud: {{ $point->longitude }}');
        @endforeach
    </script>
@endpush
