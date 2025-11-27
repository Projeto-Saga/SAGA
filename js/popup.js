/**
 * Sistema de Popup Centralizado Reutilizável
 * Uso: 
 * - Popup.success('Mensagem de sucesso');
 * - Popup.error('Mensagem de erro');
 * - Popup.info('Mensagem informativa');
 */

class Popup {
    static createPopup(message, type = 'info') {
        // Remover popup anterior se existir
        const existingPopup = document.querySelector('.custom-popup');
        const existingOverlay = document.querySelector('.popup-overlay');
        if (existingPopup) existingPopup.remove();
        if (existingOverlay) existingOverlay.remove();

        // Criar overlay
        const overlay = document.createElement('div');
        overlay.className = 'popup-overlay';
        
        // Criar elemento do popup
        const popup = document.createElement('div');
        popup.className = `custom-popup custom-popup-${type}`;
        
        // Ícones para cada tipo
        const icons = {
            success: '✓',
            error: '✗',
            info: 'ℹ'
        };

        // Títulos para cada tipo
        const titles = {
            success: 'Sucesso!',
            error: 'Erro!',
            info: 'Informação'
        };

        popup.innerHTML = `
            <div class="popup-content">
                <span class="popup-icon">${icons[type]}</span>
                <div class="popup-message">
                    <strong>${titles[type]}</strong><br>
                    ${message}
                </div>
                <button class="popup-close" onclick="Popup.close()">Fechar</button>
            </div>
        `;

        // Adicionar ao body
        document.body.appendChild(overlay);
        document.body.appendChild(popup);

        // Animar entrada
        setTimeout(() => {
            overlay.classList.add('show');
            popup.classList.add('show');
        }, 10);

        // Auto-remover após 4 segundos (opcional)
        if (type !== 'error') {
            setTimeout(() => {
                this.close();
            }, 4000);
        }

        // Fechar ao clicar no overlay
        overlay.addEventListener('click', () => {
            this.close();
        });
    }

    static success(message) {
        this.createPopup(message, 'success');
    }

    static error(message) {
        this.createPopup(message, 'error');
    }

    static info(message) {
        this.createPopup(message, 'info');
    }

    static close() {
        const popup = document.querySelector('.custom-popup');
        const overlay = document.querySelector('.popup-overlay');
        
        if (popup) {
            popup.classList.remove('show');
            setTimeout(() => {
                popup.remove();
            }, 300);
        }
        
        if (overlay) {
            overlay.classList.remove('show');
            setTimeout(() => {
                overlay.remove();
            }, 300);
        }
    }
}

// Fechar com ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        Popup.close();
    }
});