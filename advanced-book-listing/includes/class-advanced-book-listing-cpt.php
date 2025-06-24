<?php
class Advanced_Book_Listing_CPT {

	public function __construct() {
		add_action( 'init', [ $this, 'register_books_cpt' ] );
		add_action( 'add_meta_boxes', [ $this, 'add_books_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_books_meta' ] );
	}

	public function register_books_cpt() {
		$labels = [
			'name'               => 'Books',
			'singular_name'      => 'Book',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Book',
			'edit_item'          => 'Edit Book',
			'new_item'           => 'New Book',
			'all_items'          => 'All Books',
			'view_item'          => 'View Book',
			'search_items'       => 'Search Books',
			'not_found'          => 'No books found',
			'menu_name'          => 'Books',
		];

		$args = [
			'labels'             => $labels,
			'public'             => true,
			'has_archive'        => true,
			'show_in_rest'       => true,
			'supports'           => [ 'title', 'editor', 'thumbnail' ],
			'menu_position'      => 5,
			'menu_icon'          => 'dashicons-book',
		];

		register_post_type( 'book', $args );
	}

	public function add_books_meta_boxes() {
		add_meta_box( 'book_details', 'Book Details', [ $this, 'render_meta_box' ], 'book', 'normal', 'default' );
	}

	public function render_meta_box( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'book_nonce' );
		$author = get_post_meta( $post->ID, '_book_author', true );
		$price  = get_post_meta( $post->ID, '_book_price', true );
		$publish_date = get_post_meta( $post->ID, '_book_publish_date', true );
		?>
		<p><label>Author Name: <input type="text" name="book_author" value="<?php echo esc_attr( $author ); ?>" /></label></p>
		<p><label>Price ($): <input type="number" name="book_price" value="<?php echo esc_attr( $price ); ?>" /></label></p>
		<p><label>Publish Date: <input type="date" name="book_publish_date" value="<?php echo esc_attr( $publish_date ); ?>" /></label></p>
		<?php
	}

	public function save_books_meta( $post_id ) {
		if ( ! isset( $_POST['book_nonce'] ) || ! wp_verify_nonce( $_POST['book_nonce'], basename( __FILE__ ) ) ) {
			return $post_id;
		}

		update_post_meta( $post_id, '_book_author', sanitize_text_field( $_POST['book_author'] ) );
		update_post_meta( $post_id, '_book_price', floatval( $_POST['book_price'] ) );
		update_post_meta( $post_id, '_book_publish_date', sanitize_text_field( $_POST['book_publish_date'] ) );
	}
}
