<?php

namespace Estrutura\Service;

class HtmlHelper
{
    public static function botaoLink($url, $icone, $attributos = [], $title = 'Alterar')
    {
        $attributos = self::arrayToString($attributos);

        $botao = '<a href="' . $url . '" ' . $attributos . '>
                     <button title="' . $title . '" type="button" class="btn btn-default">
                       <span class="' . $icone . '"></span>
                     </button>
                  </a>';

        return $botao;
    }

    public static function botao($id, $icone, $attributos = [], $title = 'Alterar')
    {
        $attributos = self::arrayToString($attributos);

        $botao = '<span ' . $attributos . ' rel="' . $id . '"> 
                    <button title="' . $title . '" type="button" class="btn btn-default">
                    <span class="' . $icone . '"></span> 
                    </button>
                    </span>';
        return $botao;
    }

    public static function botaoExcluirConfirm($id, $title = 'Excluir')
    {
        $attributos = ['class' => 'btn-excluir btn-xs', 'id' => 'botaoexcluir'];
        return self::botao($id, 'glyphicon glyphicon-remove-sign', $attributos, $title);
    }

    public static function botaoNovo($url, $title = 'Novo')
    {
        $attributos = ['class' => 'btn-novo btn-xs', 'id' => 'botaonovo'];
        return self::botaoLink($url, 'glyphicon glyphicon-remove-sign', $attributos, $title);
    }

    public static function botaoExcluir($url, $title = 'Excluir')
    {
        $attributos = ['class' => 'btn-excluir btn-xs', 'id' => 'botaoexcluir'];
        return self::botaoLink($url, 'glyphicon glyphicon-remove-sign', $attributos, $title);
    }

    public static function botaoDesativar($url, $title = 'Desativar', $icone_bootstrap = 'glyphicon glyphicon-off', $id = 'botaodesativar')
    {
        $attributos = ['class' => 'btn-desativar btn-xs', 'id' => $id];
        return self::botaoLink($url, $icone_bootstrap, $attributos, $title);
    }

    public static function botaoAlterar($url, $title = 'Alterar')
    {
        $attributos = ['class' => 'btn-alterar btn-xs', 'id' => 'botaoalterar'];
        return self::botaoLink($url, 'glyphicon glyphicon-edit', $attributos, $title);
    }

    public static function botaoAlterarCustomizado($url, $title = 'Modificar')
    {
        $attributos = ['class' => 'btn-alterar btn-xs btn-alterar-customizado', 'id' => 'botaomodificar'];
        return self::botaoLink($url, 'glyphicon glyphicon-user', $attributos, $title);
    }

    public static function botaoAcao($url, $title = 'A��o', $id = 'botaoacao', $icone_bootstrap = 'glyphicon glyphicon-screenshot', $classe = 'btn btn-default')
    {
        $attributos = ['class' => $classe, 'id' => $id];
        #$attributos = ['class'=>'btn-alterar btn-xs btn-alterar-customizado', 'id'=>$id];
        return self::botaoLink($url, $icone_bootstrap, $attributos, $title);
    }

    public static function botaoDownload($url, $title = 'A��o', $id = 'botaoacao', $icone_bootstrap = 'glyphicon glyphicon-screenshot', $classe = 'btn btn-default')
    {
        $attributos = ['class' => $classe, 'id' => $id];
        #$attributos = ['class'=>'btn-alterar btn-xs btn-alterar-customizado', 'id'=>$id];
        return self::botaoLink($url, $icone_bootstrap, $attributos, $title, " target='_blank'");
    }

    private static function arrayToString($array)
    {
        $string = '';
        foreach ($array as $chave => $item) {
            $string .= "{$chave}='{$item}' ";
        }
        return $string;
    }
}