🧹 Faxina Geral

Faxina Geral é um plugin de manutenção avançada para WordPress que realiza limpeza segura e controlada de dados desnecessários, com suporte a simulação (Dry Run), níveis de limpeza, bloqueio contra execução simultânea e integração com WP-CLI.

Ele foi pensado para administradores que querem controle total, zero risco e transparência antes de qualquer remoção definitiva.

✨ Principais Funcionalidades
🔍 Modo Dry Run (Simulação)

Nenhum dado é removido

Mostra exatamente o que seria apagado

Ideal para validação antes da execução real

💡 Recomendado usar sempre o Dry Run antes da limpeza definitiva.

🧼 Níveis de Faxina

Você escolhe o quanto o sistema será agressivo na limpeza:

Leve
Limpeza básica e segura (revisões antigas, transients expirados)

Normal
Remove dados órfãos comuns (metadados inválidos, rascunhos antigos)

Pesada
Faxina completa (itens não utilizados, lixo acumulado por plugins antigos)

Cada nível é projetado para evitar impactos no funcionamento do site.

🔐 Lock Anti-Execução Simultânea

Evita que a limpeza seja executada ao mesmo tempo por:

Painel administrativo

WP-CLI

Cron

Isso garante:

Consistência dos dados

Nenhum conflito de exclusão

Segurança em ambientes de produção

🧰 Integração com WP-CLI

Permite executar a Faxina Geral via terminal, ideal para servidores, automações e DevOps.

Exemplo:

wp faxina-geral run --level=normal --dry-run


Ou execução real:

wp faxina-geral run --level=pesada

🛠 Interface no Painel Administrativo

O plugin adiciona um submenu em:

Ferramentas → Faxina Geral

A interface mostra:

Opções de nível de limpeza

Status do Dry Run

Relatório resumido da faxina

Alertas de segurança

🚀 Como Usar (Passo a Passo)
1️⃣ Acesse o Plugin

No painel do WordPress:

Ferramentas → Faxina Geral

2️⃣ Escolha o Nível de Faxina

Selecione o nível desejado:

Leve

Normal

Pesada

3️⃣ Ative o Dry Run (Recomendado)

Marque a opção Dry Run para simular a limpeza.

👉 Nenhum dado será apagado.

4️⃣ Execute

Clique em Executar Faxina e analise o relatório.

Se estiver tudo correto, desative o Dry Run e execute novamente.

⚠️ Boas Práticas Importantes

✅ Faça backup antes de rodar uma faxina pesada

✅ Use Dry Run sempre que possível

❌ Não execute múltiplas vezes seguidas sem necessidade

❌ Evite rodar em horários de pico de acesso

🔒 Segurança

Apenas usuários com permissão de administrador podem executar

Uso de nonce para evitar CSRF

Lock interno impede execução concorrente

Código segue padrões modernos (PSR-4, namespaces, separação de responsabilidades)

🧠 Filosofia do Plugin

O Faxina Geral segue três princípios:

Nada acontece sem você saber

Simular antes de apagar

Manutenção é ferramenta, não rotina cega

Ele não tenta ser mágico — ele é previsível, auditável e seguro.

🧩 Compatibilidade

WordPress 6.x ou superior

PHP 8.1+

Compatível com ambientes Docker, VPS e hospedagens tradicionais

Totalmente funcional sem dependência de plugins terceiros

📦 Instalação

Faça upload da pasta do plugin em:

wp-content/plugins/


Ative o plugin no painel administrativo

Acesse Ferramentas → Faxina Geral

🧪 Ambiente de Produção

Em ambientes críticos, recomenda-se:

Usar WP-CLI

Executar Dry Run

Rodar fora do horário de pico

📄 Licença

Este plugin é distribuído sob a licença MIT.

🧹 Faxina Geral

“Limpar é fácil. Limpar com segurança é profissional.”