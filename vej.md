# Kits trimestrais "Vivos em Jesus" (VEJ)

Todos os trimestres, os quatro kits da Escola Sabatina Infantil — **Primeiros Passos**, **Iniciantes**, **Jardim de Infância** e **Primários** — recebem um novo conjunto de artigos (Guia do Professor, Recursos, Músicas, Playbacks, Podcast, Versos Cantados, Powerpoints/Apresentações).

O comando `wp vej-kits clone` copia os artigos do trimestre anterior para os kits do novo trimestre, trocando o trimestre nos títulos, slugs e links do B2. Poupa a criação manual de ~22 artigos e ~270 linhas de downloads.

```
wp vej-kits clone --from=<trimestre> --to=<trimestre> [--dry-run]
```

| Opção | Descrição |
|---|---|
| `--from` | Trimestre de origem, por ex. `3T` |
| `--to` | Trimestre de destino, por ex. `4T` |
| `--dry-run` | Mostra o que seria criado, sem gravar nada |

## O que o comando faz

Para cada um dos quatro kits:

1. Encontra o kit de origem e o kit de destino pelo título — por ex. `Iniciantes (Ano A - 3T)` → `Iniciantes (Ano A - 4T)`.
2. Copia cada artigo da lista do kit de origem para um **novo artigo em rascunho**:
   - **Título:** `3.ºT` → `4.ºT`, `3T` → `4T`. O slug é gerado de novo a partir do título.
   - **Taxonomias** (Departamentos, Sedes, Owner, Tipos de ficheiros), **imagem de destaque** e termo principal do Yoast: iguais aos do original.
   - **Downloads:** nome, formato e tamanho iguais; no link, a pasta `/3T/` passa a `/4T/` e `3T`, `3º` ou `3_T` no nome do ficheiro passam a `4T`, `4º`, `4_T`.
3. Acrescenta os novos artigos à lista do kit de destino, pela mesma ordem.
4. No fim, lista **todos os caminhos de ficheiros esperados no B2** (bucket `upasd-recursos`), para servir de lista de uploads.

O que o comando **não** faz:

- **Não altera os artigos nem os kits de origem.**
- **Não define a imagem de capa do kit** — a arte muda todos os trimestres, por isso fica a cargo do editor.
- **Não verifica nem envia ficheiros para o B2** — os uploads são manuais.
- **Não publica nada** — os artigos ficam em rascunho, e a página do kit só mostra artigos publicados.

Pode ser executado mais do que uma vez: artigos já copiados para o kit de destino (marcados com o meta `_vej_cloned_from`) são ignorados.

## Passo a passo (produção)

No servidor `deploy@adventistas.org.pt`, na pasta `~/downloads`. O wp-cli corre no serviço `cli`:

```
docker compose --profile debug run --rm -T cli wp <comando>
```

### 1. Criar os kits vazios do novo trimestre

No WordPress, em **Kits → Adicionar novo**, criar os quatro kits com títulos que sigam exatamente o padrão:

- `Primeiros Passos (4T)`
- `Iniciantes (Ano A - 4T)`
- `Jardim de Infância (Ano A - 4T)`
- `Primários (Ano A - 4T)`

O título tem de **começar** pelo nome do grupo e **terminar** em `nT)`. Usar um slug com o trimestre (por ex. `iniciantes-ano-a-4t`), para não ocupar slugs genéricos como `/kits/iniciantes/`.

### 2. Fazer cópia de segurança da base de dados

```
F=~/backups/recursos-db-$(date +%Y%m%d)-pre-vej.sql.gz
docker compose exec -T db sh -c 'exec mysqldump -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" --single-transaction --quick --routines --triggers --events --no-tablespaces --default-character-set=utf8mb4 --databases "$MYSQL_DATABASE" 2>/dev/null' | gzip > "$F"
zcat "$F" | tail -1   # deve terminar em "-- Dump completed on ..."
```

### 3. Simulação

```
docker compose --profile debug run --rm -T cli wp vej-kits clone --from=3T --to=4T --dry-run
```

Confirmar que:

- cada grupo mostra `kit <origem> -> kit <destino>` (sem avisos `kit missing`);
- os títulos têm o trimestre certo;
- a lista de caminhos B2 não tem restos do trimestre antigo.

### 4. Execução

```
docker compose --profile debug run --rm -T cli wp vej-kits clone --from=3T --to=4T
```

Guardar a lista de caminhos B2 que aparece no fim.

### 5. Trabalho manual depois do comando

1. **Enviar os ficheiros para o B2** com os caminhos da lista. Se um ficheiro tiver outro nome, corrigir o link na linha correspondente do artigo.
2. **Rever as linhas de Músicas, Playbacks e Versos Cantados.** Os nomes vêm do trimestre anterior (as músicas e os versos mudam), por isso é preciso atualizar nomes, links e tamanhos. Os Powerpoints/Apresentações (`Lição 1–13`), os Podcasts e o Guia do Professor costumam manter os nomes.
3. **Atualizar os tamanhos** (MB) dos ficheiros que mudaram.
4. **Publicar cada artigo** quando os ficheiros estiverem no B2. O artigo aparece logo na página do kit.
5. **Definir a imagem de capa** de cada kit.

## Resolução de problemas

| Sintoma | Causa / solução |
|---|---|
| `kit missing (source -, target …)` | Não há kit de origem com esse título. Verificar o título do kit do trimestre anterior. |
| `kit missing (source …, target -)` | O kit de destino ainda não existe ou o título não segue o padrão (passo 1). |
| `title of N has no 3T marker` | O título do artigo de origem não tem o trimestre; o artigo é copiado com o mesmo título. Corrigir o título à mão. |
| `= … (already cloned as N)` | Esse artigo já foi copiado numa execução anterior; é ignorado. |
| Artigo em rascunho não aparece no kit | Comportamento esperado — só artigos publicados aparecem. |

## Reverter

- Apagar os rascunhos criados (**Artigos → Rascunhos**) e limpar a lista do kit de destino; ou
- Repor a cópia de segurança:

  ```
  zcat ~/backups/<ficheiro>.sql.gz | docker compose exec -T db sh -c 'mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD"'
  ```

## Código

- Comando: `classes/cli/PA_CLI_VejKits.php` (carregado em `functions.php` só quando o wp-cli está ativo).
- Página do kit: `single-kit.blade.php` — só lista artigos publicados.
