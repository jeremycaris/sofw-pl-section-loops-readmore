<?php
/*

  Plugin Name:  PageLines Section Loops - Read More Extension
  Description:  Extends the Pagelines Platform 5 Loops addon with the [loops_excerpt_readmore] shortcode, which inserts the excerpt with a "Read More" link nicely displayed inline at the end the excerpt.

  Author:       Jeremy Caris
  Author URI:   https://714Web.com

  Version:      0.1

  PageLines:    SOFW_PL_Loops_Readmore_Section
  Filter:       content


  Category:     framework, sections, free, featured

  Tags:         loop, grid, magazine, taxonomy, posts, cpt


*/

if( ! class_exists('PL_Section') )
  return;

class SOFW_PL_Loops_Readmore_Section extends PL_Section{

    function section_persistent(){

      add_filter('pl_binding_' . $this->id, array( $this, 'callback'), 10, 2);

      $this->add_shortcodes();

      add_action( 'template_redirect', array( $this, 'check_post_object' ) );
    }


    function add_shortcodes() {
      add_shortcode( 'loops_excerpt_readmore', array( $this, 'loops_excerpt_readmore' ) );
    }


    function loops_excerpt_readmore( $atts ) {
       global $post;

       $defaults = array(
         'class'  => '',
         'length' => 25
       );
       $atts = shortcode_atts( $defaults, $atts );


      $out = sprintf('<div class="%s pl-loops-readmore-excerpt">%s<a href="%s"> (Read More)</a></div>',
        $atts['class'],
        pl_excerpt_by_id( $this->p->ID, $atts['length'] ),
        get_permalink( $this->p->ID )
      );

      return $out;
    }
}
