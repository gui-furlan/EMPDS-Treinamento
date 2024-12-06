<?php

namespace BaseEmpds\Model\Report;

require_once DIR_ROOT . '/' . DIR_LIBS . '/fpdf182/fpdf.php'; // Inicia o FPDF

use FPDF;

class BaseRelatorioPdf extends FPDF
{

    // ------------ Formatações Mínimas ------------ 
    const FONTE = "Arial";
    const ESTILO_PADRAO = "";
    const ESTILO_ITALICO = "I";
    const ESTILO_NEGRITO = "B";
    const BORDA_ATIVA = 1;
    const BORDA_INATIVA = 0;
    const LINHA_NOVA = 1;
    const LINHA_CONTINUA = 0;

    // Alinhamentos
    const ALINHA_CENTRO = "C";
    const ALINHA_DIR = "R";
    const ALINHA_ESQ = "L";
    const TAMANHO_LINHA = 190;

    /* Tipo de Output: Como o PDF será aberto
    * I - Abre no navegador
    * D - Força o download
    * F - Salva local na pasta do projeto (não recomendado)
    * S - Retorna o arquivo em formato String
    * Default - valor padrão I
    */
    const OUTPUT_NAVEGADOR = "I";
    const OUTPUT_DOWNLOAD = "D";

    const ORIENTACAO_LANDSCAPE = "L";
    const ORIENTACAO_PORTRAIT = "P";

    function __construct($orientacao)
    {
        parent::__construct($orientacao);

        $this->AliasNbPages();
        $this->AddPage();

        $this->SetAutoPageBreak(true);
    }

    // Cabeçalho
    public function montaCabecalho()
    {
        $imagem     = DIR_SYS. '/imagens/' . DEFAULT_APP .  "/logo-report.jpg";
        $larguraImg = '50';
        $alturaImg  = '30';

        // Imagem
        if (!empty($imagem)) {
            $this->Image($imagem, 10, 10, $larguraImg, $alturaImg);
        }
    }

    // Corpo
    public function montaCorpo()
    {
    }

    // Rodapé
    public function montaRodape()
    {
    }

    public function montaPdf()
    {
        $this->montaCabecalho();
        $this->montaCorpo();
        $this->montaRodape();
    }


    // Mostrar Relatório
    public function exportarRelatorio($output)
    {
        $this->Output($output);
    }
}
