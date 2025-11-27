/**
 * Gerador automático de email para alunos
 * Baseado no nome completo: Guilherme Santos -> Guilherme.Santos@maltec.sp.gov.br
 * Se já existir, incrementa: Guilherme.Santos2@maltec.sp.gov.br
 */

class EmailGenerator {
    static DOMAIN = '@maltec.sp.gov.br';
    
    /**
     * Gera email baseado no nome completo
     * @param {string} nomeCompleto - Nome completo do usuário
     * @returns {Promise<string>} - Email gerado
     */
    static async gerarEmail(nomeCompleto) {
        if (!nomeCompleto || nomeCompleto.trim().length < 3) {
            return '';
        }

        // Limpa e formata o nome
        const emailBase = this.formatarNomeParaEmail(nomeCompleto);
        
        // Verifica se o email já existe e encontra a próxima versão disponível
        const emailFinal = await this.verificarEmailDisponivel(emailBase);
        
        return emailFinal;
    }

    /**
     * Formata o nome para o padrão de email
     * @param {string} nomeCompleto - Nome completo
     * @returns {string} - Nome formatado para email
     */
    static formatarNomeParaEmail(nomeCompleto) {
        // Remove espaços extras e divide em partes
        const partes = nomeCompleto.trim().toLowerCase().split(/\s+/);
        
        if (partes.length === 1) {
            // Se só tem um nome, usa ele
            return this.removerAcentos(partes[0]);
        } else {
            // Pega primeiro e último nome
            const primeiroNome = this.removerAcentos(partes[0]);
            const ultimoNome = this.removerAcentos(partes[partes.length - 1]);
            
            return `${primeiroNome}.${ultimoNome}`;
        }
    }

    /**
     * Remove acentos e caracteres especiais
     * @param {string} texto - Texto para limpar
     * @returns {string} - Texto sem acentos
     */
    static removerAcentos(texto) {
        return texto
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]/g, '') // Remove caracteres especiais
            .toLowerCase();
    }

    /**
     * Verifica se o email já existe e encontra próxima versão disponível
     * @param {string} emailBase - Email base (sem número)
     * @returns {Promise<string>} - Email disponível
     */
    static async verificarEmailDisponivel(emailBase) {
    try {
        // Faz requisição para verificar emails existentes
        const response = await fetch('../verificarEmail.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `email_base=${encodeURIComponent(emailBase)}`
        });

        if (!response.ok) {
            throw new Error('Erro ao verificar email');
        }

        const data = await response.json();
        
        if (data.success) {
            return data.email_disponivel;
        } else {
            console.error('Erro do servidor:', data.message);
            // Fallback: tenta gerar localmente com número alto
            return emailBase + Math.floor(Math.random() * 1000) + this.DOMAIN;
        }

    } catch (error) {
        console.error('Erro ao verificar email:', error);
        // Fallback mais robusto
        return emailBase + Date.now().toString().slice(-3) + this.DOMAIN;
    }
}

    /**
     * Inicializa o gerador de email no campo de nome
     * @param {string} nomeSelector - Seletor do campo nome
     * @param {string} emailSelector - Seletor do campo email
     */
    static inicializar(nomeSelector, emailSelector) {
        const campoNome = document.querySelector(nomeSelector);
        const campoEmail = document.querySelector(emailSelector);

        if (!campoNome || !campoEmail) {
            console.warn('Campos de nome ou email não encontrados');
            return;
        }

        // Debounce para não fazer muitas requisições
        let timeoutId;

        campoNome.addEventListener('input', function() {
            clearTimeout(timeoutId);
            
            // Só gera email se o campo email estiver vazio ou contiver o domínio padrão
            const emailAtual = campoEmail.value;
            if (!emailAtual || emailAtual.includes(EmailGenerator.DOMAIN)) {
                timeoutId = setTimeout(async () => {
                    if (this.value.trim().length >= 3) {
                        try {
                            // Mostra loading
                            campoEmail.placeholder = 'Gerando email...';
                            campoEmail.disabled = true;
                            
                            const emailGerado = await EmailGenerator.gerarEmail(this.value);
                            campoEmail.value = emailGerado;
                            
                        } catch (error) {
                            console.error('Erro ao gerar email:', error);
                            // Fallback: gera email localmente
                            const emailBase = EmailGenerator.formatarNomeParaEmail(this.value);
                            campoEmail.value = emailBase + EmailGenerator.DOMAIN;
                        } finally {
                            campoEmail.disabled = false;
                            campoEmail.placeholder = 'E-mail';
                        }
                    }
                }, 800); // Aguarda 800ms após parar de digitar
            }
        });

        // Permite edição manual do email
        campoEmail.addEventListener('focus', function() {
            this.removeAttribute('readonly');
        });

        campoEmail.addEventListener('blur', function() {
            // Se o usuário não digitou um domínio, adiciona o padrão
            if (this.value && !this.value.includes('@') && !this.value.includes(EmailGenerator.DOMAIN)) {
                this.value += EmailGenerator.DOMAIN;
            }
        });
    }
}