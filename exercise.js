document.addEventListener('DOMContentLoaded', function() {
    const workoutSections = document.querySelectorAll('.workout-section');
    const navLinks = document.querySelectorAll('#navbar a');

    // Hide all sections initially
    workoutSections.forEach(section => section.style.display = 'none');

    // Show the first section by default
    workoutSections[0].style.display = 'block';

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // Get the workout section to display
            const workout = this.getAttribute('data-workout');
            workoutSections.forEach(section => {
                if (section.id === workout) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    });
});
