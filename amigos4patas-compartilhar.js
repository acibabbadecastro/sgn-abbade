/**
 * Compartilhamento Module - Amigos de 4 Patas
 * Gerencia botões de compartilhamento em redes sociais
 */

(function() {
    'use strict';

    // Configuração
    const CONFIG = {
        url: 'https://amigos4patas.com.br',
        titulo: '🐾 Amigos de 4 Patas - Parque Meia Lua',
        descricao: 'Ajude animais perdidos, avistados e para adoção no nosso bairro!',
        hashTags: ['AmigosDe4Patas', 'ParqueMeiaLua', 'AdoteNaoCompre']
    };

    /**
     * Inicializa o módulo de compartilhamento
     */
    function init() {
        // Botões existentes - suporta múltiplos formatos de classe
        setupFacebookButtons();
        setupWhatsAppButtons();
        setupTwitterButtons();
        setupCopyButtons();
        
        // Registra eventos de compartilhamento
        trackShares();
    }

    /**
     * Configura botões do Facebook
     */
    function setupFacebookButtons() {
        const buttons = document.querySelectorAll('.share-facebook, .share-fb, [data-share="facebook"]');
        buttons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const animal = btn.getAttribute('data-animal');
                if (animal) {
                    shareAnimal({ nome: animal, tipo: 'perdido' }, 'facebook');
                } else {
                    shareFacebook();
                }
            });
        });
    }

    /**
     * Configura botões do WhatsApp
     */
    function setupWhatsAppButtons() {
        const buttons = document.querySelectorAll('.share-whatsapp, .share-wa, [data-share="whatsapp"]');
        buttons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const animal = btn.getAttribute('data-animal');
                if (animal) {
                    shareAnimal({ nome: animal, tipo: 'perdido' }, 'whatsapp');
                } else {
                    shareWhatsApp();
                }
            });
        });
    }

    /**
     * Configura botões do Twitter/X
     */
    function setupTwitterButtons() {
        const buttons = document.querySelectorAll('.share-twitter, .share-tw, [data-share="twitter"]');
        buttons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const animal = btn.getAttribute('data-animal');
                if (animal) {
                    shareAnimal({ nome: animal, tipo: 'perdido' }, 'twitter');
                } else {
                    shareTwitter();
                }
            });
        });
    }

    /**
     * Configura botões de copiar link
     */
    function setupCopyButtons() {
        const buttons = document.querySelectorAll('.share-copy, .share-link, [data-share="copy"]');
        buttons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                copyLink();
            });
        });
    }

    /**
     * Compartilha no Facebook
     */
    function shareFacebook(url, texto) {
        const shareUrl = url || CONFIG.url;
        const shareText = texto || CONFIG.descricao;
        const encodedUrl = encodeURIComponent(shareUrl);
        const encodedText = encodeURIComponent(shareText);
        
        window.open(
            `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}&quote=${encodedText}`,
            '_blank',
            'width=600,height=400,scrollbars=yes'
        );
        
        registrarCompartilhamento('facebook');
        showToast('📘 Abrindo Facebook...');
    }

    /**
     * Compartilha no WhatsApp
     */
    function shareWhatsApp(url, texto) {
        const shareUrl = url || CONFIG.url;
        const shareText = texto || `${CONFIG.titulo}\n\n${CONFIG.descricao}\n\nAcesse:`;
        const encodedText = encodeURIComponent(`${shareText} ${shareUrl}`);
        
        window.open(
            `https://wa.me/?text=${encodedText}`,
            '_blank'
        );
        
        registrarCompartilhamento('whatsapp');
        showToast('💬 Abrindo WhatsApp...');
    }

    /**
     * Compartilha no Twitter/X
     */
    function shareTwitter(url, texto) {
        const shareUrl = url || CONFIG.url;
        const shareText = texto || `${CONFIG.titulo} - ${CONFIG.descricao}`;
        const hashtags = CONFIG.hashTags.join(',');
        
        window.open(
            `https://twitter.com/intent/tweet?text=${encodeURIComponent(shareText)}&url=${encodeURIComponent(shareUrl)}&hashtags=${hashtags}`,
            '_blank',
            'width=600,height=400'
        );
        
        registrarCompartilhamento('twitter');
        showToast('🐦 Abrindo Twitter...');
    }

    /**
     * Copia link para área de transferência
     */
    async function copyLink(url) {
        const link = url || CONFIG.url;
        
        try {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                await navigator.clipboard.writeText(link);
            } else {
                // Fallback para browsers antigos
                const input = document.createElement('input');
                input.value = link;
                input.style.position = 'fixed';
                input.style.opacity = '0';
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
            }
            
            registrarCompartilhamento('copiar');
            showToast('✅ Link copiado! Cole onde quiser.');
        } catch (err) {
            showToast('❌ Erro ao copiar. Tente manualmente.', 'error');
            console.error('Erro ao copiar:', err);
        }
    }

    /**
     * Gera texto para compartilhamento de animal específico
     */
    function gerarTextoAnimal(animal) {
        const { tipo, nome, local, data, contato, foto } = animal;
        
        let emoji = '🐾';
        let status = '';
        
        switch(tipo) {
            case 'perdido':
                emoji = '😿';
                status = 'PERDIDO';
                break;
            case 'avistado':
                emoji = '👀';
                status = 'AVISTADO';
                break;
            case 'adocao':
                emoji = '🏠';
                status = 'PARA ADOÇÃO';
                break;
        }
        
        let texto = `${emoji} *${status}* ${emoji}\n\n`;
        if (nome) texto += `*Nome:* ${nome}\n`;
        if (local) texto += `*Local:* ${local}\n`;
        if (data) texto += `*Data:* ${data}\n`;
        if (contato) texto += `*Contato:* ${contato}\n`;
        texto += `\n🐕 Amigos de 4 Patas - Parque Meia Lua\n`;
        texto += `${CONFIG.url}`;
        
        return texto;
    }

    /**
     * Compartilha animal específico
     */
    function shareAnimal(animal, rede) {
        const texto = gerarTextoAnimal(animal);
        
        switch(rede) {
            case 'whatsapp':
                window.open(`https://wa.me/?text=${encodeURIComponent(texto)}`, '_blank');
                break;
            case 'facebook':
                shareFacebook(CONFIG.url, texto);
                break;
            case 'twitter':
                shareTwitter(CONFIG.url, texto);
                break;
        }
        
        registrarCompartilhamento(`${rede}-animal`);
    }

    /**
     * Registra compartilhamento no localStorage
     */
    function registrarCompartilhamento(rede) {
        try {
            const hoje = new Date().toISOString().split('T')[0];
            let stats = JSON.parse(localStorage.getItem('a4p_compartilhamentos') || '{}');
            
            if (!stats[rede]) stats[rede] = { total: 0, datas: {} };
            stats[rede].total++;
            stats[rede].datas[hoje] = (stats[rede].datas[hoje] || 0) + 1;
            
            localStorage.setItem('a4p_compartilhamentos', JSON.stringify(stats));
            
            // Dispara evento personalizado
            window.dispatchEvent(new CustomEvent('a4p:compartilhamento', {
                detail: { rede, data: new Date() }
            }));
        } catch (e) {
            console.error('Erro ao registrar:', e);
        }
    }

    /**
     * Mostra notificação toast
     */
    function showToast(message, type = 'success') {
        const existing = document.querySelector('.toast-share');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = 'toast-share';
        toast.textContent = message;
        
        toast.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 15px 30px;
            border-radius: 10px;
            background: ${type === 'error' ? '#e74c3c' : '#27ae60'};
            color: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            z-index: 10000;
            font-weight: 600;
            animation: slideIn 0.3s ease;
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    /**
     * Rastreia compartilhamentos
     */
    function trackShares() {
        // Pode ser usado para analytics futuro
        window.addEventListener('a4p:compartilhamento', (e) => {
            console.log('📤 Compartilhamento:', e.detail);
        });
    }

    // Inicializa quando DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expõe API global
    window.Amigos4Patas = window.Amigos4Patas || {};
    window.Amigos4Patas.Compartilhar = {
        facebook: shareFacebook,
        whatsapp: shareWhatsApp,
        twitter: shareTwitter,
        copiar: copyLink,
        animal: shareAnimal,
        registrar: registrarCompartilhamento
    };
})();
