(function(d) {
    // attach script tag and defer
    function downloadJSAtOnload() {
        var wf = d.createElement('script'), s = d.scripts[0];
        wf.src = 'https://datacapture.dropsolid.com/8ac23bbf-5e59-4635-92f6-a477ea45542b/capture.js'
        wf.defer = true;
        wf.setAttribute( 'data-cdp-uuid', '8ac23bbf-5e59-4635-92f6-a477ea45542b' );
        wf.setAttribute( 'data-region', 'europe-west1' );
        s.parentNode.insertBefore(wf, s);
    }
    downloadJSAtOnload();
})(document);
