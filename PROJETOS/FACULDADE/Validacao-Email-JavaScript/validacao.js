/**
 * TRABALHO PRÁTICO - VALIDAÇÃO DE E-MAIL EM JAVASCRIPT
 * 
 * Aluno: Acib Abbade de Castro
 * Curso: Análise e Desenvolvimento de Sistemas
 * Instituição: UNOPAR
 * Data: 02/05/2026
 */

// ===========================================
// FUNÇÃO PRINCIPAL DE VALIDAÇÃO
// ===========================================

/**
 * Valida um endereço de e-mail usando expressão regular
 * @param {string} email - O e-mail a ser validado
 * @returns {boolean} - true se válido, false se inválido
 */
function validarEmail(email) {
    // Expressão regular para validação de e-mail
    // Explicação do padrão:
    // ^                 - Início da string
    // [a-zA-Z0-9._-]+   - Nome do usuário (letras, números, ponto, underline, hífen)
    // @                 - Símbolo @ (obrigatório)
    // [a-zA-Z0-9.-]+    - Nome do domínio
    // \.                - Ponto (obrigatório)
    // [a-zA-Z]{2,}$     - TLD (.com, .br, .org) com mínimo 2 letras
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    
    return regex.test(email);
}

// ===========================================
// FUNÇÃO DE VALIDAÇÃO DETALHADA
// ===========================================

/**
 * Retorna informações detalhadas sobre a validação
 * @param {string} email - O e-mail a ser analisado
 * @returns {object} - Objeto com detalhes da validação
 */
function validarEmailDetalhado(email) {
    const resultado = {
        valido: false,
        mensagem: '',
        erros: []
    };

    // Verifica se está vazio
    if (!email || email.trim() === '') {
        resultado.erros.push('E-mail não pode estar vazio');
        resultado.mensagem = '❌ E-mail não pode estar vazio';
        return resultado;
    }

    // Remove espaços em branco
    email = email.trim();

    // Verifica se tem @
    if (!email.includes('@')) {
        resultado.erros.push('E-mail deve conter @ (arroba)');
    }

    // Verifica se tem apenas um @
    const partes = email.split('@');
    if (partes.length !== 2) {
        resultado.erros.push('E-mail deve conter apenas um @');
    } else {
        const usuario = partes[0];
        const dominio = partes[1];

        // Verifica se tem nome de usuário
        if (usuario.length === 0) {
            resultado.erros.push('Deve haver nome de usuário antes do @');
        }

        // Verifica se tem domínio
        if (dominio.length === 0) {
            resultado.erros.push('Deve haver domínio após o @');
        }

        // Verifica se o domínio tem ponto
        if (!dominio.includes('.')) {
            resultado.erros.push('Domínio deve conter ponto (.)');
        } else {
            const partesDominio = dominio.split('.');
            const tld = partesDominio[partesDominio.length - 1];
            
            // Verifica se o TLD tem pelo menos 2 caracteres
            if (tld.length < 2) {
                resultado.erros.push('Domínio deve ter pelo menos 2 caracteres após o ponto');
            }
        }
    }

    // Verifica se tem espaços
    if (email.includes(' ')) {
        resultado.erros.push('E-mail não pode conter espaços em branco');
    }

    // Verifica caracteres inválidos
    const caracteresInvalidos = /[()#;,:"\\<>]/;
    if (caracteresInvalidos.test(email)) {
        resultado.erros.push('E-mail contém caracteres inválidos');
    }

    // Se não houver erros, e-mail é válido
    if (resultado.erros.length === 0) {
        resultado.valido = true;
        resultado.mensagem = '✅ E-mail válido!';
    } else {
        resultado.mensagem = '❌ Erros encontrados:\n• ' + resultado.erros.join('\n• ');
    }

    return resultado;
}

// ===========================================
// FUNÇÃO DE FORMATAÇÃO
// ===========================================

/**
 * Formata o e-mail para padrão lowercase
 * @param {string} email - E-mail a ser formatado
 * @returns {string} - E-mail formatado
 */
function formatarEmail(email) {
    return email.trim().toLowerCase();
}

// ===========================================
// EVENT LISTENER DO FORMULÁRIO
// ===========================================

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formEmail');
    const emailInput = document.getElementById('email');
    const resultadoDiv = document.getElementById('resultado');

    // Validação em tempo real (enquanto digita)
    emailInput.addEventListener('input', function() {
        const email = this.value;
        
        // Remove classes anteriores
        this.classList.remove('valid', 'invalid');
        
        // Só valida se tiver algum conteúdo
        if (email.length > 0) {
            if (validarEmail(email)) {
                this.classList.add('valid');
            } else {
                this.classList.add('invalid');
            }
        }
    });

    // Validação no submit do formulário
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Previne envio do formulário

        const email = emailInput.value;
        const validacao = validarEmailDetalhado(email);

        // Exibe o resultado
        resultadoDiv.textContent = validacao.mensagem;
        
        // Remove classes anteriores
        resultadoDiv.classList.remove('sucesso', 'erro');

        // Adiciona classe apropriada
        if (validacao.valido) {
            resultadoDiv.classList.add('sucesso');
            
            // Opcional: formatar e-mail para lowercase
            const emailFormatado = formatarEmail(email);
            console.log('E-mail formatado:', emailFormatado);
        } else {
            resultadoDiv.classList.add('erro');
        }
    });
});

// ===========================================
// EXEMPLOS DE TESTE (para console)
// ===========================================

// Execute no console do navegador para testar:
/*
console.log('=== TESTES DE VALIDAÇÃO ===\n');

const testes = [
    'usuario@exemplo.com',           // Válido
    'teste123@dominio.com.br',       // Válido
    'nome.sobrenome@email.org',      // Válido
    'invalido',                      // Inválido (sem @)
    '@dominio.com',                  // Inválido (sem usuário)
    'usuario@',                      // Inválido (sem domínio)
    'usuario@dominio',               // Inválido (sem TLD)
    'usuario@.com',                  // Inválido (domínio vazio)
    'usuario@dominio.c',             // Inválido (TLD curto)
    'espaco em branco@teste.com',    // Inválido (espaços)
    'usuario#invalido@teste.com',    // Inválido (caracteres especiais)
];

testes.forEach(email => {
    const resultado = validarEmailDetalhado(email);
    console.log(`E-mail: ${email}`);
    console.log(`Válido: ${resultado.valido}`);
    console.log(`Mensagem: ${resultado.mensagem}\n`);
});
*/
