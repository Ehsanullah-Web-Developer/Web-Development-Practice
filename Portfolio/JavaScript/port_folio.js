// ===== DOM ELEMENTS =====
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navMenu');
const navLinks = document.querySelectorAll('.nav-link');
const scrollToTopBtn = document.getElementById('scrollToTopBtn');
const typingText = document.getElementById('typingText');
const contactForm = document.getElementById('contactForm');
const filterBtns = document.querySelectorAll('.filter-btn');
const projectCards = document.querySelectorAll('.project-card');
const downloadBtn = document.getElementById('downloadResumeBtn');
const currentYearSpan = document.getElementById('currentYear');

// ===== TYPING ANIMATION =====
const professions = [
    'Full Stack Developer',
    'React Enthusiast',
    'Python / Django Developer',
    'UI/UX Lover',
    'Open Source Contributor'
];
let professionIndex = 0;
let charIndex = 0;
let isDeleting = false;
let typingSpeed = 100;

function typeEffect() {
    const currentProf = professions[professionIndex];
    if (!isDeleting) {
        typingText.textContent = currentProf.substring(0, charIndex + 1);
        charIndex++;
        if (charIndex === currentProf.length) {
            isDeleting = true;
            typingSpeed = 2000; // pause at end
        } else {
            typingSpeed = 100;
        }
    } else {
        typingText.textContent = currentProf.substring(0, charIndex - 1);
        charIndex--;
        if (charIndex === 0) {
            isDeleting = false;
            professionIndex = (professionIndex + 1) % professions.length;
            typingSpeed = 300;
        } else {
            typingSpeed = 50;
        }
    }
    setTimeout(typeEffect, typingSpeed);
}

// Start typing
if (typingText) {
    typingText.textContent = professions[0];
    charIndex = professions[0].length;
    setTimeout(typeEffect, 1500);
}

// ===== RESPONSIVE NAVIGATION MENU =====
hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
});

// Close menu on link click
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        hamburger.classList.remove('active');
        navMenu.classList.remove('active');
    });
});

// ===== SMOOTH SCROLLING & ACTIVE NAV LINK ON SCROLL =====
window.addEventListener('scroll', () => {
    const scrollPos = window.scrollY + 150;

    // Highlight active nav link
    document.querySelectorAll('section').forEach(section => {
        const id = section.getAttribute('id');
        const offsetTop = section.offsetTop - 100;
        const offsetBottom = offsetTop + section.offsetHeight;
        if (scrollPos >= offsetTop && scrollPos < offsetBottom) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${id}`) {
                    link.classList.add('active');
                }
            });
        }
    });

    // Show/hide scroll to top button
    if (window.scrollY > 600) {
        scrollToTopBtn.classList.add('visible');
    } else {
        scrollToTopBtn.classList.remove('visible');
    }
});

// Scroll to top button
scrollToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// ===== PROJECT FILTERING =====
filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        // Update active button
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filterValue = btn.getAttribute('data-filter');

        projectCards.forEach(card => {
            const category = card.getAttribute('data-category');
            if (filterValue === 'all' || category === filterValue) {
                card.style.display = 'block';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

// ===== CONTACT FORM VALIDATION =====
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const subjectInput = document.getElementById('subject');
const messageInput = document.getElementById('message');
const nameError = document.getElementById('nameError');
const emailError = document.getElementById('emailError');
const subjectError = document.getElementById('subjectError');
const messageError = document.getElementById('messageError');
const formSuccess = document.getElementById('formSuccess');

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showError(input, errorEl, message) {
    input.style.borderColor = '#ff6b6b';
    errorEl.textContent = message;
}

function clearError(input, errorEl) {
    input.style.borderColor = 'var(--border-subtle)';
    errorEl.textContent = '';
}

contactForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let isValid = true;

    // Name validation
    if (nameInput.value.trim().length < 3) {
        showError(nameInput, nameError, 'Name must be at least 3 characters.');
        isValid = false;
    } else {
        clearError(nameInput, nameError);
    }

    // Email validation
    if (!validateEmail(emailInput.value.trim())) {
        showError(emailInput, emailError, 'Please enter a valid email address.');
        isValid = false;
    } else {
        clearError(emailInput, emailError);
    }

    // Subject validation
    if (subjectInput.value.trim().length < 3) {
        showError(subjectInput, subjectError, 'Subject must be at least 3 characters.');
        isValid = false;
    } else {
        clearError(subjectInput, subjectError);
    }

    // Message validation
    if (messageInput.value.trim().length < 10) {
        showError(messageInput, messageError, 'Message must be at least 10 characters.');
        isValid = false;
    } else {
        clearError(messageInput, messageError);
    }

    if (isValid) {
        formSuccess.style.display = 'block';
        contactForm.reset();
        setTimeout(() => {
            formSuccess.style.display = 'none';
        }, 5000);
    }
});

// Clear errors on input
[nameInput, emailInput, subjectInput, messageInput].forEach(input => {
    input.addEventListener('input', () => {
        const errorEl = document.getElementById(input.id + 'Error');
        if (input.checkValidity() && input.value.trim().length >= (input.minLength || 0)) {
            clearError(input, errorEl);
        }
    });
});

// ===== DOWNLOAD RESUME AS PDF (UPDATED) =====
downloadBtn.addEventListener('click', function() {
    const btn = this;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating PDF...';
    btn.disabled = true;

    // Clone main content and footer
    const main = document.querySelector('main') || document.querySelector('.hero')?.parentNode; 
    // If your page doesn't have a <main> tag, we'll capture all sections between header and footer.
    // Let's wrap all sections after header and before footer in a container for cloning.
    // Since the structure uses <section> with class "section" and others, we can clone the entire body content except header and footer.
    // Simpler: clone the entire body, then remove header and footer from clone.
    const bodyClone = document.body.cloneNode(true);
    // Remove header and footer from clone
    const headerClone = bodyClone.querySelector('header');
    if (headerClone) headerClone.remove();
    const footerCloneEl = bodyClone.querySelector('footer');
    if (footerCloneEl) footerCloneEl.remove();
    // Also remove the scroll-to-top button
    const scrollBtnClone = bodyClone.querySelector('.scroll-to-top');
    if (scrollBtnClone) scrollBtnClone.remove();

    // Create a wrapper for clean PDF
    const wrapper = document.createElement('div');
    wrapper.style.padding = '20px';
    wrapper.style.background = '#ffffff';
    wrapper.style.color = '#000000';
    wrapper.style.fontFamily = 'Inter, sans-serif';
    wrapper.style.width = '1024px';
    wrapper.style.position = 'absolute';
    wrapper.style.left = '-9999px';
    wrapper.style.top = '0';

    // Append the cleaned body content (which now contains all sections but no header/footer)
    wrapper.appendChild(bodyClone);

    // Also add the footer separately if you want it in the PDF
    const footerOriginal = document.querySelector('footer');
    if (footerOriginal) {
        const footerClone = footerOriginal.cloneNode(true);
        wrapper.appendChild(footerClone);
    }

    document.body.appendChild(wrapper);

    // Fix image paths
    const images = wrapper.querySelectorAll('img');
    images.forEach(img => {
        if (img.src && !img.src.startsWith('http')) {
            img.src = window.location.origin + '/' + img.src;
        }
    });

    // Wait a moment for DOM update
    setTimeout(() => {
        html2canvas(wrapper, {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: false,
            width: 1024,
            onclone: function(document) {
                const elements = document.querySelectorAll('*');
                elements.forEach(el => {
                    if (el.style) {
                        el.style.fontFamily = 'Inter, sans-serif';
                    }
                });
            }
        }).then((canvas) => {
            document.body.removeChild(wrapper);

            try {
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

                let heightLeft = pdfHeight;
                let position = 0;
                while (heightLeft > 0) {
                    position = heightLeft - pdfHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
                    heightLeft -= pdfHeight;
                }

                pdf.save('John_Anderson_Portfolio.pdf');
                btn.innerHTML = originalText;
                btn.disabled = false;
            } catch (pdfError) {
                console.error('PDF creation error:', pdfError);
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert('PDF generation error. Please try using the Print button instead.');
            }
        }).catch((error) => {
            console.error('html2canvas error:', error);
            document.body.removeChild(wrapper);
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert('Could not generate PDF. Please try the Print button instead.');
        });
    }, 500);
});

// ===== ANIMATE ON SCROLL (Intersection Observer) =====
const revealElements = document.querySelectorAll('.reveal');

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, {
    threshold: 0.15,
    rootMargin: '0px 0px -50px 0px'
});

revealElements.forEach(el => observer.observe(el));

// ===== SET CURRENT YEAR IN FOOTER =====
if (currentYearSpan) {
    currentYearSpan.textContent = new Date().getFullYear();
}