<?php

return array(
    'router' => array(
        'routes' => array(
            'materia_semestre-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/materia_semestre',
                    'defaults' => array(
                        'controller' => 'materia_semestre',
                        'action'     => 'index',
                    ),
                ),
            ),
            'materia_semestre' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/materia_semestre-materiasemestre/:action[/:id_materia_semestre][/:id_classificacao_semestre][/:id_materia]',
                    'defaults' => array(
                        'controller' => 'materia_semestre-materiasemestre',
                        'action'     => 'index',
                    ),
                ),

            ),
            'alterar_materia_semestre' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/materia_semestre/:action[/:id_classificacao_semestre]',
                    'defaults' => array(
                        'controller' => 'materia_semestre-materiasemestre',
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
            'materia_semestre' => 'MateriaSemestre\Controller\MateriaSemestreController',
            'materia_semestre-materiasemestre' => 'MateriaSemestre\Controller\MateriaSemestreController',

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
