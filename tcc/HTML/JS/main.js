// Arquivo principal - Funcionalidades comuns

document.addEventListener('DOMContentLoaded', function() {
    // Atualizar links de autenticação
    if (typeof updateAuthLinks === 'function') {
        updateAuthLinks();
    }
    
    // Inicializar menu mobile
    if (typeof initMobileMenu === 'function') {
        initMobileMenu();
    }
    
    // Configurar data mínima para campos de data
    const today = new Date().toISOString().split('T')[0];
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        input.setAttribute('min', today);
    });
    
    // Scroll suave para links internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Atualizar classe ativa do menu
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    const menuLinks = document.querySelectorAll('nav a');
    
    menuLinks.forEach(link => {
        const linkHref = link.getAttribute('href');
        if (linkHref === currentPage) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
    
    // Efeitos de hover nas cards
    const cards = document.querySelectorAll('.accommodation-card, .highlight-item');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Animação de entrada para elementos
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.highlight-item, .accommodation-card');
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Aplicar estilos iniciais para animação
    const animatedElements = document.querySelectorAll('.highlight-item, .accommodation-card');
    animatedElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    });
    
    // Disparar animação no scroll
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Disparar uma vez ao carregar
});

// Função para mostrar/ocultar loading
function showLoading(show = true) {
    let loadingElement = document.getElementById('loading');
    
    if (!loadingElement && show) {
        loadingElement = document.createElement('div');
        loadingElement.id = 'loading';
        loadingElement.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 9999;">
                <div style="background: white; padding: 2rem; border-radius: 10px; text-align: center;">
                    <div style="width: 40px; height: 40px; border: 4px solid #f3f3f3; border-top: 4px solid #2c5530; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1rem;"></div>
                    <p>Carregando...</p>
                </div>
            </div>
            <style>
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style>
        `;
        document.body.appendChild(loadingElement);
    } else if (loadingElement) {
        loadingElement.style.display = show ? 'block' : 'none';
    }
}

// Função para validar formulários
function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.style.borderColor = 'red';
            
            input.addEventListener('input', function() {
                this.style.borderColor = '';
            });
        }
    });
    
    return isValid;
}

// Função para formatar valores monetários
function formatCurrency(value) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(value);
}