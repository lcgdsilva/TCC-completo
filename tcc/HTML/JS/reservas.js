// Lógica de reservas

const sampleChalets = [
    {
        id: 1,
        name: "Chalé Família",
        description: "Chalé aconchegante ideal para famílias, com 2 quartos, sala ampla, cozinha completa e varanda com rede. Perfeito para até 6 pessoas.",
        image: "chalet-1",
        price: 200,
        capacity: 6,
        amenities: ["2 Quartos", "TV LED 42\"", "Cozinha Completa", "Varanda com Rede", "Churrasqueira", "Wi-Fi", "Estacionamento"]
    },
    {
        id: 2,
        name: "Chalé Casal",
        description: "Chalé romântico perfeito para casais, com vista para a natureza, hidromassagem e ambiente aconchegante. Ideal para um fim de semana especial.",
        image: "chalet-2",
        price: 150,
        capacity: 2,
        amenities: ["1 Quarto Suite", "TV LED 32\"", "Hidromassagem", "Varanda Privativa", "Frigobar", "Wi-Fi", "Estacionamento"]
    },
    {
        id: 3,
        name: "Chalé Premium",
        description: "Chalé espaçoso com todas as comodidades para uma estadia luxuosa. 3 quartos, sala de estar ampla e área de churrasco privativa.",
        image: "chalet-3",
        price: 300,
        capacity: 8,
        amenities: ["3 Quartos", "TV LED 50\"", "Cozinha Gourmet", "Área de Churrasco", "2 Banheiros", "Ar Condicionado", "Wi-Fi"]
    }
];

const sampleKiosques = [
    {
        id: 1,
        name: "Quiosque Grande",
        description: "Quiosque espaçoso para grandes grupos, com churrasqueira, mesa para 20 pessoas e área coberta. Ideal para festas e confraternizações.",
        image: "kiosque-1",
        price: 100,
        capacity: 20,
        amenities: ["Mesa para 20 pessoas", "Churrasqueira Grande", "Área Coberta", "Luz Elétrica", "Água Potável", "Banheiro Próximo"]
    },
    {
        id: 2,
        name: "Quiosque Médio",
        description: "Quiosque ideal para grupos médios, com churrasqueira e mesa para 12 pessoas. Ambiente agradável para reuniões familiares.",
        image: "kiosque-2",
        price: 70,
        capacity: 12,
        amenities: ["Mesa para 12 pessoas", "Churrasqueira", "Área Semi-coberta", "Luz Elétrica", "Água Potável"]
    },
    {
        id: 3,
        name: "Quiosque Pequeno",
        description: "Quiosque aconchegante para pequenos grupos, perfeito para um dia de lazer com amigos ou família próxima.",
        image: "kiosque-3",
        price: 50,
        capacity: 8,
        amenities: ["Mesa para 8 pessoas", "Churrasqueira", "Área Sombreada", "Ponto de Luz"]
    }
];

// Inicializar dados
function initAccommodationData() {
    if (!localStorage.getItem('chalets')) {
        localStorage.setItem('chalets', JSON.stringify(sampleChalets));
    }
    
    if (!localStorage.getItem('kiosques')) {
        localStorage.setItem('kiosques', JSON.stringify(sampleKiosques));
    }
    
    if (!localStorage.getItem('reservations')) {
        localStorage.setItem('reservations', JSON.stringify([]));
    }
}

// Carregar chalés
function loadChalets() {
    const chaletsGrid = document.getElementById('chalets-grid');
    if (!chaletsGrid) return;
    
    const chalets = loadFromStorage('chalets') || [];
    
    chaletsGrid.innerHTML = chalets.map(chalet => `
        <div class="accommodation-card">
            <div class="card-image chalet-image-${chalet.id}">
                <div class="image-placeholder">
                    <span>🏡</span>
                </div>
            </div>
            <div class="card-content">
                <h3>${chalet.name}</h3>
                <p>${chalet.description}</p>
                <div class="card-price">R$ ${chalet.price}/noite</div>
                <div class="card-capacity">Capacidade: ${chalet.capacity} pessoas</div>
                <button class="btn-primary view-chalet" data-id="${chalet.id}">Ver Detalhes</button>
            </div>
        </div>
    `).join('');
    
    document.querySelectorAll('.view-chalet').forEach(button => {
        button.addEventListener('click', function() {
            const chaletId = parseInt(this.getAttribute('data-id'));
            showChaletDetails(chaletId);
        });
    });
}

// Carregar quiosques
function loadKiosques() {
    const kiosquesGrid = document.getElementById('kiosques-grid');
    if (!kiosquesGrid) return;
    
    const kiosques = loadFromStorage('kiosques') || [];
    
    kiosquesGrid.innerHTML = kiosques.map(kiosque => `
        <div class="accommodation-card">
            <div class="card-image kiosque-image-${kiosque.id}">
                <div class="image-placeholder">
                    <span>🏖️</span>
                </div>
            </div>
            <div class="card-content">
                <h3>${kiosque.name}</h3>
                <p>${kiosque.description}</p>
                <div class="card-price">R$ ${kiosque.price}/dia</div>
                <div class="card-capacity">Capacidade: ${kiosque.capacity} pessoas</div>
                <button class="btn-primary view-kiosque" data-id="${kiosque.id}">Ver Detalhes</button>
            </div>
        </div>
    `).join('');
    
    document.querySelectorAll('.view-kiosque').forEach(button => {
        button.addEventListener('click', function() {
            const kiosqueId = parseInt(this.getAttribute('data-id'));
            showKiosqueDetails(kiosqueId);
        });
    });
}

// Mostrar detalhes do chalé
function showChaletDetails(chaletId) {
    const chalets = loadFromStorage('chalets') || [];
    const chalet = chalets.find(c => c.id === chaletId);
    
    if (!chalet) return;
    
    const modalContent = document.getElementById('chalet-details');
    if (modalContent) {
        modalContent.innerHTML = `
            <div class="modal-header">
                <h2>${chalet.name}</h2>
                <div class="modal-price">R$ ${chalet.price}/noite</div>
            </div>
            <div class="modal-image chalet-image-${chalet.id}">
                <div class="image-placeholder">
                    <span>🏡</span>
                </div>
            </div>
            <div class="modal-info">
                <p><strong>Descrição:</strong> ${chalet.description}</p>
                <p><strong>Capacidade:</strong> ${chalet.capacity} pessoas</p>
                <div class="amenities">
                    <h3>Comodidades:</h3>
                    <ul>
                        ${chalet.amenities.map(amenity => `<li>✓ ${amenity}</li>`).join('')}
                    </ul>
                </div>
            </div>
            <div class="modal-actions">
                ${isUserLoggedIn() ? 
                    `<button class="btn-primary reserve-btn" data-type="chalet" data-id="${chalet.id}">Fazer Reserva</button>` : 
                    '<p><a href="login.html" class="btn-primary">Faça login para reservar</a></p>'
                }
            </div>
        `;
        
        openModal('chalet-modal');
        
        const reserveBtn = document.querySelector('.reserve-btn');
        if (reserveBtn) {
            reserveBtn.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const id = parseInt(this.getAttribute('data-id'));
                closeModal('chalet-modal');
                openReservationModal(type, id);
            });
        }
    }
}

// Mostrar detalhes do quiosque
function showKiosqueDetails(kiosqueId) {
    const kiosques = loadFromStorage('kiosques') || [];
    const kiosque = kiosques.find(k => k.id === kiosqueId);
    
    if (!kiosque) return;
    
    const modalContent = document.getElementById('kiosque-details');
    if (modalContent) {
        modalContent.innerHTML = `
            <div class="modal-header">
                <h2>${kiosque.name}</h2>
                <div class="modal-price">R$ ${kiosque.price}/dia</div>
            </div>
            <div class="modal-image kiosque-image-${kiosque.id}">
                <div class="image-placeholder">
                    <span>🏖️</span>
                </div>
            </div>
            <div class="modal-info">
                <p><strong>Descrição:</strong> ${kiosque.description}</p>
                <p><strong>Capacidade:</strong> ${kiosque.capacity} pessoas</p>
                <div class="amenities">
                    <h3>Comodidades:</h3>
                    <ul>
                        ${kiosque.amenities.map(amenity => `<li>✓ ${amenity}</li>`).join('')}
                    </ul>
                </div>
            </div>
            <div class="modal-actions">
                ${isUserLoggedIn() ? 
                    `<button class="btn-primary reserve-btn" data-type="kiosque" data-id="${kiosque.id}">Fazer Reserva</button>` : 
                    '<p><a href="login.html" class="btn-primary">Faça login para reservar</a></p>'
                }
            </div>
        `;
        
        openModal('kiosque-modal');
        
        const reserveBtn = document.querySelector('.reserve-btn');
        if (reserveBtn) {
            reserveBtn.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const id = parseInt(this.getAttribute('data-id'));
                closeModal('kiosque-modal');
                openReservationModal(type, id);
            });
        }
    }
}

// Abrir modal de reserva
function openReservationModal(type, id) {
    const accommodationSelect = document.getElementById('accommodation-id');
    if (accommodationSelect) {
        accommodationSelect.innerHTML = '';
        
        let accommodations = [];
        if (type === 'chalet') {
            accommodations = loadFromStorage('chalets') || [];
        } else if (type === 'kiosque') {
            accommodations = loadFromStorage('kiosques') || [];
        }
        
        accommodations.forEach(acc => {
            const option = document.createElement('option');
            option.value = acc.id;
            option.textContent = acc.name;
            if (acc.id === id) {
                option.selected = true;
            }
            accommodationSelect.appendChild(option);
        });
    }
    
    const typeSelect = document.getElementById('accommodation-type');
    if (typeSelect) {
        typeSelect.value = type;
    }
    
    openModal('reservation-modal');
}

// Fazer reserva
function makeReservation(reservationData) {
    if (!reservationData.type || !reservationData.accommodationId || 
        !reservationData.checkin || !reservationData.checkout || 
        !reservationData.guests) {
        return { success: false, message: 'Todos os campos são obrigatórios.' };
    }
    
    const checkin = new Date(reservationData.checkin);
    const checkout = new Date(reservationData.checkout);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (checkin < today) {
        return { success: false, message: 'A data de entrada não pode ser no passado.' };
    }
    
    if (checkout <= checkin) {
        return { success: false, message: 'A data de saída deve ser após a data de entrada.' };
    }
    
    if (!isAvailable(reservationData.type, reservationData.accommodationId, reservationData.checkin, reservationData.checkout)) {
        return { success: false, message: 'A acomodação não está disponível para as datas selecionadas.' };
    }
    
    const user = getCurrentUser();
    if (!user) {
        return { success: false, message: 'Usuário não logado.' };
    }
    
    const reservations = loadFromStorage('reservations') || [];
    
    const newReservation = {
        id: reservations.length > 0 ? Math.max(...reservations.map(r => r.id)) + 1 : 1,
        userId: user.id,
        type: reservationData.type,
        accommodationId: parseInt(reservationData.accommodationId),
        checkin: reservationData.checkin,
        checkout: reservationData.checkout,
        guests: parseInt(reservationData.guests),
        status: 'pending',
        createdAt: new Date().toISOString()
    };
    
    reservations.push(newReservation);
    
    if (saveToStorage('reservations', reservations)) {
        return { success: true, message: 'Reserva realizada com sucesso! Aguarde a confirmação.' };
    } else {
        return { success: false, message: 'Erro ao salvar reserva. Tente novamente.' };
    }
}

// Verificar disponibilidade
function isAvailable(type, accommodationId, checkin, checkout) {
    const reservations = loadFromStorage('reservations') || [];
    const newCheckin = new Date(checkin);
    const newCheckout = new Date(checkout);
    
    const conflict = reservations.some(reservation => {
        if (reservation.type === type && reservation.accommodationId === parseInt(accommodationId) && reservation.status !== 'cancelled') {
            const existingCheckin = new Date(reservation.checkin);
            const existingCheckout = new Date(reservation.checkout);
            return (newCheckin < existingCheckout && newCheckout > existingCheckin);
        }
        return false;
    });
    
    return !conflict;
}

// Carregar reservas do usuário
function loadUserReservations() {
    const reservationsContent = document.getElementById('reservations-content');
    if (!reservationsContent) return;
    
    const user = getCurrentUser();
    
    if (!user) {
        reservationsContent.innerHTML = `
            <div class="message info">
                <h3>🔒 Acesso Restrito</h3>
                <p>Você precisa estar logado para ver suas reservas.</p>
                <div class="auth-actions">
                    <a href="login.html" class="btn-primary">Fazer Login</a>
                    <a href="register.html" class="btn-secondary">Criar Conta</a>
                </div>
            </div>
        `;
        return;
    }
    
    const allReservations = loadFromStorage('reservations') || [];
    const userReservations = allReservations.filter(r => r.userId === user.id);
    const chalets = loadFromStorage('chalets') || [];
    const kiosques = loadFromStorage('kiosques') || [];
    
    if (userReservations.length === 0) {
        reservationsContent.innerHTML = `
            <div class="message info">
                <h3>📅 Nenhuma Reserva Encontrada</h3>
                <p>Você ainda não fez nenhuma reserva. Que tal conhecer nossos chalés e quiosques?</p>
                <div class="reservation-actions">
                    <button class="btn-primary" id="new-reservation-btn">Fazer Primeira Reserva</button>
                    <a href="chalets.html" class="btn-secondary">Ver Chalés</a>
                    <a href="kiosques.html" class="btn-secondary">Ver Quiosques</a>
                </div>
            </div>
        `;
        
        document.getElementById('new-reservation-btn').addEventListener('click', function() {
            openReservationModal('chalet', 1);
        });
    } else {
        reservationsContent.innerHTML = `
            <div class="reservations-header">
                <h3>Suas Reservas (${userReservations.length})</h3>
                <button class="btn-primary" id="new-reservation-btn">Nova Reserva</button>
            </div>
            <div id="reservations-list" class="reservations-list"></div>
        `;
        
        document.getElementById('new-reservation-btn').addEventListener('click', function() {
            openReservationModal('chalet', 1);
        });
        
        const reservationsList = document.getElementById('reservations-list');
        userReservations.forEach(reservation => {
            let accommodation = null;
            if (reservation.type === 'chalet') {
                accommodation = chalets.find(c => c.id === reservation.accommodationId);
            } else if (reservation.type === 'kiosque') {
                accommodation = kiosques.find(k => k.id === reservation.accommodationId);
            }
            
            if (!accommodation) return;
            
            const reservationCard = document.createElement('div');
            reservationCard.className = 'reservation-card';
            reservationCard.innerHTML = `
                <div class="reservation-info">
                    <h3>${accommodation.name}</h3>
                    <p class="reservation-dates">${formatDate(reservation.checkin)} a ${formatDate(reservation.checkout)}</p>
                    <p>${reservation.guests} pessoa(s) • ${getDaysBetweenDates(reservation.checkin, reservation.checkout)} dia(s)</p>
                </div>
                <div class="reservation-status-container">
                    <span class="reservation-status status-${reservation.status}">${getStatusText(reservation.status)}</span>
                    <div class="reservation-price">R$ ${accommodation.price * getDaysBetweenDates(reservation.checkin, reservation.checkout)}</div>
                </div>
            `;
            
            reservationsList.appendChild(reservationCard);
        });
    }
}

// Obter texto do status
function getStatusText(status) {
    switch (status) {
        case 'pending': return 'Pendente';
        case 'confirmed': return 'Confirmada';
        case 'cancelled': return 'Cancelada';
        default: return status;
    }
}

// Inicializar reservas
document.addEventListener('DOMContentLoaded', function() {
    initAccommodationData();
    
    if (document.getElementById('chalets-grid')) {
        loadChalets();
        initModal('chalet-modal');
    }
    
    if (document.getElementById('kiosques-grid')) {
        loadKiosques();
        initModal('kiosque-modal');
    }
    
    if (document.getElementById('reservations-content')) {
        loadUserReservations();
        initModal('reservation-modal');
        
        const reservationForm = document.getElementById('reservation-form');
        if (reservationForm) {
            reservationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(reservationForm);
                const reservationData = {
                    type: formData.get('accommodation-type'),
                    accommodationId: formData.get('accommodation-id'),
                    checkin: formData.get('checkin'),
                    checkout: formData.get('checkout'),
                    guests: formData.get('guests')
                };
                
                const result = makeReservation(reservationData);
                
                if (result.success) {
                    alert(result.message);
                    closeModal('reservation-modal');
                    window.location.reload();
                } else {
                    alert(result.message);
                }
            });
        }
        
        const typeSelect = document.getElementById('accommodation-type');
        if (typeSelect) {
            typeSelect.addEventListener('change', function() {
                const accommodationSelect = document.getElementById('accommodation-id');
                if (accommodationSelect) {
                    accommodationSelect.innerHTML = '';
                    
                    let accommodations = [];
                    if (this.value === 'chalet') {
                        accommodations = loadFromStorage('chalets') || [];
                    } else if (this.value === 'kiosque') {
                        accommodations = loadFromStorage('kiosques') || [];
                    }
                    
                    accommodations.forEach(acc => {
                        const option = document.createElement('option');
                        option.value = acc.id;
                        option.textContent = acc.name;
                        accommodationSelect.appendChild(option);
                    });
                }
            });
        }
    }
});