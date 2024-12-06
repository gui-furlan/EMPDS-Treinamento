<?php

namespace BaseEmpds\Controller\Traits;

/**
 * Trait para adicionar a um BaseController a função de interagir com arquivos
 * @author Glauco David Laicht
 */
trait FileController{

    protected function saveFile($sFile){
        //se o arquivo existe então nao é necessário move-lo para a pasta de upload e apenas retorna
        if($this->getFileRepository()->fileExists($sFile) || (empty($sFile))){
            return;
        }

        // Salvar novo arquivo.
        try{
            $this->getFileRepository()->moveUploadToDownload($sFile);
        }
        catch (\Exception $e){
            $this->catchException('Não foi possível salvar o arquivo "' . $sFile, $e);
            $this->sendResponse();
        }
    }

    protected function getFileContentFromTemp($sFileName){
        return $this->getFileContentBase64($this->getFileRepository()->getUploadPath($sFileName));
    }

    protected function getFileContentFromDownload($sFileName){
        return $this->getFileContentBase64($this->getFileRepository()->getDownloadPath($sFileName));
    }

    protected function getFileContentBase64($sFileName){
        return base64_encode(file_get_contents($sFileName));
    }

    /**
     *  Remove o arquivo da pasta de downloads caso ele exista na mesma 
     */
    public function removeFile(){
        $iId       = $this->url->getSegment(4);
        if (empty($iId)) {
            $this->setError('Não foi encontrado registro vinculado ao arquivo');
            $this->sendResponse();
        }

        $inputName = $this->request->post('inputName');
        try{
            //Faz o carregamento da entidade
            $this->entity = $this->getRepository()->getById($iId);
            if ($this->entity) {
                $method = 'get' . ucfirst($inputName);
                if (method_exists($this->entity, $method)) {
                    //Nome do arquivo
                    $fileName  = call_user_func_array([$this->entity, $method], []);
                    if ($fileName) {
                        $this->getFileRepository()->removeDownload($fileName);
                    }
                }
                //Desvincula o arquivo do registro
                $methodSet = 'set' . ucfirst($inputName);
                if (method_exists($this->entity, $methodSet)) {
                    call_user_func_array([$this->entity, $methodSet], [null]);
                    $this->getRepository()->update($this->entity);
                }
            }
            $this->setSuccess('Arquivo removido com sucesso!');
            $this->sendResponse();
        }
        catch (\Exception $e){
            $this->catchException('Não foi possível excluir o arquivo.', $e);
            $this->sendResponse();
        }
    }
}