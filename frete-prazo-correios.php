<?php

/*
*
* Calculo de frete dos correios para varios itens
*
*/

class FretePrazo
{
	public function __construct($cdservico, $ceporigem, $cepdestino,  $peso, $comprimento,
		$altura, $largura,$diametro, $formato =  1, $maopropria = 'N',$valordeclarado = 0,
		$avisorecebimento = 'N', $tiporetorno = 'xml',$indicacalculo = 3)
	{
    	$url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$ceporigem."&sCepDestino=".$cepdestino."&nVlPeso=".$peso."&nCdFormato=".$formato."&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=".$maopropria."&nVlValorDeclarado=".$valordeclarado."&sCdAvisoRecebimento=".$avisorecebimento."&nCdServico=".$cdservico."&StrRetorno=".$tiporetorno."&nIndicaCalculo=".$indicacalculo;

    	$this->dados = simplexml_load_string(file_get_contents($url));
    }
}
	$fretes = array(
		array("item" => "Livro - Laravel",
			  "quantidade" => 2,
			  "peso" => 0.700,
			  "comprimento" => 24,
			  "altura" => 16,
			  "largura" => 16),
		array("item" => "Livro - Dev Android",
			  "quantidade" => 1,
			  "peso" => 0.200,
			  "comprimento" => 24,
			  "altura" => 17,
			  "largura" => 16),
	);
	foreach($fretes as $frete){
		$pesoTotal += $frete['peso'] * $frete['quantidade'];
		$comprimentoTotal += $frete['comprimento'];
		$alturaTotal += $frete['altura'];
		$larguraTotal += $frete['largura'];
	}
	$calculoCubicoTotal = round(pow($comprimentoTotal*$alturaTotal*$larguraTotal, (1/3)));

	$pac = new FretePrazo("41106", "59300000", "59300000", $pesoTotal, $calculoCubicoTotal, $calculoCubicoTotal, $calculoCubicoTotal);
	$sedex = new FretePrazo( "40010", "59300000", "59300000", $pesoTotal, $calculoCubicoTotal, $calculoCubicoTotal, $calculoCubicoTotal);

	if($pac->dados->cServico->Erro == 0){
		echo "PAC - {$pac->dados->cServico->Valor} <br>";
		echo "Prazo - {$pac->dados->cServico->PrazoEntrega} Dias <br><br>";

		echo "SEDEX - {$sedex->dados->cServico->Valor} <br>";
		echo "Prazo - {$sedex->dados->cServico->PrazoEntrega} Dias <br>";
	} else {
		echo "Ocorreu um erro ao efetuar a consulta.";
    	echo "Por favor, verifique seus dados antes de finalizar.";
	}