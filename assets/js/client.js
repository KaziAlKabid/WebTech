import { ajaxRequest } from './ajaxHelper.js';

/**
 * Handles creating a new case via AJAX
 */

export function handleCreateCase() {
    document.getElementById('create-case-form').addEventListener('submit', async function (event) {
        event.preventDefault(); // Prevent the default form submission

        const feedbackDiv = document.getElementById('case-feedback');
        const formData = new FormData(this); // Collect form data from the form

        try {
            // Send the data to the server via AJAX
            const response = await ajaxRequest({
                url: 'router.php?controller=case&action=create',
                method: 'POST',
                data: Object.fromEntries(formData.entries()), // Convert FormData to plain object
            });

            // Handle success or failure based on server response
            if (response.success) {
                feedbackDiv.innerText = response.message;
                feedbackDiv.className = 'text-success mt-2';
                this.reset(); // Reset the form after successful submission
            } else {
                feedbackDiv.innerText = response.message || 'Failed to create the case.';
                feedbackDiv.className = 'text-danger mt-2';
            }
        } catch (error) {
            console.error('Error while creating case:', error);
            feedbackDiv.innerText = 'An unexpected error occurred. Please try again.';
            feedbackDiv.className = 'text-danger mt-2';
        }
    });
}


export function handleSubmitReview() {
    document.getElementById('review-form').addEventListener('submit', async function (event) {
        event.preventDefault();
        
        const caseId = document.getElementById('case_id').value;
        const rating = document.getElementById('rating').value;
        const reviewText = document.getElementById('review_text').value;
        const feedbackDiv = document.getElementById('review-feedback');

        try {
            const response = await ajaxRequest({
                url: 'router.php?controller=review&action=submitReview',
                method: 'POST',
                data: { case_id: caseId, rating, review_text: reviewText }
            });

            if (response.success) {
                feedbackDiv.innerText = 'Review submitted successfully!';
                feedbackDiv.className = 'text-success mt-2';
                this.reset();
            } else {
                feedbackDiv.innerText = response.message || 'Failed to submit review.';
                feedbackDiv.className = 'text-danger mt-2';
            }
        } catch (error) {
            feedbackDiv.innerText = 'An error occurred. Please try again.';
            feedbackDiv.className = 'text-danger mt-2';
        }
    });
}
export function handleEditReview() {
    document.getElementById('edit-review-form').addEventListener('submit', async function (event) {
        event.preventDefault();
        
        const reviewId = parseInt(document.getElementById('review_id').value, 10) || null;

        const rating = document.getElementById('rating').value;
        const reviewText = document.getElementById('review_text').value;
        const feedbackDiv = document.getElementById('review-feedback');
       

        console.log("Sending Data to AJAX:", { id: reviewId, rating, review_text: reviewText });


        try {
            const response = await ajaxRequest({
                url: 'router.php?controller=review&action=updateReview',
                method: 'POST',
                data: { id: reviewId, rating, review_text: reviewText }
            });
            console.log("Server Response:", response); // Debugging log
            if (response.success) {
                feedbackDiv.innerText = 'Review updated successfully!';
                feedbackDiv.className = 'text-success mt-2';
                
            } else {
                feedbackDiv.innerText = response.message || 'Failed to update review.';
                feedbackDiv.className = 'text-danger mt-2';
            }
        } catch (error) {
            feedbackDiv.innerText = 'An error occurred. Please try again.';
            feedbackDiv.className = 'text-danger mt-2';
        }
    });
}
export function handleDeleteReview() {
    
        document.body.addEventListener("click", async function (event) {
            if (event.target.classList.contains("delete-review")) {
                event.preventDefault(); // Stop default <a> behavior
    
                const reviewId = event.target.getAttribute("data-id");
                if (!confirm("Are you sure you want to delete this review?")) return;
    
                try {
                    const response = await ajaxRequest({
                        url: 'router.php?controller=review&action=deleteReview',
                        method: 'POST',
                        data: { review_id: reviewId }
                    });
    
                    if (response.success) {
                        alert("Review deleted successfully!");
                        location.reload(); // Refresh the page to update the review list
                    } else {
                        alert(response.message || "Failed to delete review.");
                    }
                } catch (error) {
                    console.error("AJAX Error:", error);
                    alert("An error occurred. Please try again.");
                }
            }
        });
    
    
}

