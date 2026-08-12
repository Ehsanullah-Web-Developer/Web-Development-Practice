// ===== DARK MODE TOGGLE =====
const themeToggle = document.getElementById('themeToggle');
const currentTheme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', currentTheme);
updateToggleIcon(currentTheme);

themeToggle.addEventListener('click', () => {
    const current = document.documentElement.getAttribute('data-theme');
    const next = current === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
    updateToggleIcon(next);
});

function updateToggleIcon(theme) {
    const icon = themeToggle.querySelector('i');
    if (theme === 'dark') {
        icon.className = 'fas fa-sun';
    } else {
        icon.className = 'fas fa-moon';
    }
}

// ===== HAMBURGER MENU =====
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('open');
});

document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
        navLinks.classList.remove('open');
    });
});

// ===== STICKY NAVIGATION =====
const nav = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
        nav.style.boxShadow = '0 8px 32px rgba(0, 0, 0, 0.12)';
    } else {
        nav.style.boxShadow = 'none';
    }
});

// ===== SCROLL TO TOP BUTTON =====
const scrollBtn = document.getElementById('scrollTopBtn');
window.addEventListener('scroll', () => {
    if (window.scrollY > 500) {
        scrollBtn.classList.add('visible');
    } else {
        scrollBtn.classList.remove('visible');
    }
});

scrollBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// ===== HIGHLIGHT NAV LINK =====
const sections = document.querySelectorAll('section[id]');
const navLinksItems = document.querySelectorAll('.nav-links a');

function highlightNav() {
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop - 120;
        if (window.scrollY >= sectionTop) {
            current = section.getAttribute('id');
        }
    });
    navLinksItems.forEach(link => {
        link.style.color = 'var(--text-secondary)';
        if (link.getAttribute('href') === `#${current}`) {
            link.style.color = 'var(--accent)';
        }
    });
}
window.addEventListener('scroll', highlightNav);

// ===== PRINT RESUME =====
document.getElementById('printResume').addEventListener('click', () => {
    window.print();
});

// ===== DOWNLOAD RESUME (PDF) =====
document.getElementById('downloadResume').addEventListener('click', function() {
    const btn = this;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating PDF...';
    btn.disabled = true;

    // Create a clone of the content for PDF
    const main = document.querySelector('main');
    const footer = document.querySelector('footer');
    const clone = main.cloneNode(true);
    
    // Create wrapper with proper styling
    const wrapper = document.createElement('div');
    wrapper.style.padding = '20px';
    wrapper.style.background = '#ffffff';
    wrapper.style.color = '#000000';
    wrapper.style.fontFamily = 'Inter, sans-serif';
    wrapper.style.width = '1024px';
    wrapper.style.position = 'absolute';
    wrapper.style.left = '-9999px';
    wrapper.style.top = '0';
    
    // Fix image paths - replace relative paths with absolute
    const images = clone.querySelectorAll('img');
    images.forEach(img => {
        if (img.src && !img.src.startsWith('http')) {
            // Convert relative path to absolute
            img.src = window.location.origin + '/' + img.src;
        }
    });
    
    wrapper.appendChild(clone);
    
    if (footer) {
        const footerClone = footer.cloneNode(true);
        wrapper.appendChild(footerClone);
    }
    
    document.body.appendChild(wrapper);

    // Wait a moment for DOM to update
    setTimeout(() => {
        html2canvas(wrapper, {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: true, // Enable logging for debugging
            width: 1024,
            onclone: function(document) {
                // Fix any styles that might break in the clone
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
                
                // Add the image to PDF
                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                
                // Check if content needs multiple pages
                let heightLeft = pdfHeight;
                let position = 0;
                
                while (heightLeft > 0) {
                    position = heightLeft - pdfHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
                    heightLeft -= pdfHeight;
                }
                
                pdf.save('John_Doe_Resume.pdf');
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
    }, 500); // Small delay for DOM update
});

// Add this to handle any loading issues
console.log('Resume website loaded successfully!');