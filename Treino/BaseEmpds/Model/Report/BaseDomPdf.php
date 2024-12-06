<?php

namespace BaseEmpds\Model\Report;

require_once DIR_ROOT . '/' . DIR_LIBS . '/dompdf2.0/autoload.php'; // Inicia o DomPdf 2.0

use BaseEmpds\Entity\Interfaces\FileInterface;
use BaseEmpds\Model\UserDataSession;
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * Esta classe é responsável por gerar relatórios em PDF, utilizando a biblioteca DomPdf em uma versão mais atualziada.
 */
class BaseDomPdf
{

  const DOWNLOAD_PDF              = 1;
  const NEW_TAB_PDF               = 0;
  const PDF_ORIENTATION_PORTRAIT  = 'portrait';
  const PDF_ORIENTATION_LANDSCAPE = 'landscape';
  const PDF_PAPER_SIZE_A4         = 'A4';
  const PDF_PAPER_SIZE_A5         = 'A5';
  const PDF_FONT_ARIAL            = 'Arial';
  const PDF_FONT_TIMES_NEW_ROMAN  = 'Times New Roman';
  const PDF_FONT_COURIER          = 'Courier';	
  const PDF_FONT_HELVETICA        = 'Helvetica';
  const IMAGE_EXTENSIONS          = ['jpg', 'jpeg', 'png', 'bmp', 'svg'];

  private $htmlContent;

  private $domPdf;

  private $title;

  private $logoImage;

  private $content;

  private $options;

  private $pdfOrientation;

  private $pdfPaperSize;

  private $isRender;
  /** 
   * Método responsável por executar o processo de preparação e criação do pdf.
   * @return void
   */
  public function execute()
  {
    $this->prepareReport();
    $this->generateReport();
  }

  /**
   * Método responsável por gerar o relatório em pdf.
   *
   * @return void
   */
  protected function generateReport()
  {
    $this->makeHtmlContent();
    $this->loadHtml();
    $this->initPdfPaper();
    $this->renderPdf();
  }
  /**
   * Método responsável por renderizar o pdf.
   *
   * @return void
   */
  protected function renderPdf()
  {
    $this->getDomPdf()->render();
    $this->isRender = true;
  }
  /**
   * Método que prepara o relatório para ser gerado, deve ser sobrescrito pela classe filha.
   *
   * @return void
   */
  protected function prepareReport()
  {
  }

  /**
   * Define a orientação do pdf
   *
   * @param string $orientation
   * @return object
   */
  protected function setPdfOrientation($orientation)
  {
    $this->pdfOrientation = $orientation;
    return $this;
  }

  /**
   * Define o tamanho do papel do pdf
   *
   * @param string $paperSize
   * @return object
   */
  protected function setPdfPaperSize($paperSize)
  {
    $this->pdfPaperSize = $paperSize;
    return $this;
  }

  /**
   * Retorna a orientação do pdf
   *
   * @return string
   */
  public function getPdfOrientation()
  {
    if (!$this->pdfOrientation) {
      $this->pdfOrientation = self::PDF_ORIENTATION_PORTRAIT;
    }
    return $this->pdfOrientation;
  }

  /**
   * Retorna o tamanho do papel do pdf
   *
   * @return string
   */
  public function getPdfPaperSize()
  {
    if (!$this->pdfPaperSize) {
      $this->pdfPaperSize = self::PDF_PAPER_SIZE_A4;
    }
    return $this->pdfPaperSize;
  }

  /**
   * Define a orientação e o tamanho do papel no pdf na instância do DomPdf baseado nos valores definidos anteriormente.
   *
   * @return void
   */
  protected function initPdfPaper()
  {
    $this->getDomPdf()->setPaper($this->getPdfPaperSize(), $this->getPdfOrientation());
  }

  /**
   * Carrega o html definido no atributo content para instância do DomPdf.
   *
   * @return void
   */
  protected function loadHtml()
  {
    $this->getDomPdf()->loadHtml($this->content);
  }

  /**
   * Undocumented function
   *
   * @param string $fileName
   * @param int $download
   * @return void
   */
  public function streamPdf($fileName = 'document', $download = self::NEW_TAB_PDF)
  {
    if (!$this->isRender) {
      $this->renderPdf();
    }
    $this->getDomPdf()->stream($fileName, array("Attachment" => $download));
  }

  /**
   * Define o conteúdo html do relatório.
   *
   * @param string $htmlContent
   * @return object
   */
  public function setHtmlContent($htmlContent)
  {
    $this->htmlContent = $htmlContent;
    return $this;
  }

  /**
   * Define o título do relatório.
   *
   * @param string $title
   * @return object
   */
  public function setTitle($title)
  {
    $this->title = $title;
    return $this;
  }
  /**
   * Retorna o título do relatório.
   *
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Retorna o conteúdo html do relatório, pode ser sobrescrito pela classe filha.
   *
   * @return string
   */
  protected function getHtmlContent()
  {
    if (!$this->htmlContent) {
      $this->htmlContent = "";
    }
    return $this->htmlContent;
  }

  /**
   * Retorna a instância do DomPdf.
   *
   * @return object
   */
  protected function getDomPdf()
  {
    if (!$this->domPdf) {
      $this->options ? $this->domPdf = new Dompdf($this->options) : $this->domPdf = new Dompdf();
    }
    return $this->domPdf;
  }

  /**
   * Retorna a instância do DomPdfOptions, que é usada para definir as opções na instância dompdf.
   *
   * @return object
   */
  protected function getDomPdfOptions()
  {
    if (!$this->options) {
      $this->options = new Options();
    }
    return $this->options;
  }

  /**
   * Define a fonte padrão do pdf.
   *
   * @param string $defaultFont
   * @return void
   */
  protected function setDefaultFont($defaultFont = self::PDF_FONT_ARIAL)
  {
    $this->getDomPdfOptions()->set('defaultFont', $defaultFont);
  }

  /**
   * Define a imagem para o cabeçalho do pdf.
   *
   * @param string $imageName
   * @return object
   */
  public function setLogoImage($imageName)
  {
    $this->logoImage = $imageName;
    return $this;
  }

  /**
   * Retorna o nome da imagem do cabeçalho do pdf.
   *
   * @return string
   */
  public function getLogoImage()
  {
    if (!$this->logoImage) {
      $this->logoImage = "logo.png";
    }
    return $this->logoImage;
  }

  /**
   * Realiza a encodificação da imagem do cabeçalho do pdf, e a retorna em base64.
   *
   * @return string
   */
  protected function getEncodedLogoImage()
  {
    $path = DIR_SYS . '/imagens/' . DEFAULT_APP . '/' . $this->getLogoImage();
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
  }

  /**
   * Retorna o conteúdo html de um arquivo.
   *
   * @param string $fileName
   * @param string $dir
   * @param string $app
   * @return string
   */
  protected function loadHtmlContent($fileName, $dir = null, $app = DEFAULT_APP)
  {
    if (is_null($dir)) {
      $dir = DIR_MODULES . "/" . $app . '/View/Report/';
    }

    return file_get_contents($dir . $fileName . ".html");
  }

  /**
   * Retorna o conteúdo html de um arquivo usado para o Header do relatório.
   *
   * @return string
   */
  protected function getHeader()
  {
    $path = DIR_MODULES . "/" . DEFAULT_APP . '/BaseEmpds/View/Report/header.html';
    return file_get_contents($path);
  }

  /**
   * Cria o Header do relatório, substituindo as variáveis definidas no arquivo header.html para a imagem e o titulo.
   *
   * @return string
   */
  protected function makeHeader()
  {
    $header = strtr($this->getHeader(), array(
      '{TITULO}'  => $this->getTitle(),
      '{IMG_URL}' => $this->getEncodedLogoImage()
    ));
    return $header;
  }

  /**
   * Retorna o conteúdo html de um arquivo usado para o Body do relatório.
   *
   * @return string
   */
  protected function getBody()
  {
    $path = DIR_MODULES . "/" . DEFAULT_APP . '/BaseEmpds/View/Report/body.html';
    return file_get_contents($path);
  }

  /**
   * Cria o Body do relatório, substituindo as variáveis definidas no arquivo body.html para o conteúdo do relatório.
   *
   * @return string
   */
  protected function makeBody()
  {
    $body = strtr($this->getBody(), array(
      '{CONTEUDO}' => $this->getHtmlContent()
    ));
    return $body;
  }

  /**
   * Retorna o conteúdo html de um arquivo usado para o Footer do relatório.
   *
   * @return string
   */
  protected function getFooter()
  {
    $path = DIR_MODULES . "/" . DEFAULT_APP . '/BaseEmpds/View/Report/footer.html';
    return file_get_contents($path);
  }

  /**
   * Cria o Footer do relatório, substituindo as variáveis definidas no arquivo footer.html para o nome do sistema, data e hora e nome do usuário.
   *
   * @return string
   */
  protected function makeFooter()
  {
    $footer = strtr($this->getFooter(), array(
      '{NOME_APP}'     => DEFAULT_APP,
      '{DATA_HORA}'    => date('d/m/Y H:i:s'),
      '{NOME_USUARIO}' => UserDataSession::getNome(),
    ));
    return $footer;
  }

  /**
   * Cria o conteúdo html do relatório, concatenando o Header, Body e Footer.
   *
   * @return string
   */
  protected function makeHtmlContent()
  {
    $this->content .= $this->makeHeader();
    $this->content .= $this->makeBody();
    $this->content .= $this->makeFooter();
  }

  /**
   * Recebe uma entidade arquivo como parâmetro e 
   * retorna uma imagem html com source em base64 
   *
   * @param BaseEmpds\Entity\Interfaces\FileInterface $fileEntity
   * @return string
   */
  protected function getHtmlImageFromFile(FileInterface $fileEntity) 
  {
    $sep = DIRECTORY_SEPARATOR;
    if(!in_array($fileEntity->getExtension(), BaseDomPdf::IMAGE_EXTENSIONS, true)) {
      return '';    
    }
    $filePath = $fileEntity->getPath();
    $fileName = $fileEntity->getUniqueName();
    $imagePath = DIR_FILES. $sep . DEFAULT_APP . $sep . DIR_NAME_DOWNLOADS . $sep . $filePath . '/' . $fileName;
    $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
    $imageData = file_get_contents($imagePath);
    $imageURLEncoded = 'data:image/'. $imageType . ';base64,' . base64_encode($imageData);
    return '<img src="' . $imageURLEncoded . '"/>';
  } 
}
