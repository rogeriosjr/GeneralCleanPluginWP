Como funciona a lixeira no WordPress (resumo rápido)

Quando você “exclui” algo, ele vai pra lixeira

O WordPress roda um cron interno

Por padrão, ele apaga definitivamente após 30 dias

Esse tempo é controlado por uma constante.

1️⃣ O que o WordPress acumula de lixo (sem você perceber)
🗑️ Conteúdo

Posts na lixeira

Páginas na lixeira

Custom Posts na lixeira

Revisões infinitas (post_revision)

Auto-drafts (auto-draft)

🧠 Banco de dados

postmeta órfão (meta sem post)

termmeta órfão

commentmeta órfão

Transients expirados

Transients de plugins que morreram

Opções com autoload = yes desnecessárias

👻 Comentários

Spam

Trash

Pingbacks antigos

🧱 Arquivos

Uploads órfãos (imagem sem post)

Cache antigo

Logs

Backup antigo esquecido

⚙️ Plugins e temas

Tabelas de plugin desinstalado

Opções órfãs no wp_options

👉 Isso tudo deixa o WP lento, inflado e imprevisível.

🧹 Plugin Standalone: Faxina Geral
🎯 Objetivo do protocolo

Remover apenas o lixo que o WordPress consegue recriar sozinho, com segurança, log e controle manual.

Nada de “plugin maluco que apaga coisa importante”.

1️⃣ O que o Faxina Geral vai limpar (escopo v1)
✅ Automático (seguro)

Posts, páginas e CPTs na lixeira

Revisões

Auto-drafts

Comentários spam e trash

Transients expirados

Cache (se houver pasta definida)

❌ Fora do escopo (por enquanto)

Mídia órfã

postmeta órfão

wp_options autoload
👉 Isso entra numa v2, com análise antes.

8️⃣ Filosofia do protocolo (importante)

O Faxina Geral segue 3 regras:

🧠 Só limpa o que o WP recria

🛡️ Nunca roda em page load

📝 Tudo é logado

Isso diferencia plugin sério de plugin perigoso.

🧹 Faxina Geral — Tela de Admin
🎯 O que o admin pode fazer

Rodar a faxina manualmente

Ver o resultado da última execução

Saber exatamente o que o protocolo limpa

2️⃣ O que isso resolve (na prática)

✔ Não roda limpeza escondida
✔ Admin sabe exatamente o que acontece
✔ Log simples e confiável
✔ Sem risco de exclusão acidental
✔ Plugin profissional, não gambiarra

🧪 Modo Dry-Run — Faxina Geral
1️⃣ O que é Dry-Run (na prática)

👉 O plugin:

Conta o que seria apagado

Não executa DELETE

Mostra exatamente o impacto

Usa SELECT COUNT(*) no lugar de DELETE

Fluxo mental:

“Se eu rodar a faxina agora, isso aqui vai embora.”
isso evita 90% das cagadas.

🧹 Faxina Geral — Níveis de Faxina
🎚️ Os níveis (opinião técnica)
1️⃣ Leve (seguro total)

Manutenção diária/semana

Lixeira (posts/páginas/CPTs)

Comentários spam/lixeira

Transients expirados

👉 Nada estrutural.

2️⃣ Geral (manutenção real)

Limpeza padrão de produção

Tudo do Leve +

Revisões

Auto-drafts

👉 Esse é o default recomendado.

3️⃣ Pós-Guerra (manual e consciente)

Depois de testes, migração, plugin removido

Tudo do Geral +

Transients não expirados (flush)

Cache conhecido (se existir)

👉 Nunca automático. Só botão manual.