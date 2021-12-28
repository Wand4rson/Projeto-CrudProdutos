## Teste Prático de Conhecimento - Laravel.

Aplicação desenvolvida em Laravel, Teste prático de conhecimento.

## Objeivo

Avaliar o seu conhecimento e habilidades em desenvolvimento Back-End e Front-End.

## Desafio
Criação de CRUD de produtos, tags e extração de relatório de relevância de produtos.

## SQL de extração de relatório

Adicionar aqui o SQL com listagem de Tags mais um sumarizador de Produtos atrelado a cada Tag ..........

SELECT
	produto_tag.tag_id,
	tag.nome AS nometag,
	COUNT(*) AS produtos_count
FROM
	produto_tag produto_tag 
INNER JOIN tag tag ON(tag.id = produto_tag.tag_id)
WHERE
	tag.user_id =:userid
GROUP BY produto_tag.tag_id


## Dicas
- Executar as migrations
- Ou restaurar o dump que esta na pasta dump_demo


## Extras
- Implementado módulo de controle de usuários, para cada um organizar seus cadastros de produtos e TAGs.
- Na listagem de tags existe um relatório/link que permite mostrar todos os produtos vinculados a TAG.
- Na listagem de produtos existe um relatório/link que permite mostrar todas as Tags vinculadas ao produto.
