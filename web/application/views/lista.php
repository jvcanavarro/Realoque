<div class="outter">
    <div class="inner">

    <div class="lista-container">
        <h5>Imóveis no bairro <?php echo urldecode($bairro) ?> </h5>
        <div id="cifras"></div>
        <div id="lista">

        </div>
    </div>
        
    </div>
</div>

<script src="<?php echo base_url('assets/scripts/lista.js')?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/estilo/lista.css')?>">
<script>
    lista('<?php echo $bairro ?>')
</script>