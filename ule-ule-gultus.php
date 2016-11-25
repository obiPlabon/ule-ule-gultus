<?php
/**
 * Plugin Name: Ule Ule Gultus
 * Plugin URI: http://obiPlabon.im/
 * Description: I am a learning purpose plugin. You can use me as a referecne to learn to add help tab.
 * Author: Obi Plabon
 * Author URI: http://obiPlabon.im/
 * Version: 1.0.0
 * License: GPLv2 or later
 * Text Domain: ule-ule-gultus
 */

class Ule_Ule_Gultus {

    public function __construct() {
        add_action( 'admin_menu', [$this, 'add_uug_page'] );
        
        add_action( 'load-post.php', [$this, 'add_post_screen_help_tab'] );
        add_action( 'load-post-new.php', [$this, 'add_post_screen_help_tab'] );

        add_action( 'in_admin_header', [$this, 'run_remove_tab'] );
    }

    /**
     * Adding a custom page
     */
    public function add_uug_page() {
        $uug_page_id = add_menu_page(
            esc_html__( 'Ule Ule Gultus', 'ule-ule-gultus' ), //page title
            esc_html__( 'UUG', 'ule-ule-gultus' ), //menu title
            'manage_options', //capability
            'ule-ule-gultus', //slugs
            [$this, 'render_uug_page'], //callback function
            'dashicons-universal-access', //icon
            80 //position
            );

        add_action( "load-{$uug_page_id}", [$this, 'add_help_tab'] );
    }

    public function render_uug_page() {
        echo '<h1>Ule Ule Gultus Page</h1>'
            . '<p>Ule Ule Gultus page content</p>';
    }

    /**
     * Adding help tab and sidebar on Ule Ule Gultus page
     */
    public function add_help_tab() {
        $screen = get_current_screen();

        $tabs = [
            [ 
                'id' => 'uug-tab-1',
                'title' => esc_html__( 'UUG Help Tab 1', 'ule-ule-gultus' ),
                'content' => sprintf('<p>%1$s</p>', esc_html__( 'Tab 1: Hi, I am help content. Make me concise.', 'ule-ule-gultus' ) ),
            ],
            [ 
                'id' => 'uug-tab-2',
                'title' => esc_html__( 'UUG Help Tab 2', 'ule-ule-gultus' ),
                'content' => sprintf('<p>%1$s</p>', esc_html__( 'Tab 2: Hi, I am help content. Make me concise.', 'ule-ule-gultus' ) ),
            ],
            [ 
                'id' => 'uug-tab-3',
                'title' => esc_html__( 'UUG Help Tab 3', 'ule-ule-gultus' ),
                'content' => sprintf('<p>%1$s</p>', esc_html__( 'Tab 3: Hi, I am help content. Make me concise.', 'ule-ule-gultus' ) ),
            ]
        ];

        foreach ( $tabs as $tab ) {
            $screen->add_help_tab($tab);
        }

        $screen->set_help_sidebar(
            esc_html__( 'Sidebar content', 'ule-ule-gultus' )
            );
    }

    public function add_post_screen_help_tab() {
        get_current_screen()->add_help_tab([
            'id' => 'uug-post-tab-1',
            'title' => esc_html__( 'UUG Post Tab 1', 'ulu-ule-gultus' ),
            'content' => sprintf('<p>%1$s</p>', esc_html__( 'Tab 1: Hi, I am help content. Make me concise.', 'ule-ule-gultus' ) ),
            ]);
    }

    public function run_remove_tab() {
        global $pagenow;

        if ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) {
            //TADA, we're about to remove customize display
            //and title post editor help tab from post screen 
            $this->remove_help_tab();
        }

        if ( 'index.php' === $pagenow ) {
            // We are about to remove all tabs form dashboard
            $this->remove_help_tabs();
        }
    }

    protected function remove_help_tab() {
        $screen = get_current_screen();
        $screen->remove_help_tab( 'customize-display' );
        $screen->remove_help_tab( 'title-post-editor' );
    }

    protected function remove_help_tabs() {
        $screen = get_current_screen();
        $screen->remove_help_tabs();
    }

}

new Ule_Ule_Gultus();