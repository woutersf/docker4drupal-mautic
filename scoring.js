/**************/
console.log('adding capturescript');
/**************/

(function (d) {
    // attach script tag and defer
    function downloadJSAtOnload() {
        var wf = d.createElement('script'), s = d.scripts[0];
        wf.src = 'https://datacapture.dropsolid.com/8ac23bbf-5e59-4635-92f6-a477ea45542b/capture.js'
        wf.defer = true;
        s.parentNode.insertBefore(wf, s);
    }

    downloadJSAtOnload();
})(document);

/**************/
console.log('adding recipes to scoring');
/**************/

window.dsdc = window.dsdc || function () {
    (dsdc.q = dsdc.q || []).push(arguments)
};
dsdc.l = +new Date;

window.dsdc('beforeRequest', function (data) {
    // get capture data
    var changedCapture = data.requestData;
    if (changedCapture.event.te__eventType == "js") {
        if (document.querySelector('meta[name="keywords"]') !== null) {
            ds_recipes = document.querySelector('meta[name="keywords"]').content.toLowerCase().split(',');
            ds_recipes.forEach(function (ds_recipe, index) {
                machine_name = ds_recipe.trim().replace(/[^a-z0-9]/gi, '_');
                console.log(machine_name);
                // add scoring configuration
                if (machine_name != "") {
                    changedCapture.scoring = {
                        "ds_recipe": {}
                    };

                    changedCapture.scoring.ds_recipe[machine_name] = {
                        "te__operator": "+",
                        "te__value": "1"
                    }

                    // use a global function to pass the modified capture back to the main script
                    dsdc.updateCapture(changedCapture);
                }

            });


        }
    }
});