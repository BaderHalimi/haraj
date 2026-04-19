  $(document).ready(function() {
    // Variables to track pagination
    let currentPage = parseInt($('ul.pagination li.active span.page-link').text()) || 1;
    let nextPageUrl = $('ul.pagination .page-item:not(.disabled) a[rel="next"]').attr('href');
    let isLoading = false;
    let hasMorePages = nextPageUrl !== undefined;
    
    // Show the load more button if there are more pages
    if (hasMorePages) {
        $('#load-more-container').show();
 $('#load-more-button').text('مشاهدة المزيد');
    }
    
    // Function to load more posts when scrolling
    function loadMorePosts() {
        if (isLoading || !hasMorePages) return;
        
        isLoading = true;
        $('#loading-indicator').show();
        
        $.ajax({
            url: nextPageUrl,
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                isLoading = false;
                $('#loading-indicator').hide();
                
                // Handle HTML response
                if (typeof response === 'string') {
                    // Extract the posts HTML from the response
                    let tempDiv = $('<div></div>').html(response);
                    let newPosts = tempDiv.find('#postsList .item-list');
                    
                    if (newPosts.length > 0) {
                        // Append the new posts to the container
                        $('#postsList').append(newPosts);
                        
                        // Update pagination tracking
                        nextPageUrl = tempDiv.find('ul.pagination .page-item:not(.disabled) a[rel="next"]').attr('href');
                        hasMorePages = nextPageUrl !== undefined;
                        
                        if (!hasMorePages) {
                            $('#load-more-container').hide();
                        }
                        
                        currentPage++;
                        
                        // Reinitialize any scripts that might be needed for newly added content
                        initializeNewlyAddedContent();
                    } else {
                        hasMorePages = false;
                        $('#load-more-container').hide();
                    }
                } 
                // Handle JSON response
                else if (response && response.data) {
                    // Process the new posts from JSON response
                    const posts = response.data;
                    
                    if (posts.length > 0) {
                        // Process and append posts
                        appendPosts(posts);
                        
                        // Update pagination tracking
                        currentPage++;
                        nextPageUrl = response.links ? response.links.next : null;
                        hasMorePages = nextPageUrl !== undefined && nextPageUrl !== null;
                        
                        if (!hasMorePages) {
                            $('#load-more-container').hide();
                        }
                        
                        // Reinitialize any scripts that might be needed for newly added content
                        initializeNewlyAddedContent();
                    } else {
                        // No more posts
                        hasMorePages = false;
                        $('#load-more-container').hide();
                    }
                }
            },
            error: function(xhr, status, error) {
                isLoading = false;
                $('#loading-indicator').hide();
                console.error('Error loading more posts:', error);
            }
        });
    }
    
    // Function to reinitialize scripts for newly added content
    function initializeNewlyAddedContent() {
        // Reinitialize tooltips
        if (typeof $().tooltip === 'function') {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
        
        // Reinitialize favorites buttons
        if (typeof bindFavoritePosts === 'function') {
            bindFavoritePosts();
        }
        
        // Reinitialize lazy loading for images if needed
        if (typeof lazy === 'function') {
            lazy();
        }
    }
    
    // Load more posts when the user scrolls near the bottom of the page
    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 500) {
            loadMorePosts();
        }
    });
    
    // Handle click on the load more button
    $('#load-more-button').click(function() {
        loadMorePosts();
    });
});