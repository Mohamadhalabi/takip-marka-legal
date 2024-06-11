<script>
    // Function to load Google Tag Manager script
    function loadGoogleTagManager() {
        var gtmScript = document.createElement('script');
        gtmScript.src = 'https://www.googletagmanager.com/gtag/js?id=G-47KRXNLJKV';
        gtmScript.async = true;

        // Insert the script into the document
        document.body.appendChild(gtmScript);

        // Execute the gtag config after script has loaded
        gtmScript.onload = function() {
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-47KRXNLJKV');
        };
    }

    // Add an event listener for the page load event
    window.addEventListener('load', loadGoogleTagManager);
</script>
