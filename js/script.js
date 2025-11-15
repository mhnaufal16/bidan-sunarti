// Main application JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Password confirmation validation
    const registerForm = document.querySelector('.register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak sama');
            }
        });
    }
    
    // Set current date for date inputs
    const setCurrentDateForInputs = () => {
        const dateInputs = document.querySelectorAll('input[type="date"]');
        const today = new Date().toISOString().split('T')[0];
        
        dateInputs.forEach(input => {
            if (!input.value && !input.hasAttribute('data-no-default')) {
                input.value = today;
            }
        });
    };
    
    setCurrentDateForInputs();
    
    // Numeric input validation
    const numericInputs = document.querySelectorAll('input[type="number"]');
    numericInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0;
            }
        });
    });
    
    // Calculate HPL from HPHT (Naegele's rule)
    const hphtInputs = document.querySelectorAll('input[name="hpht"]');
    hphtInputs.forEach(input => {
        input.addEventListener('change', function() {
            const hpht = new Date(this.value);
            if (!isNaN(hpht.getTime())) {
                const hplInput = this.closest('form').querySelector('input[name="hpl"]');
                if (hplInput) {
                    const hpl = new Date(hpht);
                    hpl.setDate(hpl.getDate() + 7);
                    hpl.setMonth(hpl.getMonth() + 9);
                    
                    const hplFormatted = hpl.toISOString().split('T')[0];
                    hplInput.value = hplFormatted;
                }
            }
        });
    });
    
    // Auto-format GPA input
    const gpaInputs = document.querySelectorAll('input[name="gpa"]');
    gpaInputs.forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
    
    // Auto-format tensi input
    const tensiInputs = document.querySelectorAll('input[name="tensi"]');
    tensiInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Remove any non-digit or slash characters
            this.value = this.value.replace(/[^\d/]/g, '');
            
            // Limit to one slash
            const parts = this.value.split('/');
            if (parts.length > 2) {
                this.value = parts[0] + '/' + parts[1];
            }
        });
    });
    
    // Search form handling
    const searchForms = document.querySelectorAll('.search-form');
    searchForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const searchInput = this.querySelector('input[name="search"]');
            if (searchInput && searchInput.value.trim() === '') {
                e.preventDefault();
            }
        });
    });
    
    // Filter form handling
    const filterForms = document.querySelectorAll('.filter-form');
    filterForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const startDate = this.querySelector('input[name="start_date"]');
            const endDate = this.querySelector('input[name="end_date"]');
            
            if (startDate.value && !endDate.value) {
                e.preventDefault();
                alert('Mohon isi tanggal selesai');
            } else if (!startDate.value && endDate.value) {
                e.preventDefault();
                alert('Mohon isi tanggal mulai');
            }
        });
    });
});