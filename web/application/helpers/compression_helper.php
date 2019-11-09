<?php

	if(!function_exists('curve_aproximation')){

		/**Geração do sinal aproximado usando o PCA.
		 *
		 * Realiza a aproximação do sinal comprimido pelo PCA.
		 *
		 * @param array $comp_data Dados comprimidos por PCA ou APCA
		 * @return array Dados aproximados. (:, [VALOR])
		 */

		function curve_approximation(array $comp_data){

			# Alocando espaço e construindo índices do vetor aproximado
			$dec_idx = range(1, end($comp_data[0]));
			$dec_val = array_fill(0, end($comp_data[0]), 0);

			$dec_data = array(
				0 => $dec_idx,
				1 => $dec_val);

			$x1 = 1;

			$comp_idx = $comp_data[0];
			$comp_val = $comp_data[1];
			# Cada elemento do vetor de dados comprimido representa um segmento
			# do vetor original.
			for($i = 0; $i < sizeof($comp_val); $i++){
				$x2 = $comp_idx[$i];
				$y  = $comp_val[$i];
				# Segmento compreendido entre posições consecutivas do vetor
				# comprimido são preenchidas para o vetor de dados aproximados
				for($j = $x1; $j <= $x2; $j++){
					$dec_data[1][$j-1] = $y;
				}

				$x1 = $x2+1;
			}

			return $dec_data;
		}

	}

	if(!function_exists('pca')){

		/**PCA Compressão de dados utilizando Piecewise Constant Approximation.
		 *
		 * Realiza a compressão de dados usado o PCA (também conhecido como PAA -
		Piecewise Aggregate Approximation). O algoritmo divide os dados em
		janelas de tamanhos iguais e para cada uma é calculado o valor máximo e
		mínimo. Além disso, é necessário uma tolerância de erro que define quando
		os dados serão aproximados ou conservados. Isso é expresso por Max - Min
		< 2e. O tamanho da janela utilizado é window.
		 *
		 * @param string[] $data Vetor coluna com os dados originais.
		 * @param float $window Tamanho da janela
		 * @param string $epsilon Limiar de compressão.
		 * @return array|string Dados comprimidos
		 */

		function pca(array $data, float $window, string $epsilon){


			# Configurações de variáveis.
			# No PCA, os dados são comprimidos quando Max - Min <= 2e.
			$epsilon = 2 * $epsilon;

			# Se o array de dados só possui as medições, então criamos as ID's.
			$size = sizeof($data);

			if($size == 1){
				return $data;
			}elseif($size != 2){
				$data = array(
					0 => range(1,$size),
					1 => $data);
			}

			# Matriz com os dados comprimidos. Ele tem o mesmo tamanho da matriz
			# original. Ao final, cortamos o que não é necessário. (ID, DADOS)
			$comp_data = array(
				0 => range(1,$size),
				1 => range(1,$size));

			# Próxima posição vaga do array de dados comprimidos.
			$comp_index = 0;

			# Representa o início da janela
			$index = 0;

			# Algoritmo
			while($index < $size){

				# Última posição da janela de dados.
				$end_bucket = $index + $window - 1;

				# Se o final da janela passa o final dos dados, então a janela deve ir
				# do índice atual até o final dos dados.
				if($end_bucket >= $size){
					$end_bucket = $size-1;
				}

				# Identifica o valor máximo e mínimo da janela.
				$dataSeg = array_slice($data[1],$index,$window);
				$Max = max($dataSeg);
				$Min = min($dataSeg);

				# Calcula a diferença.
				$dif = $Max - $Min;

				if($dif <= $epsilon){

					# Se a diferença for menor ou igual o erro máximo, então comprime.
					# A compressão consiste em guardar a ID e a aproximação dos dados,
					# que consiste em dif/2 + Min.
					$aproximated = $dif / 2 + $Min;
					$comp_data[0][$comp_index] = $end_bucket+1;
					$comp_data[1][$comp_index] = $aproximated;

					# Próxima posição vazia.
					$comp_index = $comp_index + 1;
				}else{

					# Caso contrário, preserva todos os ID's e dados.
					$time_stamp = range($index+1,$end_bucket+1);

					# Até onde vamos preencher o vetor de dados comprimidos.
					$length = $end_bucket - $index + 1;

					for($i = 0; $i < $length; $i++){

						$comp_data[0][$i+$comp_index] = $time_stamp[$i];
						$comp_data[1][$i+$comp_index] = $data[1][$i+$index];
					}

					# Próxima posição vazia.
					$comp_index = $comp_index+$length;
				}

				# Avança a janela.
				$index = $end_bucket + 1;
			}

			# Só vamos usar até onde inserimos dados comprimidos. O resto é descartado.
			$indices = array_slice($comp_data[0],0,$comp_index);
			$values  = array_slice($comp_data[1],0,$comp_index);

			$comp_data = array(
				0 => $indices,
				1 => $values);

			return $comp_data;
		}

	}

	if(!function_exists('apca')){

		/** APCA Compressão de dados usando o Adaptive PCA.
		 *
		 * O APCA funciona, em essência, como o PCA, com a diferença que a janela
		de dados possui tamanho variável. A janela cresce até que os dados
		quebrem o limiar de compressão. Os dados, então, são aproximados por
		Dif/2 + Min. Dados que são maiores que o limiar são preservados. O
		processo de descompressão é o mesmo do PCA.
		 *
		 * @param array $data Vetor coluna com os dados originais
		 * @param float $epsilon Limiar de compressão
		 * @return array Dados comprimidos. [ID, VALOR]
		 */

		function apca(array $data, float $epsilon){


			# Configurações de variáveis.
			# No PCA, os dados são comprimidos quando Max - Min <= 2e.
			$epsilon = 2 * $epsilon;

			# Início da janela de compressão.
			$start_window = 1;

			# Se o array de dados só possui as medições, então criamos as ID's.
			$size = sizeof($data);

			if($size == 1){
				return $data;
			}elseif($size != 2){
				$data = array(
					0 => range(1,$size),
					1 => $data);
			}

			# Matriz com os dados comprimidos. Ele tem o mesmo tamanho da matriz
			# original. Ao final, cortamos o que não é necessário. (ID, DADOS)
			$comp_data = array(
				0 => range(1,$size),
				1 => range(1,$size));

			# Índice com a linha atual da matriz dos dados comprimidos.
			$idx_comp = 1;

			# Algoritmo
			while($start_window <= $size){

				# Estamos na última posição e, logo, não há como haver mais janelas.
				# Então salvamos o último ponto e encerramos a compressão.
				if($start_window == $size){
					$comp_data[0][$idx_comp-1] = $data[0][$start_window-1];
					$comp_data[1][$idx_comp-1] = $data[1][$start_window-1];
					break;
				}

				# Tamanho inicial da janela.
				$window = 1;

				# Fim da janela de compressão.
				$end_window = $start_window + $window;

				# Identifica o valor máximo e mínimo da janela.
				$dataSeg = array_slice($data[1],$start_window-1,$window+1);
				$Max = max($dataSeg);
				$Min = min($dataSeg);
				$dif = $Max - $Min;

				# Variáveis auxiliares.
				$Min_ahead = $Min;
				$dif_ahead = $dif;
				$window_ahead = $window;
				$end_window_ahead = $end_window;

				$made_loop = false;

				# Enquanto a diferença for menor ou igual que o threshold, então
				# aumenta o tamanho da janela.
				while(($dif_ahead < $epsilon) && ($end_window_ahead < $size-1)){
					# Aceita os valores da janela anterior pois não passaram o limiar.
					$Min    = $Min_ahead;
					$dif    = $dif_ahead;
					$window = $window_ahead;
					$end_window = $end_window_ahead;

					# Calcula a diferença da janela atual.
					$dataSeg   = array_slice($data[1],$start_window-1,$window+1);
					$Max_ahead = max($dataSeg);;
					$Min_ahead = min($dataSeg);
					$dif_ahead = $Max_ahead - $Min_ahead;

					# Aumenta a janela.
					$window_ahead = $window_ahead + 1;

					# Atualiza o limite final da janela.
					$end_window_ahead = $start_window + $window_ahead;

					$made_loop = true;
				}

				//if($made_loop){
					//$end_window--;
				//}

				# Retira o excedente do limite final, caso tenhamos passado.
				if($end_window > $size){
					$end_window = $size;
				}

				# Flag indicando se houve (1) ou não (0) compressão.
				$comprimiu = 0;

				# Compressão
				# Agora que temos uma janela cujos valores estão abaixo do threshold,
				# vamos representá-los por uma constante.
				if($window > 1){
					# Representa a janela por [ID; Dif/2 + Min].
					$comp_data[0][$idx_comp-1] = $data[0][$end_window-1];
					$comp_data[1][$idx_comp-1] = $dif/2 + $Min;
					# Próxima linha vazia.
					$idx_comp = $idx_comp + 1;

					$comprimiu = 1;
				}else{
					# Janela de tamanho 1. Se isso ocorreu é porque passamos o threshold
					# e temos que preservar os dados. Salva apenas a primeira amostra.
					$comp_data[0][$idx_comp-1] = $data[0][$start_window-1];
					$comp_data[1][$idx_comp-1] = $data[1][$start_window-1];
					# Próxima linha vazia.
					$idx_comp = $idx_comp + 1;
				}

				# Avança a janela
				if($comprimiu == 1){
					# Como comprimimos, já consideramos o início e o fim da janela.
					# Então descartamos o fim.
					$start_window = $end_window+1;
				}else{
					# Quando não comprimimos, só armazenamos o início da janela, por
					# isso incrementar o início da janela.
					$start_window = $start_window + 1;
				}
			}

			# Só vamos usar até onde inserimos dados comprimidos. O resto é descartado.
			$indices = array_slice($comp_data[0],0,$idx_comp);
			$values  = array_slice($comp_data[1],0,$idx_comp);

			$comp_data = array(
				0 => $indices,
				1 => $values);

			return $comp_data;
		}


	}
