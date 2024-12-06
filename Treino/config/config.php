<?php
// Busca automaticamente o nome do módulo pelo diretório onde está o arquivo config.php
$myModule = \Geral\Model\Config::getModuleDirName(__FILE__);

// Aqui são definidas as variáveis para o módulo no formato Array<nome da variável> => <valor da variável>
$config["title"] = "$myModule"; // Título que irá aparecer na barra superior da plicação
$config["blockTitle"] = "$myModule"; // Título que irá aparecer na lista de aplicações

/**
 * Definição do ícone que será exibido na lista de aplicações do menu superior
 *  [Opção 1]: blockIcon - será utilizado um ícone de glyphicon.
 *    A lista de ícones suportados pode ser acessada em https://getbootstrap.com/docs/3.3/components/#glyphicons
 *    Exemplo de uso: $config['blockIcon'] = 'cutlery';
 *  [Opção 2]: blockIconFA - será utilizado um ícone de FontAwesome (apenas ícones 'Free')
 *    A lista de ícones suportados pode ser acessada em https://fontawesome.com/icons?d=gallery
 *    OBS: utilizar a string completa da classe
 *    Exemplo de uso: $config['blockIconFA'] = 'fas fa-ghost';
 */
$config['blockIcon'] = 'tree-deciduous';

// #########################################################
// Configurações do serviço de autorização local de usuários
// #########################################################
//define($myModule.'_AUTHORIZER_TYPE', 'Config');

$config['baseAuthorizer'] = [
    'transactions' => [
        '04171018994' => ['view'], // CPF => Array de transações
        '00608031933' => ['view'] // CPF => Array de transações
    ]
];

// ###################################################################
// Configurações do serviço de autorização com dados de um WebService
// ###################################################################


//define($myModule.'_AUTHORIZER_TYPE', 'WebServer');


// ############################################################
// Configurações do Menu lateral (default: aberto)
// ############################################################

$config[$myModule . 'MenuOpened'] =  false;

// ############################################################
// Configurações do serviço de auditoria automática do sistema
// ############################################################

define($myModule . '_AUDIT_LEVEL', 'ALL');
//define($str.'_AUDIT_LEVEL', 'PRIVATE');


$config['authWebServer'] = [
    'url' => 'https://gia.dev.udesc.br/GIA/WS/obtemAcessos',
    'tokenSystem' => 'GIA',
    'tokenSecret' => '',
    'transactionsField' => 'transacoes',
    'dataField' => 'acessoDados'
];

// Transações suportadas pela aplicação
define($myModule . '_AUTHORIZER_TYPE', 'Local');

$config['transactions'] = [
    'admin' => [
        'titulo' => 'Administrador da aplicação',
        'descricao' => 'Pode realizar todas as ações da aplicação.'
    ],
    'adminUsers' => [
        'titulo' => 'Gerenciar usuários',
        'descricao' => 'Pode adicionar novos usuários e conceder permissões.'
    ],
    'desenvolvedor' => [
        'titulo' => 'Desenvolvedor',
        'descricao' => 'Pode acessar áreas restritas para fins de testes e desenvolvimento.'
    ],
    'consulta' => [
        'titulo' => 'Acesso somente leitura',
        'descricao' => 'Pode apenas visualizar os registros do sistema, sem poder modificá-los.'
    ]
];

//Carrega as transações específicas do sistema
\Treino\Model\Transactions::loadTransactions($config['transactions']);

$config['endpoints'] = [
    'GET' => [
        '/' . $myModule . '/WSv1/user' => [
            'to' => 'getAll',
            'titulo' => 'Retornar todos os usuários.',
            'descricao' => 'Este Endpoint faz a consulta por usuários e retorna todos os registros encontrados.'
        ],
        '/' . $myModule . '/WSv1/user/{id}' => [
            'to' => 'getById',
            'titulo' => 'Retornar dados de usuário.',
            'descricao' => 'Este Endpoint faz a consulta por um usuário específico e retorna seus dados.'
        ],
        '/' . $myModule . '/WSv1/user/{id}/teste/{nome}' => [
            'to' => 'getById',
            'titulo' => 'Retornar dados de usuário.',
            'descricao' => 'Este Endpoint faz a consulta por um usuário específico e retorna seus dados.'
        ]
    ],
    'POST' => [
        '/' . $myModule . '/WSv1/user' => [
            'to' => 'add',
            'titulo' => 'Adicionar usuários.',
            'descricao' => 'Este Endpoint permite a adição de usuários.'
        ],
        '/' . $myModule . '/WSv1/user/{id}' => [
            'to' => 'save',
            'titulo' => 'Atualizar dados do usuário.',
            'descricao' => 'Este Endpoint permite a atualização dos dados do usuário.'
        ]
    ],
    'DELETE' => [
        '/' . $myModule . '/WSv1/user/{id}' => [
            'to' => 'remove',
            'titulo' => 'Remover usuário.',
            'descricao' => 'Este Endpoint remove um usuário do sistema.'
        ]
    ]
];

/**
 * Parâmetros do usuários, cada parâmetro deve conter:
 * - descricao: string, descrição do parâmetro
 * - multiplosValores: boolean, informa se a preferência pode conter mais de um valor por usuário.
 * 
 * Se "multiplosValores" for true, então o valor do parâmetro sempre será um vetor.
 * - Exemplo de valores de um parâmetro não vazio: ["valor 1", valor 2"].
 * - Exemplo de valor de um parâmetro vazio: []
 * 
 * Se "multiplosValores" for false, então o valor será escalar.
 * - Exemplo de valor de um parâmetro não vazio: 'tema1'
 * - Exemplo de valor de um parâmetro vazio: null
 */
$config['userPreferences'] = [
    'defaultApp' => [
        'descricao' => 'Aplicação padrão do usuário.',
        'multiplosValores' => false
    ],
    'linksFavoritos' => [
        'descricao' => 'Links favoritos.',
        'multiplosValores' => true
    ],
    'fixaMenu' => [
        'descricao' => 'Fixa o menu lateral.',
        'multiplosValores' => false
    ],
    'tema' => [
        'descricao' => 'Tema da aplicação.',
        'multiplosValores' => false
    ]
];

define('ROOT_NAMESPACE',       DEFAULT_APP);

define('CONTROLLER_NAMESPACE', '\\' . ROOT_NAMESPACE  . '\\' . 'Controller\\');
define('ENTITY_NAMESPACE',     '\\' . ROOT_NAMESPACE  . '\\' . 'Entity\\');
define('MODEL_NAMESPACE',      '\\' . ROOT_NAMESPACE  . '\\' . 'Model\\');
define('TEST_NAMESPACE',       '\\' . ROOT_NAMESPACE  . '\\' . 'Test\\');
define('SEEDER_NAMESPACE',     '\\' . ROOT_NAMESPACE  . '\\' . 'Seeder\\');

define('REPOSITORY_NAMESPACE', MODEL_NAMESPACE . 'Repository\\');
define('VALIDATOR_NAMESPACE',  MODEL_NAMESPACE . 'Validator\\');
define('USE_CASE_NAMESPACE',  MODEL_NAMESPACE . 'UseCase\\');
define('SERVICE_NAMESPACE',  MODEL_NAMESPACE . 'Service\\');

define('NAME_FILE_ENTITY', 'Arquivo');

$menuFactory    = new \Treino\View\Menu\MenuFactory();
$config['menu'] = $menuFactory->loadOptions();
