function toggleFields() {
    const role = document.getElementById('role').value; // Get the selected role
    const lawyerFields = document.getElementById('lawyerFields'); // Lawyer-specific fields
    const license = document.getElementById('license');
    const experience = document.getElementById('experience');
    const specialization = document.getElementById('specialization');

    if (role === 'lawyer') {
        lawyerFields.style.display = 'block';
        license.required = true;
        experience.required = true;
        specialization.required = true;
    } else {
        lawyerFields.style.display = 'none'; // Hide the extra fields
        license.required = false;
        experience.required = false;
        specialization.required = false;

        //  Clear the values when switching back to "Client"
        license.value = "";
        experience.value = "";
        specialization.value = "";
    }
}
