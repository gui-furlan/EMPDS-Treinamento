<?php

namespace BaseEmpds\Model\Report;

require_once DIR_ROOT . '/' . DIR_LIBS . '/fpdf182/fpdf.php'; // Inicia o FPDF

use FPDF;
use Geral\Model\UserSession;

class BaseReportPdf extends FPDF
{

    //Formatações Mínimas
    const FONTE          = "Arial";
    const ESTILO_PADRAO  = "";
    const ESTILO_ITALICO = "I";
    const ESTILO_NEGRITO = "B";
    const BORDA_ATIVA    = 1;
    const BORDA_INATIVA  = 0;
    const LINHA_NOVA     = 1;
    const LINHA_CONTINUA = 0;

    //Alinhamentos
    const ALINHA_CENTRO  = "C";
    const ALINHA_DIR     = "R";
    const ALINHA_ESQ     = "L";
    const TAMANHO_LINHA  = 190;

    /* Tipo de Output: Como o PDF será aberto (Valor padrão: I)
     *   I - Abre no navegador
     *   D - Força o download
     *   F - Salva local na pasta do projeto (não recomendado)
     *   S - Retorna o arquivo em formato String
     */
    const OUTPUT_NAVEGADOR = "I";
    const OUTPUT_DOWNLOAD  = "D";

    //Tipos de orientação
    const ORIENTACAO_LANDSCAPE = "L";
    const ORIENTACAO_PORTRAIT  = "P";

    /**
     * @var integer
     */
    protected $nroLinhas = 18;

    /**
     * @var string
     */
    protected $titulo;

    /**
     * @var string
     */
    protected $textoFiltro;

    /**
     * @var array
     */
    protected $dados;

    public function __construct($orientacao='P')
    {
        parent::__construct($orientacao);
        //Define as configurações padrões para o relatório
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetAutoPageBreak(true);
        $this->configuraRelatorio();
    }

    /**
     * Define o título do relatório
     * @param string $titulo
     */
    public function setTitulo($titulo){
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Define o filtro do relatório
     * @param string $titulo
     */
    public function setTextoFiltro($textoFiltro){
        $this->textoFiltro = $textoFiltro;
    }

    /**
     * Define o dados do relatório
     * @param array $titulo
     */
    public function setDados($dados){
        $this->dados = $dados;
    }

    /**
     * Realiza a montagem do relatório
     * @return void
     */
    public function montaPdf()
    {
        $this->preparaRelatorio();
        $this->montaCabecalho();
        $this->montaCorpo();
        $this->montaRodape();
    }


    /**
     * Realiza a exportação do relatório
     * @param string $output
     * @return void
     */
    public function exportarRelatorio($output)
    {
        $this->Output($output);
    }

    /**
     * Realiza configurações gerais no relatórios após o construtor
     * @return void
     */
    protected function configuraRelatorio(){
    }

    /**
     * Função de preparação do relatório
     * @return void
     */
    protected function preparaRelatorio(){
    }

    /**
     * Monta imagem do cabeçalho
     */
    protected function montaImagemCabecalho(){
        $imagem     = DIR_SYS. '/imagens/' . DEFAULT_APP .  "/logo-report.jpg";
        if(!empty($imagem)){
            $this->Image($imagem, 10, 10, $this->getLarguraImagemCabecalho(), $this->getAlturaImagemCabecalho());
        }
    }

    protected function getLarguraImagemCabecalho(){
        return 50;
    }

    protected function getAlturaImagemCabecalho(){
        return 30;
    }

    /**
     * Realiza a criação do cabeçalho do relatório
     * @return void
     */
    protected function montaCabecalho()
    {   
        //Insere a imagem
        $this->montaImagemCabecalho();

        //Define a fonte do título
        if($this->titulo){
            $this->SetFont(self::FONTE, self::ESTILO_NEGRITO, 15);
            //Insere o título
            $this->Cell(167, 12, $this->titulo, self::BORDA_INATIVA, self::LINHA_CONTINUA, self::ALINHA_CENTRO);
        }

        //Insere a parte de filtros
        if($this->textoFiltro){
            $this->Ln(0);
            
            $this->SetFont(self::FONTE, self::ESTILO_PADRAO, 10);
            $this->Cell(180, 22, "Filtro(s): " . $this->textoFiltro, self::BORDA_INATIVA, self::LINHA_CONTINUA, self::ALINHA_CENTRO);
        }
    }

    /**
     * Realiza a montagem do corpo do relatório
     * @return void
     */
    protected function montaCorpo()
    {
    }

    /**
     * Realiza a criação do rodapé do relatório
     * @return void
     */
    protected function montaRodape()
    {
        $this->SetY(-20);
        $this->SetFont(self::FONTE, self::ESTILO_PADRAO, 8);
        $this->Ln(5);
        $this->Cell(0, 8, "Emitido pelo Sistema (".DEFAULT_APP.") da UDESC em: " . date('d/m/Y H:i:s'), self::BORDA_INATIVA, self::LINHA_CONTINUA, self::ALINHA_DIR);
        $this->Ln(5);
        $this->Cell(0, 8, "Usuário: " . UserSession::getParam('nome'), self::BORDA_INATIVA, self::LINHA_CONTINUA, self::ALINHA_DIR);
    }

    /**
     * Imprime a falta de dados para o relatório
     * É chamado apenas nos filhos e usa-se um override deste método para trocar a mensagem correspondente
     */
    protected function naoHaDados($options = []){
        $this->Cell(100, 10, "Não há dados correspondentes para este relatório!");
    }
}