<div>
    {{-- Be like water. --}}
    <div class="container mx-auto">
        <div class="bg-white p-6 rounded-lg mt-3 shadow-lg">
            <div class="grid grid-cols1 md:gird-cols2 gap-6 mb-6">
                <div>
                    <h2 class="text-2xl font-bold mb-2"> Informasi Pegawai</h2>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <p class="mb-2"><strong>Nama Pegawai:</strong> {{ Auth::user()->name }}</p></p>
                        <p class="mb-2"><strong>Kantor:</strong> {{$schedule->office->name}}</p></p>
                        <p class="mb-2"><strong>Shift:</strong> {{$schedule->shift->name}} ({{$schedule->shift->start_time}} - {{$schedule->shift->end_time}}) WIB</p></p>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-2">Presensi</h2>
                    <div id="map" class="mb-4 rounded-lg border border-gray-300">

                    </div>
                    <button type="button" onclick="tagLocation()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tag location</button>
                    <button type="button" onclick="" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Presence</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        const map = L.map('map').setView([{{$schedule->office->latitude}}, {{$schedule->office->longitude}}], 18);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        const center = [{{$schedule->office->latitude}}, {{$schedule->office->longitude}}];
        const radius = {{$schedule->office->radius}};

        let marker;

        const circle = L.circle(center, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius
        }).addTo(map);

        function tagLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    if (marker) {
                        map.removeLayer(marker);
                    }
                    marker = L.marker([lat, lng]).addTo(map);
                    map.setView([lat, lng], 18);
                })
            }
        }

    </script>
</div>
