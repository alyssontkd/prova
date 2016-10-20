<?php

return array(
    'modules' => array(
        'Application',
        'Auth',
        'Estrutura', //Tem que vir antes dos demais módulos
        'Principal',
        'Email',
        'Perfil',
        'EsqueciSenha',
        'Config',
        'Cidade',
        'Estado',
        'Sexo',
        'EstadoCivil',
        'TipoUsuario',
        'SituacaoUsuario',
        'Endereco',
        'Prova',
        'NivelDificuldade',
        'UnidadeTempo',
        'Temporizacao',
        'Fonte',
        'Classificacao',
        'CompactAsset', //Compacta o Javascript e CSS para retornar em apenas uma requisição (Responsável pela minificar o css e js: compila os arquivos em um só)
        'DOMPDFModule',
        //Ronaldo 02/03/2016 - Responsável por melhorar o desempenho da aplicação
        'EdpSuperluminal', //http://dev.ejur.com.br/?EDPSUPERLUMINAL_CACHE - Execute isso na URL para compilar os arquivos e ficar mais rapido - em cada requisição, em vês de baixar em tempo de execução cada require do autoload, ele salva um unico arquivo, minificado, com todas as classes dentro
        'Gerador',
        'Login',
        #'PhpBoletoZf2',
        'Situacao',
        'Telefone',
        'TipoTelefone',
        'Controller',
        'Action',
        'Permissao',
        'PeriodoLetivo',
        'DetalhePeriodoLetivo',
        'Materia',
        'TipoQuestao',
        'AssuntoMateria',
        'PerfilControllerAction',
        'Infra',
        'MateriaSemestre',
        'Usuario',
        'Questao',
        'AlternativaQuestao',
        'Relatorio',
        'Prova',
        'QuestoesProva',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,' . APPLICATION_ENV . '}.php'            
        ),
    ) 
);
