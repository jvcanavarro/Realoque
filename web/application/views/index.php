<div class="outter back" >

<div class="inner">

	<div class="home search-containner">
	
    <h2>Interessado em um bairro específico?</h2>
    

		<select name="bairro" id="bairros">
    </select>
    
    <button id="busca" onclick="lista_bairro()" ><i class="fas fa-search"></i></button>

	</div>

</div>

</div>

<div class="outter">
  <div class="inner">
  <div class="home trending">
	
  <h2>Você pode estar interessado</h2>

  <div class="home ofertas"></div>

  <div id="lista"></div>

</div>
  </div>
</div>

<link rel="stylesheet" href="<?php echo base_url('assets/estilo/index.css')?>">
<script src="<?php echo base_url('assets/scripts/bairros.js')?>"></script>
<script src="<?php echo base_url('assets/scripts/trending.js')?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/estilo/lista.css')?>">