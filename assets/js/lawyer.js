import { ajaxRequest } from './ajaxHelper.js'; // Import the AJAX helper

/**
 * Handles accepting a case
 */
export function handleAcceptCase() {
    // Attach event listeners to all "Accept" buttons
    document.querySelectorAll('.accept-case-btn').forEach(button => {
        button.addEventListener('click', async (event) => {
            event.preventDefault(); // Prevent default behavior

            const caseId = button.getAttribute('data-id'); // Get the case ID from the button's data attribute
            const feedbackDiv = document.getElementById('updated-case-feedback')
              // Clear previous feedback
              feedbackDiv.innerText = '';
              feedbackDiv.className = '';
            // Confirm with the user before proceeding
            if (!confirm('Are you sure you want to accept this case?')) return;

            try {
                // Send AJAX request
                const response = await ajaxRequest({
                    url: 'router.php?controller=case&action=acceptCase',
                    method: 'POST',
                    data: { id: caseId }, // Send case ID as part of the POST data
                });

                if (response.success) {
                    // Show success message and remove the row
                    feedbackDiv.innerText='Case accepted successfully!';
                    feedbackDiv.className='text-success mt-2';
                    button.closest('tr').remove(); // Remove the corresponding table row dynamically
                } else {
                    feedbackDiv.innerText=response.message || 'Failed to accept the case.';
                    feedbackDiv.className='text-danger mt-2';
                }
            } catch (error) {
                console.error('Error accepting case:', error);
                feedbackDiv.innerText='An unexpected error occurred. Please try again.';
                feedbackDiv.className='text-danger mt-2';
            }
        });
    });
}


export function handleCompleteCase() {
    
        document.querySelectorAll('.complete-case-btn').forEach(button => {
            button.addEventListener('click', async function (event) {
                event.preventDefault();
                const caseId = this.dataset.caseId;
                const feedbackDiv = document.createElement('div');
                this.parentElement.appendChild(feedbackDiv); // Add feedback div dynamically

                try {
                    const response = await ajaxRequest({
                        url: 'router.php?controller=case&action=completeCase',
                        method: 'POST',
                        data: { id: caseId },
                    });

                    if (response.success) {
                        feedbackDiv.innerText = 'Case marked as completed!';
                        feedbackDiv.className = 'text-success mt-2';
                        this.classList.add('disabled'); // Disable button
                        this.innerText = "Completed"; // Change button text
                    } else {
                        feedbackDiv.innerText = response.message || 'Failed to update case.';
                        feedbackDiv.className = 'text-danger mt-2';
                    }
                } catch (error) {
                    console.error('Error updating case:', error);
                    feedbackDiv.innerText = 'An error occurred. Please try again.';
                    feedbackDiv.className = 'text-danger mt-2';
                }
            });
        });
    }

