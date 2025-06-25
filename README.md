=== Advanced Book Listing ===
Contributors: aayushi
Tags: books, custom post type, ajax, filters, pagination
Requires at least: 5.0
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A custom WordPress plugin to display books using a shortcode with filters (author, price, publish date) and AJAX pagination.

== Description ==

**Advanced Book Listing** is a lightweight and extendable plugin that allows site owners to:
- Register a custom post type for Books
- Store book details like author name, price, and publish date
- Use a shortcode [advanced_books] to render the book list
- Filter books by:
  - Author's first letter
  - Price range ($50–$200)
  - Publish date (Newest to Oldest or vice versa)
- Load more books using AJAX-based pagination

Perfect for libraries, bookstores, or any book catalog website.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/advanced-book-listing` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the ‘Plugins’ screen in WordPress.
3. A new “Books” menu will appear in the WordPress Dashboard.
4. Add new books and fill out Author Name, Price, and Publish Date fields.
5. Use the `[advanced_books]` shortcode on any post or page to display the book listing with filters.

== Frequently Asked Questions ==

= Can I customize the filters? =  
Yes, you can modify the plugin’s public class to adjust filters or ranges.

= Is the plugin compatible with any theme? =  
Yes, it is designed to work with most modern WordPress themes.

= Does it support Gutenberg? =  
The plugin supports shortcode blocks, and a Gutenberg block version is coming soon.

== Screenshots ==

1. Book listing with filters
2. Admin screen to add/edit books
3. AJAX pagination loading more results

== Changelog ==

= 1.0.0 =
* Initial release
* Book CPT with meta fields
* Shortcode with filters and AJAX pagination

== Upgrade Notice ==

= 1.0.0 =
Initial release of the plugin.

== License ==

This plugin is licensed under the GPL v2 or later.

== Credits ==

Developed by Aayushi Chaudhari
