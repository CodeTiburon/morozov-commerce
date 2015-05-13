<?php namespace App\Services;

class RenderView {

    public static function renderNode($node)
    {
        if ( $node->isLeaf() ) {
            return '<li><span data-id="' . $node->id . '">' . $node->name . '</span></li>';
        } else {
            $html = '<li><span data-id="' . $node->id . '">' . $node->name . '</span>';

            $html .= '<ul>';

            foreach($node->children as $child) {
                $html .= self::renderNode($child);
            }

            $html .= '</ul>';

            $html .= '</li>';
        }

        return $html;
    }

    public static function renderMenuNode($node, $ajax = true)
    {
        if ( $node->isLeaf() ) {
            if($ajax){
                return '<li><span data-id="' . $node->id . '">' . $node->name . '</li>';
            } else {
                return '<li><a href="' . URL('category') .'/'. $node->id . '" class="link">' . $node->name . '</a></li>';
            }
        } else {
            $html = '<li><span>' . $node->name . '  &#9658;</span>';

            $html .= '<ul>';

            foreach($node->children as $child) {
                $html .= self::renderMenuNode($child);
            }

            $html .= '</ul>';

            $html .= '</li>';
        }

        return $html;
    }

    public static function renderSelect($node, $categories = null)
    {
        $character = '&#8212;';

        if ( $node->isLeaf() ) {
            if ($categories && in_array($node->id, $categories)){
                return '<option value="' . $node->id . '" selected="selected">' . str_repeat($character, $node->depth) . $node->name . '</option>';
            } else {
                return '<option value="' . $node->id . '" >' . str_repeat($character, $node->depth) . $node->name . '</option>';
            }
        } else {
            $html = '<option value="' . $node->id . '" disabled="disabled">' . str_repeat($character, $node->depth) . $node->name . '</option>';

            foreach($node->children as $child)
                $html .= self::renderSelect($child, $categories);
        }

        return $html;
    }

    public static function renderBreadcrumbs($node, $categories = null)
    {
        $character = '&#8212;';

        if ( $node->isLeaf() ) {
            if ($categories && in_array($node->id, $categories)){
                return '<div value="' . $node->id . '" >' . str_repeat($character, $node->depth) . $node->name . '</div>';
            } else {
                return '';
            }
        } else {
            $html = '<div value="' . $node->id . '" display="none">' . str_repeat($character, $node->depth) . $node->name . '</div>';

            foreach($node->children as $child)
                $html .= self::renderBreadcrumbs($child, $categories);
        }

        return $html;
    }

}
