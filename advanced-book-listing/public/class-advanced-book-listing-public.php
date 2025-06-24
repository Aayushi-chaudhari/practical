<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://google.com
 * @since      1.0.0
 *
 * @package    Advanced_Book_Listing
 * @subpackage Advanced_Book_Listing/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Advanced_Book_Listing
 * @subpackage Advanced_Book_Listing/public
 * @author     Aayushi Chaudhari <chaudhariaayushi10@gmail.com>
 */
class Advanced_Book_Listing_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
	$this->plugin_name = $plugin_name;
	$this->version = $version;

	add_shortcode( 'advanced_books', [ $this, 'render_books_listing' ] );
	add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
	add_action( 'wp_ajax_filter_books', [ $this, 'filter_books_ajax' ] );
	add_action( 'wp_ajax_nopriv_filter_books', [ $this, 'filter_books_ajax' ] );
}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advanced_Book_Listing_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Book_Listing_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advanced-book-listing-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advanced_Book_Listing_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Book_Listing_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-book-listing-public.js', array( 'jquery' ), $this->version, false );

	}
public function enqueue_assets() {
	wp_enqueue_style( 'advanced-books-style', plugin_dir_url( __FILE__ ) . 'css/style.css' );

	wp_enqueue_script( 'advanced-books-ajax', plugin_dir_url( __FILE__ ) . 'js/filter-books.js', [ 'jquery' ], null, true );
	wp_localize_script( 'advanced-books-ajax', 'books_ajax', [
		'ajax_url' => admin_url( 'admin-ajax.php' ),
	] );
}
public function render_books_listing() {
	ob_start();
	?>
	<div id="books-filters">
		<select id="author-letter">
			<option value="">Author Starts With</option>
			<?php foreach ( range( 'A', 'Z' ) as $char ) : ?>
				<option value="<?php echo $char; ?>"><?php echo $char; ?></option>
			<?php endforeach; ?>
		</select>

		<select id="price-range">
			<option value="">Select Price Range</option>
			<option value="50-100">$50 - $100</option>
			<option value="100-150">$100 - $150</option>
			<option value="150-200">$150 - $200</option>
		</select>

		<select id="sort-order">
			<option value="newest">Newest First</option>
			<option value="oldest">Oldest First</option>
		</select>
	</div>

	<div id="books-list"></div>
	<button id="load-more-books">Load More</button>
	<?php
	return ob_get_clean();
}
public function filter_books_ajax() {
	$page = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;
	$author_letter = sanitize_text_field( $_POST['author'] );
	$price = sanitize_text_field( $_POST['price'] );
	$sort = sanitize_text_field( $_POST['sort'] );

	$args = [
		'post_type' => 'book',
		'posts_per_page' => 5,
		'paged' => $page,
		'meta_query' => [],
		'orderby' => 'meta_value',
		'order' => $sort === 'oldest' ? 'ASC' : 'DESC',
		'meta_key' => '_book_publish_date',
	];

	if ( $author_letter ) {
		$args['meta_query'][] = [
			'key' => '_book_author',
			'value' => '^' . $author_letter,
			'compare' => 'REGEXP'
		];
	}

	if ( $price ) {
		list( $min, $max ) = explode( '-', $price );
		$args['meta_query'][] = [
			'key' => '_book_price',
			'value' => [ $min, $max ],
			'type' => 'NUMERIC',
			'compare' => 'BETWEEN',
		];
	}

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) : $query->the_post();
			$price = get_post_meta( get_the_ID(), '_book_price', true );
			$author = get_post_meta( get_the_ID(), '_book_author', true );
			$date = get_post_meta( get_the_ID(), '_book_publish_date', true );
			?>
			<div class="book-item">
				<h3><?php the_title(); ?></h3>
				<p>Author: <?php echo esc_html( $author ); ?></p>
				<p>Price: $<?php echo esc_html( $price ); ?></p>
				<p>Published: <?php echo esc_html( $date ); ?></p>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	else :
		echo '<p>No books found.</p>';
	endif;

	wp_die();
}


}
