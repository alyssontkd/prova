<?php

return array(
    'router' => array(
        'routes' => array(
            'questao-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/questao',
                    'defaults' => array(
                        'controller' => 'questao',
                        'action'     => 'index',
                    ),
                ),
            ),
            'rota_questao' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/questao-questao/:action[/:id][/:id_alternativa]',
                    'defaults' => array(
                        'controller' => 'questao-questao',
                        'action'     => 'index',
                    ),
                ),

            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'questao' => 'Questao\Controller\QuestaoController',
            'questao-questao' => 'Questao\Controller\QuestaoController',

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
