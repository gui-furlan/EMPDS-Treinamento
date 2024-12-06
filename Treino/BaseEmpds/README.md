**Classes padrões para projetos do EMPDS que utilizarão o framework UDESC (UDEV)**

Comandos para configuração/atualização do projeto (Todos os comandos devem ser executados da raiz do projeto utilizado):

* Adicionar remote:
    
    *git remote add BaseEmpds https://code.udesc.br/CEAVI/empds/base-empds-udev.git*

* Adicionar vinculação dos repositórios:

    *git subtree add --prefix=modules/DEFAULT_APP/BaseEmpds/ BaseEmpds master --squash*

* Realizar um pull dos arquivos do repositório "filho":

    *git subtree pull --prefix=modules/DEFAULT_APP/BaseEmpds/ BaseEmpds master --squash*

* Realizar um push nos arquivos do repositório "filho":

    *git subtree push --prefix=modules/DEFAULT_APP/BaseEmpds/ BaseEmpds master*
