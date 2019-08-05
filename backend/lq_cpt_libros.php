<?php 

if ( ! function_exists('lq_books') ) {

// Register Custom Post Type
function lq_books() {

	$labels = array(
		'name'                  => _x( 'Libros', 'Post Type General Name', 'lq' ),
		'singular_name'         => _x( 'Libro', 'Post Type Singular Name', 'lq' ),
		'menu_name'             => __( 'Libros', 'lq' ),
		'name_admin_bar'        => __( 'Libro', 'lq' ),
		'archives'              => __( 'Archivo de libros', 'lq' ),
		'attributes'            => __( 'Atributos del libro', 'lq' ),
		'parent_item_colon'     => __( 'Parent Item:', 'lq' ),
		'all_items'             => __( 'Todos los libros', 'lq' ),
		'add_new_item'          => __( 'Agregar nuevo libro', 'lq' ),
		'add_new'               => __( 'Agregar nuevo', 'lq' ),
		'new_item'              => __( 'Nuevo libro', 'lq' ),
		'edit_item'             => __( 'Editar libro', 'lq' ),
		'update_item'           => __( 'Actualizar libro', 'lq' ),
		'view_item'             => __( 'Ver libro', 'lq' ),
		'view_items'            => __( 'Ver libros', 'lq' ),
		'search_items'          => __( 'Buscar libro', 'lq' ),
		'not_found'             => __( 'No se encuentra', 'lq' ),
		'not_found_in_trash'    => __( 'No se encuentra en la papelera', 'lq' ),
		'featured_image'        => __( 'Imagen de Portada', 'lq' ),
		'set_featured_image'    => __( 'Colocar imagen de portada', 'lq' ),
		'remove_featured_image' => __( 'Quitar imagen de portada', 'lq' ),
		'use_featured_image'    => __( 'Usar como imagen de portada', 'lq' ),
		'insert_into_item'      => __( 'Insertar en el libro', 'lq' ),
		'uploaded_to_this_item' => __( 'Cargado en este libro', 'lq' ),
		'items_list'            => __( 'Lista de libros', 'lq' ),
		'items_list_navigation' => __( 'Navegación de lista de libros', 'lq' ),
		'filter_items_list'     => __( 'Filtro de lista de libros', 'lq' ),
	);
	$args = array(
		'label'                 => __( 'Libro', 'lq' ),
		'description'           => __( 'Libros de La Qarmita', 'lq' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'libreria',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		'rest_base'             => 'lqlibros',
	);
	register_post_type( 'libros', $args );

}
add_action( 'init', 'lq_books', 0 );

}