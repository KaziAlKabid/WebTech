import { ajaxRequest } from './ajaxHelper.js';

export async function handleEditProfile() {
    // Get all the necessary elements
    const editBtn = document.getElementById("edit-profile-btn");
    const saveBtn = document.getElementById("save-profile-btn");
    const cancelBtn = document.getElementById("cancel-edit-btn");
    const profileFields = document.querySelectorAll(
        "#profile-form input:not(#email), #profile-form textarea"
    );
   

    // Enable form editing
    editBtn.addEventListener("click", function () {
        profileFields.forEach(field => field.removeAttribute("readonly"));
        editBtn.style.display = "none";
        saveBtn.style.display = "inline-block";
        cancelBtn.style.display = "inline-block";
    });

    // Cancel editing (restore original values)
    cancelBtn.addEventListener("click", function () {
        profileFields.forEach(field => field.setAttribute("readonly", true));
        editBtn.style.display = "inline-block";
        saveBtn.style.display = "none";
        cancelBtn.style.display = "none";
       let form=document.getElementById('profile-form');
         form.reset();
         let feedbackDiv = document.getElementById('email-feedback');
            feedbackDiv.innerText = '';
       
    });


    // Handle form submission via AJAX
    document.getElementById("profile-form").addEventListener("submit", async function (event) {
        event.preventDefault(); // Prevent default form submission
  
   

let feedbackDiv = document.getElementById('profile-feedback');
        const formData = new FormData(this); // Collect all form fields automatically

        try {
            const response = await ajaxRequest({
                url: "router.php?controller=user&action=updateProfile",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false
            });

            if (response.success) {
               feedbackDiv.innerText = response.message || "Profile updated successfully.";
               feedbackDiv.className = 'text-success mt-2';
                profileFields.forEach(field => field.setAttribute("readonly", true));
                editBtn.style.display = "inline-block";
                saveBtn.style.display = "none";
                cancelBtn.style.display = "none";
                this.reset(); // Reset the form after successful submission
            } else {
              feedbackDiv.innerText = response.message || "Failed to update profile.";
                feedbackDiv.className = 'text-danger mt-2';
            }
        } catch (error) {
            console.error("AJAX Error:", error);
            feedbackDiv.innerText = "An unexpected error occurred. Please try again.";
            feedbackDiv.className = 'text-danger mt-2';
        }
    });
}
