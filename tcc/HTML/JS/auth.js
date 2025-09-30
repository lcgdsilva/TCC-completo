// Lógica de autenticação de usuários

const sampleUsers = [
    {
        id: 1,
        name: "João Silva",
        email: "joao@email.com",
        phone: "(45) 99999-9999",
        password: "123456"
    }
];

// Inicializar dados de usuários
function initUserData() {
    if (!localStorage.getItem('users')) {
        localStorage.setItem('users', JSON.stringify(sampleUsers));
    }
}

// Função para registrar um novo usuário
function registerUser(userData) {
    if (!userData.name || !userData.email || !userData.phone || !userData.password) {
        return { success: false, message: 'Todos os campos são obrigatórios.' };
    }
    
    if (userData.password !== userData.confirmPassword) {
        return { success: false, message: 'As senhas não coincidem.' };
    }
    
    if (!isValidEmail(userData.email)) {
        return { success: false, message: 'Por favor, insira um email válido.' };
    }
    
    const users = loadFromStorage('users') || [];
    const existingUser = users.find(user => user.email === userData.email);
    
    if (existingUser) {
        return { success: false, message: 'Este email já está cadastrado.' };
    }
    
    const newUser = {
        id: users.length > 0 ? Math.max(...users.map(u => u.id)) + 1 : 1,
        name: userData.name,
        email: userData.email,
        phone: userData.phone,
        password: userData.password
    };
    
    users.push(newUser);
    
    if (saveToStorage('users', users)) {
        saveToStorage('currentUser', newUser);
        return { success: true, message: 'Cadastro realizado com sucesso!' };
    } else {
        return { success: false, message: 'Erro ao salvar dados. Tente novamente.' };
    }
}

// Função para fazer login
function loginUser(email, password) {
    if (!email || !password) {
        return { success: false, message: 'Email e senha são obrigatórios.' };
    }
    
    const users = loadFromStorage('users') || [];
    const user = users.find(u => u.email === email);
    
    if (!user) {
        return { success: false, message: 'Email não encontrado.' };
    }
    
    if (user.password !== password) {
        return { success: false, message: 'Senha incorreta.' };
    }
    
    if (saveToStorage('currentUser', user)) {
        return { success: true, message: 'Login realizado com sucesso!' };
    } else {
        return { success: false, message: 'Erro ao fazer login. Tente novamente.' };
    }
}

// Função para atualizar links de autenticação
function updateAuthLinks() {
    const authLinksElement = document.getElementById('auth-links');
    if (!authLinksElement) return;
    
    const user = getCurrentUser();
    
    if (user) {
        authLinksElement.innerHTML = `
            <li><a href="reservas.html">Olá, ${user.name.split(' ')[0]}</a></li>
            <li><a href="#" id="logout-link">Sair</a></li>
        `;
        
        const logoutLink = document.getElementById('logout-link');
        if (logoutLink) {
            logoutLink.addEventListener('click', function(e) {
                e.preventDefault();
                logout();
            });
        }
    } else {
        authLinksElement.innerHTML = `
            <li><a href="login.html">Login</a></li>
            <li><a href="register.html">Cadastrar</a></li>
        `;
    }
}

// Inicializar autenticação
document.addEventListener('DOMContentLoaded', function() {
    initUserData();
    updateAuthLinks();
    
    // Formulário de registro
    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(registerForm);
            const userData = {
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                password: formData.get('password'),
                confirmPassword: formData.get('confirm-password')
            };
            
            const result = registerUser(userData);
            
            if (result.success) {
                showMessage('register-message', result.message, 'success');
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 2000);
            } else {
                showMessage('register-message', result.message, 'error');
            }
        });
    }
    
    // Formulário de login
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(loginForm);
            const email = formData.get('email');
            const password = formData.get('password');
            
            const result = loginUser(email, password);
            
            if (result.success) {
                showMessage('login-message', result.message, 'success');
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 2000);
            } else {
                showMessage('login-message', result.message, 'error');
            }
        });
    }
});