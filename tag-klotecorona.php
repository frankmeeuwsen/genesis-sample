<?php

/**
 * Template Name: Klote corona
 * Description: Template for de Klote corona tag page
 */


get_header(); // displays header
remove_action('genesis_before_footer', 'genesis_footer_widget_areas'); //remove footer

remove_action('genesis_entry_header', 'genesis_post_info', 12);
remove_action('genesis_entry_footer', 'genesis_post_meta');

add_filter('genesis_post_info', 'corona_post_info_filter');
add_action('genesis_before_entry', 'genesis_post_info');

// remove_action('genesis_entry_content','genesis_do_post_content');
// add_action('genesis_entry_content', 'corona_post_content');

add_filter('single_tag_title', 'corona_title');

// Twee filters die er voor zorgen dat de volledige content zonder limiet wordt getoond. 
add_filter('genesis_pre_get_option_content_archive', 'cpt_change_content');
add_filter('genesis_pre_get_option_content_archive_limit', 'cpt_change_content_limit');

function cpt_change_content()
{
    return 'full';
}

function cpt_change_content_limit()
{
    return 0;
}

function corona_title(){
    $title = sprintf('Bekijk alles in corona');
    return $title;
}



function corona_post_info_filter($post_info){
    // build updated post_info
    $post_info = sprintf('<small class="coronadate">%s - <a href="%s">%s reactie(s)</a></small> ', get_the_time('j F Y, H:i'),get_permalink(), get_comments_number());
    return $post_info;
}

function corona_post_content(){
the_content(); 
}

genesis();
