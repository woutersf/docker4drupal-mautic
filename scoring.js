
(function(d) {
    // attach script tag and defer
    function downloadJSAtOnload() {
        var wf = d.createElement('script'), s = d.scripts[0];
        wf.src = 'https://datacapture.dropsolid.com/8ac23bbf-5e59-4635-92f6-a477ea45542b/capture.js'
        wf.defer = true;
        s.parentNode.insertBefore(wf, s);
    }
    downloadJSAtOnload();
})(document);

window.dsdc = window.dsdc || function () { (dsdc.q = dsdc.q || []).push(arguments) }; dsdc.l = +new Date;

window.dsdc('beforeRequest', function (data) {
    // get capture data
    var changedCapture = data.requestData;

    if (changedCapture.event.te__eventType == "dom") {
        if (document.querySelector('meta[name="keywords"]') !== null) {
            ds_recipe = document.querySelector('meta[name="keywords"]').content.toLowerCase().replace(/[^a-z0-9]/gi, '_');

            // add scoring configuration
            changedCapture.scoring = {
                "ds_recipe": {
                }
            };

            changedCapture.scoring.ds_recipe[ds_recipe] = {
                "te__operator": "+",
                "te__value": "1"
            }

            // use a global function to pass the modified capture back to the main script
            dsdc.updateCapture(changedCapture);
        }
    }
});