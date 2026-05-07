/**
 * Newsletter Module - Amigos de 4 Patas
 * Gerencia inscrições na newsletter
 */

(function() {
    'use strict';

    // Configuração
    const CONFIG = {
        endpoint: 'salvar-inscricao.php',
        toastDuration: 3000
    };

    /**
     * Inicializa o módulo de newsletter
     */
    function init() {
        const forms = document.querySelectorAll('.newsletter-form');
        forms.forEach(form => {
            form.addEventListener('submit', handleSubmit);
        });
    }

    /**
     * Manipula o envio do formulário
     */
    async function handleSubmit(e) {
        e.preventDefault();
        
        const form = e.target;
        const emailInput = form.querySelector('input[type="email"]');
        const nomeInput = form.querySelector('input[name="nome"], #news-nome');
        const whatsappInput = form.querySelector('input[name="whatsapp"], #news-whatsapp');
        
        const data = {
            email: emailInput ? emailInput.value.trim() : '',
            nome: nomeInput ? nomeInput.value.trim() : '',
            whatsapp: whatsappInput ? whatsappInput.value.replace(/\D/g, '') : ''
        };

        // Validação
        if (!data.email && !data.whatsapp) {
            showToast('❌ Informe email ou WhatsApp', 'error');
            return;
        }

        if (data.whatsapp && data.whatsapp.length !== 11) {
            showToast('❌ WhatsApp deve ter 11 dígitos (DDD + número)', 'error');
            return;
        }

        showToast('⏳ Enviando...', 'info');

        try {
            const response = await fetch(CONFIG.endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(data)
            });

            const result = await response.json();

            if (result.success) {
                showToast('✅ ' + result.message, 'success');
                form.reset();
            } else {
                showToast('❌ ' + (result.message || 'Erro ao inscrever'), 'error');
            }
        } catch (error) {
            // Modo offline - salva localmente
            saveLocal(data);
            showToast('✅ Inscrição salva! (modo offline)', 'success');
            form.reset();
        }
    }

    /**
     * Salva inscrição localmente (modo offline)
     */
    function saveLocal(data) {
        let inscricoes = JSON.parse(localStorage.getItem('a4p_newsletter_pending') || '[]');
        inscricoes.push({
            ...data,
            data: new Date().toISOString()
        });
        localStorage.setItem('a4p_newsletter_pending', JSON.stringify(inscricoes));
    }

    /**
     * Mostra notificação toast
     */
    function showToast(message, type = 'info') {
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) existingToast.remove();

        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.textContent = message;
        
        // Estilos base
        toast.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            z-index: 10000;
            font-weight: 600;
            animation: slideIn 0.3s ease;
        `;

        // Cores por tipo
        const colors = {
            success: '#27ae60',
            error: '#e74c3c',
            info: '#3498db'
        };
        toast.style.background = colors[type] || colors.info;
        toast.style.color = 'white';

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, CONFIG.toastDuration);
    }

    // Inicializa quando DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expõe API global
    window.Amigos4Patas = window.Amigos4Patas || {};
    window.Amigos4Patas.Newsletter = {
        subscribe: (data) => handleSubmit({ preventDefault: () => {}, target: { dataset } })
    };
})();
