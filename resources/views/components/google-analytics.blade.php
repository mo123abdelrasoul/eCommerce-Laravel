<script async src="https://www.googletagmanager.com/gtag/js?id={{ $id }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', '{{ $id }}', {
        'page_path': '{{ request()->getPathInfo() }}',
        'page_location': '{{ url()->current() }}'
    });

    function trackEvent(eventName, params = {}) {
        gtag('event', eventName, params);
    }
</script>
