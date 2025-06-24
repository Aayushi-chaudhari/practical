jQuery(document).ready(function($) {
	let page = 1;

	function loadBooks(reset = false) {
		const author = $('#author-letter').val();
		const price = $('#price-range').val();
		const sort = $('#sort-order').val();

		$.ajax({
			url: books_ajax.ajax_url,
			method: 'POST',
			data: {
				action: 'filter_books',
				author: author,
				price: price,
				sort: sort,
				page: page,
			},
			success: function(response) {
				if (reset) {
					$('#books-list').html(response);
				} else {
					$('#books-list').append(response);
				}
			}
		});
	}

	$('#author-letter, #price-range, #sort-order').on('change', function() {
		page = 1;
		loadBooks(true);
	});

	$('#load-more-books').on('click', function() {
		page++;
		loadBooks();
	});

	loadBooks(); // Initial load
});
