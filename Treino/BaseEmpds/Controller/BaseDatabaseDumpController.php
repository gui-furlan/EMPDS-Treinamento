<?php

namespace BaseEmpds\Controller;

use BaseEmpds\Model\Utils\DatabaseDump;
use Exception;

abstract class BaseDatabaseDumpController extends BaseController
{

    public function dump()
    {
        $now  = date("Y-m-d\TH:i:s") . substr((string)microtime(), 1, 8);
        $file = DIR_FILES . DIRECTORY_SEPARATOR . $this->url->getNameModule() . DIRECTORY_SEPARATOR . DIR_NAME_TEMP . DIRECTORY_SEPARATOR . 'database-' . $now . 'sql';

        try {
            $dump = new DatabaseDump('mysql:host=' . BD_HOST . ';dbname=' . BD_NAME, BD_USER, BD_PASSWORD, [
                'skip-comments' => true
            ]);
            $dump->setTableLimits(array(
                'log' => 1,
                'mailmessage' => 50,
            ));
            $dump->start($file);
        } catch (Exception $e) {
            $this->catchException('Erro ao realizar criação do arquivo de backup.', $e);
        }

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="database.sql"');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');

        echo file_get_contents($file);

        unlink($file);
    }
}
