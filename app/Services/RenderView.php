<?php namespace App\Services;

class RenderView {

    public static function renderNode($node) {
        if( $node->isLeaf() ) {
            return '<li><span data-id="' . $node->id . '">' . $node->name . '</span></li>';
        } else {
            $html = '<li><span data-id="' . $node->id . '">' . $node->name . '</span>';

            $html .= '<ul>';

            foreach($node->children as $child)
                $html .= self::renderNode($child);

            $html .= '</ul>';

            $html .= '</li>';
        }

        return $html;
    }

}
