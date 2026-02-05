@push('scripts')
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    // Filament SPA mode compatible
    document.addEventListener('DOMContentLoaded', function() {
        initPusher();
    });

    // Reinit setelah navigation (jika pakai SPA)
    document.addEventListener('livewire:navigated', function() {
        initPusher();
    });

    function initPusher() {
        Pusher.logToConsole = true;

        const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true,
            authEndpoint: "/broadcasting/auth",
            auth: {
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name=csrf-token]').content
                }
            },
        });

        const channel = pusher.subscribe("private-barcode-scan.{{ auth()->id() }}");

        channel.bind('pusher:subscription_succeeded', function() {
            console.log('✅ Pusher: Successfully subscribed');
        });

        channel.bind('pusher:subscription_error', function(status) {
            console.error('❌ Pusher: Subscription error', status);
        });

        channel.bind("barcode.scanned", function(data) {
            console.log("📡 Pusher: Event received", data);

            // Dispatch ke Livewire component (Filament way)
            Livewire.dispatch("barcodeScannedRealtime", {
                barcode: data.barcode
            });
        });
    }
</script>
@endpush
