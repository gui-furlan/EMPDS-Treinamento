<?php

namespace BaseEmpds\Model\Report;

class BaseTableReportPdf  extends BaseReportPdf
{

    /**
     * @var mixed
     */
    protected $widthColumns;

    /**
     * @var array
     */
    protected $titleColumns;

    /**
     * Define o tamanho das colunas
     * @param mixed $widthColumns
     * @return void
     */
    public function setWidthColumns($widthColumns){
        $this->widthColumns = $widthColumns;
    }

    /**
     * Define as colunas da tabela
     * 
     * @param array $titleColumns
     * @return void
     */
    public function setTitleColumns($titleColumns){
        $this->titleColumns = $titleColumns;
    }

     /**
     * Realiza a montagem do corpo do relatório
     * @return void
     */
    protected function montaCorpo()
    {
        $this->montaTabela();
    }

    /**
     * Monta uma tabela com os dados repassados para o relatório
     * @param int $largura
     * @param string $titulos
     * @return void
     */
    protected function montaTabela()
    {
        // Display do conteúdo em tabela
        $this->montaTituloTabela();
        $this->montaCorpoTabela();
    }

    /**
     * Monta o corpo da tabela
     * @return void
     */
    protected function montaCorpoTabela(){
        $this->Ln(8);
        $this->SetFont(self::FONTE, self::ESTILO_PADRAO);
        $count = $this->nroLinhas;
        if($this->dados){
            foreach ($this->dados as $dado) {
                foreach ($dado as $d) {
                    if (!is_array($d))
                        $this->Cell($this->widthColumns, 7, $d, "B, L, R");
                }
                $this->Ln(7);
                if ($count != 0) {
                    $count--;
                } 
                else {
                    $this->montaRodape();
                    $this->AddPage();
                    $this->montaCabecalho();
                    $this->montaTituloTabela();
                    $this->Ln(7);
                    $this->SetFont(self::FONTE, self::ESTILO_PADRAO);
                    $count = $this->nroLinhas;
                }
            }
        }else{
            $this->naoHaDados();
        }
    }

    /**
     * Monta o título da tabela
     * @return void
     */
    protected function montaTituloTabela($sublinha=null){
        $this->Ln(10);
        //Criar os títulos das colunas
        $this->SetFont(self::FONTE, self::ESTILO_NEGRITO, 10);
        foreach ($this->titleColumns as $titulo) {
            $this->Cell($this->widthColumns, 7, $titulo, "B", 0, 'C');
        }

        //Display da sublinha
        if($sublinha){
            $this->Ln(9);
            $this->setFillColor(204, 204, 204);
            $this->Cell($this->widthColumns * count($this->titleColumns), 7, $sublinha, self::BORDA_INATIVA, 0, self::ALINHA_ESQ, true);
        }
    }

    /**
     * Imprime a falta de dados para o relatório
     * Override do método no pai
     */
    protected function naoHaDados($options = []){
        $this->Cell($this->widthColumns * count($this->titleColumns), 10, "Não há dados correspondentes para este relatório!");
    }
}
