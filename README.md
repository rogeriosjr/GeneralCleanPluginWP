# 🧹 Faxina Geral

**Faxina Geral** é um plugin de manutenção avançada para WordPress que realiza limpeza segura e controlada de dados desnecessários, com suporte a **Dry Run (simulação)**, **níveis de limpeza**, **lock contra execução simultânea** e **integração com WP-CLI**.

O plugin foi projetado para administradores que precisam de **controle**, **segurança** e **transparência**, sem depender de soluções mágicas ou perigosas.

---

## ✨ Funcionalidades

### 🔍 Modo Dry Run (Simulação)
- Nenhum dado é removido
- Exibe exatamente **o que seria apagado**
- Ideal para validação antes da execução real

> 💡 Recomenda-se sempre executar primeiro em Dry Run.

---

### 🧼 Níveis de Faxina

Escolha o nível de agressividade da limpeza:

- **Leve**
  - Revisões antigas
  - Transients expirados
  - Limpeza básica e segura

- **Normal**
  - Metadados órfãos
  - Rascunhos antigos
  - Dados não utilizados comuns

- **Pesada**
  - Faxina completa
  - Resíduos de plugins antigos
  - Dados acumulados sem uso

Cada nível foi pensado para minimizar riscos ao funcionamento do site.

---

### 🔐 Lock Anti-Execução Simultânea

Evita que a faxina seja executada ao mesmo tempo por:

- Painel administrativo
- WP-CLI
- Cron

Isso garante:
- Integridade dos dados
- Nenhuma exclusão concorrente
- Segurança em produção

---

### 🧰 Integração com WP-CLI

Permite executar a faxina via terminal, ideal para automações e servidores.

**Dry Run via CLI:**
```bash
wp faxina-geral run --level=normal --dry-run
