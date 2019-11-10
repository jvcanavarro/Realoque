<div class="outter">
<div class="inner">

    <style>
        /* Always set the map height explicitly to define the size of the div
        * element that contains the map. */
        #map {
            height: 400px;
            display: block;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        </style>
    <div id="map" style="margin-top:100px; z-index:1"></div>
    <div class="sample">
    
    </div>
   
    <script src="<?php echo base_url('assets/scripts/load-sample.js')?>"></script>
    <script>
        load(<?php echo $index ?>)
    </script>
    <link rel="stylesheet" href="<?php echo base_url('assets/estilo/sample.css')?>">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2vox7tWi6HYRBYMvsMglemfdoDImLRUQ"
    async defer></script>
</div>
</div>