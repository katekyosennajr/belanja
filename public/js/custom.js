// Toast Notification System
const showToast = (message, type = 'success') => {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <div class="toast-header">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
            <strong class="me-auto">${type === 'success' ? 'Sukses' : 'Error'}</strong>
            <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
        <div class="toast-body">${message}</div>
    `;
    
    const container = document.querySelector('.toast-container') || (() => {
        const div = document.createElement('div');
        div.className = 'toast-container';
        document.body.appendChild(div);
        return div;
    })();
    
    container.appendChild(toast);
    setTimeout(() => toast.remove(), 5000);
};

// Cart Quantity Controls
document.querySelectorAll('.quantity-control').forEach(control => {
    const input = control.querySelector('input');
    const decrementBtn = control.querySelector('.decrement');
    const incrementBtn = control.querySelector('.increment');
    
    decrementBtn?.addEventListener('click', () => {
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            input.dispatchEvent(new Event('change'));
        }
    });
    
    incrementBtn?.addEventListener('click', () => {
        const currentValue = parseInt(input.value);
        const max = parseInt(input.getAttribute('max'));
        if (currentValue < max) {
            input.value = currentValue + 1;
            input.dispatchEvent(new Event('change'));
        }
    });
});

// Image Preview
const setupImagePreview = (inputId, previewId) => {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    if (input && preview) {
        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }
};

// Price Formatter
const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(price);
};

// Lazy Loading Images
document.addEventListener('DOMContentLoaded', () => {
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => imageObserver.observe(img));
});

// Form Validation
const validateForm = (formId, rules) => {
    const form = document.getElementById(formId);
    if (!form) return;
    
    form.addEventListener('submit', (e) => {
        let isValid = true;
        const errors = {};
        
        Object.keys(rules).forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            const value = field?.value?.trim();
            const fieldRules = rules[fieldName];
            
            if (fieldRules.required && !value) {
                isValid = false;
                errors[fieldName] = 'Field ini wajib diisi';
            } else if (fieldRules.min && value.length < fieldRules.min) {
                isValid = false;
                errors[fieldName] = `Minimal ${fieldRules.min} karakter`;
            } else if (fieldRules.max && value.length > fieldRules.max) {
                isValid = false;
                errors[fieldName] = `Maksimal ${fieldRules.max} karakter`;
            } else if (fieldRules.pattern && !fieldRules.pattern.test(value)) {
                isValid = false;
                errors[fieldName] = fieldRules.message || 'Format tidak valid';
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            Object.keys(errors).forEach(fieldName => {
                const field = form.querySelector(`[name="${fieldName}"]`);
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = errors[fieldName];
                field.classList.add('is-invalid');
                field.parentElement.appendChild(errorDiv);
            });
        }
    });
};

// Search Autocomplete
const setupSearchAutocomplete = (inputId, resultsId, searchUrl) => {
    const input = document.getElementById(inputId);
    const results = document.getElementById(resultsId);
    let timeoutId;
    
    if (input && results) {
        input.addEventListener('input', () => {
            clearTimeout(timeoutId);
            const query = input.value.trim();
            
            if (query.length >= 2) {
                timeoutId = setTimeout(async () => {
                    try {
                        const response = await fetch(`${searchUrl}?q=${encodeURIComponent(query)}`);
                        const data = await response.json();
                        
                        results.innerHTML = '';
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'search-result-item';
                            div.innerHTML = `
                                <img src="${item.image}" alt="${item.name}">
                                <div>
                                    <div class="name">${item.name}</div>
                                    <div class="price">${formatPrice(item.price)}</div>
                                </div>
                            `;
                            div.addEventListener('click', () => {
                                window.location.href = item.url;
                            });
                            results.appendChild(div);
                        });
                        
                        results.style.display = 'block';
                    } catch (error) {
                        console.error('Search error:', error);
                    }
                }, 300);
            } else {
                results.style.display = 'none';
            }
        });
        
        document.addEventListener('click', (e) => {
            if (!input.contains(e.target) && !results.contains(e.target)) {
                results.style.display = 'none';
            }
        });
    }
};

// Validasi stok sebelum checkout
document.addEventListener('DOMContentLoaded', () => {
    $('#checkoutForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '/cart/validate',
            method: 'GET',
            success: function(response) {
                if (response.valid) {
                    $('#checkoutForm')[0].submit();
                } else {
                    Swal.fire({
                        title: 'Perhatian!',
                        text: 'Beberapa produk tidak memiliki stok yang cukup. Silakan periksa keranjang Anda.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '/cart';
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});

// Initialize Components
document.addEventListener('DOMContentLoaded', () => {
    // Setup image previews
    setupImagePreview('productImage', 'imagePreview');
    
    // Setup search autocomplete
    setupSearchAutocomplete('searchInput', 'searchResults', '/api/search');
    
    // Setup form validation
    validateForm('checkoutForm', {
        nama_penerima: { required: true, min: 3 },
        telepon: { required: true, pattern: /^[0-9]{10,13}$/, message: 'Nomor telepon tidak valid' },
        alamat: { required: true, min: 10 }
    });
    
    // Initialize tooltips
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
});
