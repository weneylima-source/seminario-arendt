<?php
/**
 * Conteúdo da apresentação.
 *
 * Cada slide é um "quadro" posicionado no grande mapa (estilo Prezi):
 *   pos => [x, y, rotação em graus, escala]
 * Basta alterar esses números para reorganizar o percurso da câmera.
 *
 * O campo "layout" escolhe o modelo de renderização em includes/render.php.
 * "notas" aparece no painel de notas do apresentador (botão "Notas" ou tecla N).
 */

return [
    'meta' => [
        'titulo'      => 'Projeto de vida e responsabilidade pelo mundo comum',
        'subtitulo'   => 'Hannah Arendt diante da polarização contemporânea',
        'instituicao' => 'UNIVERSIDADE CATÓLICA DE BRASÍLIA · Faculdade de Psicologia',
        'autores'     => 'Nicole Alves, Thayane, Ryan e Weney',
        'data'        => '[Data]',
    ],

    'slides' => [

        /* 1 ─────────────────────────────────────────── */
        [
            'layout' => 'titulo',
            'pos'    => [0, 0, 0, 1.3],
            'rotulo' => 'Abertura',
            'eyebrow'=> 'Seminário · Psicologia',
            'notas'  => 'Bom dia a todos. Nosso seminário pergunta como construir um projeto de vida que não se reduza a sobreviver, estudar e trabalhar, mas assuma responsabilidade pelo mundo comum.',
        ],

        /* 2 ─────────────────────────────────────────── */
        [
            'layout' => 'problema',
            'pos'    => [0, -2300, -3, 0.9],
            'rotulo' => 'O problema',
            'eyebrow'=> 'O problema',
            'titulo' => 'Como viver em um tempo de pressão para obedecer?',
            'itens'  => [
                ['grupo',        'Pressões para repetir opiniões do grupo'],
                ['silencio',     'Medo de discordar de colegas, chefias, famílias ou comunidades'],
                ['fogo',         'Polêmicas morais transformadas em “guerra” entre bons e maus'],
                ['jornal',       'Desinformação circulando mais rápido do que a reflexão'],
                ['olho-fechado', 'Omissão diante de discriminação e injustiça'],
            ],
            'numero' => 70,
            'numero_legenda' => 'mais chance de ser retuitada: notícias falsas × verdadeiras (Twitter, 2006–2017)',
            'fonte'  => 'Fontes: Vosoughi, Roy e Aral (2018); Asch (1956); Wardle e Derakhshan (2017)',
            'notas'  => 'Vivemos um momento em que muitas pessoas sentem que precisam escolher um lado antes mesmo de pensar. Arendt pergunta: é possível manter convicções sem abandonar a capacidade de julgar por conta própria?',
        ],

        /* 3 ─────────────────────────────────────────── */
        [
            'layout' => 'linha_tempo',
            'pos'    => [1909, -1660, -9, 0.8],
            'rotulo' => 'Quem foi Arendt',
            'eyebrow'=> 'Quem foi Arendt',
            'titulo' => 'Hannah Arendt <em>(1906–1975)</em>',
            'marcos' => [
                ['1906', 'Nasce na Alemanha'],
                ['1933', 'Deixa a Alemanha'],
                ['1941', 'Exílio nos EUA'],
                ['1951', 'Origens do totalitarismo'],
                ['1958', 'A condição humana'],
                ['1963', 'Eichmann em Jerusalém'],
            ],
            'itens'  => [
                ['mapa',        'Pensadora alemã-judia, exilada do nazismo'],
                ['instituicao', 'Analisou totalitarismo, responsabilidade e vida política'],
                ['cerebro',     'Pensar, julgar e agir: responsabilidade de cada pessoa'],
                ['pessoas',     'A política nasce da pluralidade: pessoas diferentes falando e agindo juntas'],
            ],
            'fonte'  => 'Fontes: Young-Bruehl (1997); Arendt (1951; 1958; 1963)',
            'notas'  => 'Arendt não oferece um manual de conduta, mas uma forma de resistência: pensar quando todos exigem obediência, julgar quando todos repetem e agir quando o silêncio parece mais seguro.',
        ],

        /* 4 ─────────────────────────────────────────── */
        [
            'layout' => 'triade',
            'pos'    => [2733, 384, 5, 1.0],
            'rotulo' => 'Conceitos centrais',
            'eyebrow'=> 'Conceitos centrais',
            'titulo' => 'Trabalho, obra e ação',
            'cards'  => [
                ['broto',   'Trabalho', 'Manutenção da vida e consumo: renda, moradia, saúde'],
                ['martelo', 'Obra',     'Produção de um mundo durável: formação, profissão, instituições'],
                ['dialogo', 'Ação',     'Palavras e atos entre pessoas: deliberar, denunciar, cuidar do coletivo'],
            ],
            'fonte'  => 'Fontes: Arendt, A condição humana (1958)',
            'notas'  => 'O trabalho garante a sobrevivência; a obra constrói algo que permanece; a ação acontece entre as pessoas e é aí que nasce a responsabilidade política.',
        ],

        /* 5 ─────────────────────────────────────────── */
        [
            'layout' => 'aneis',
            'pos'    => [1628, 2508, 8, 0.75],
            'rotulo' => 'Projeto de vida',
            'eyebrow'=> 'Projeto de vida',
            'titulo' => 'Um projeto de vida não é apenas carreira',
            'itens'  => [
                ['casa',    'Sobreviver',         'Garantir condições materiais de existência'],
                ['estrela', 'Realizar-se',        'Construir competências, obra e legado'],
                ['globo',   'Pertencer ao mundo', 'Agir com outras pessoas diante de problemas comuns'],
            ],
            'pergunta' => 'Meu projeto inclui apenas o que eu ganho, ou também o mundo que ajudo a sustentar?',
            'fonte'  => 'Fontes: Arendt (1958); Damon (2009)',
            'notas'  => 'Um projeto centrado só no trabalho pode virar sobrevivência; centrado só na obra, busca de reconhecimento. Ele se torna ético e político quando inclui ação.',
        ],

        /* 6 ─────────────────────────────────────────── */
        [
            'layout' => 'citacao',
            'pos'    => [-888, 3095, -7, 0.85],
            'rotulo' => 'Pensamento',
            'eyebrow'=> 'Pensamento',
            'titulo' => 'Pensar é interromper a repetição',
            'citacao'=> '“Eu só cumpri ordens”',
            'citacao_legenda' => 'não elimina a responsabilidade pessoal',
            'itens'  => [
                ['cerebro',    'Pensar não é ter todas as respostas'],
                ['pensamento', 'É dialogar consigo mesmo sobre o que fazemos e aceitamos'],
                ['robo',       'A ausência de pensamento facilita a obediência automática'],
            ],
            'fonte'  => 'Fontes: Arendt, A vida do espírito (1978); Eichmann em Jerusalém (1963)',
            'notas'  => 'Para Arendt, o perigo não está apenas nas pessoas cruéis, mas também nas que deixaram de perguntar se aquilo que fazem é justo.',
        ],

        /* 7 ─────────────────────────────────────────── */
        [
            'layout' => 'balanca',
            'pos'    => [-3127, 1458, -6, 0.8],
            'rotulo' => 'Julgamento',
            'eyebrow'=> 'Julgamento',
            'titulo' => 'Julgar sem abandonar a pluralidade',
            'itens'  => [
                ['troca',          'Julgar exige imaginar o ponto de vista do outro'],
                ['aperto-de-maos', 'Não confundir convicção com imposição'],
                ['balanca',        'Não confundir respeito à diferença com aceitação de injustiça'],
                ['pessoas',        'O julgamento se fortalece no encontro com pessoas diferentes'],
            ],
            'fonte'  => 'Fontes: Arendt, Conferências sobre a filosofia política de Kant (1982); Responsabilidade e julgamento (2003)',
            'notas'  => 'Julgar não é condenar rapidamente: é pesar, escutar, comparar e assumir uma posição, mesmo quando ela desagrada o grupo.',
        ],

        /* 8 ─────────────────────────────────────────── */
        [
            'layout' => 'destaque',
            'visual' => 'multidao',
            'pos'    => [-3362, -1497, 9, 0.9],
            'rotulo' => 'Pluralidade',
            'eyebrow'=> 'Pluralidade',
            'titulo' => 'A política começa na diferença',
            'destaque' => 'Iguais em humanidade, nunca idênticos',
            'destaque_legenda' => 'a pluralidade é condição da liberdade',
            'itens'  => [
                ['grupo',      'Somos iguais em humanidade, mas nunca idênticos'],
                ['microfone',  'A liberdade se realiza na fala e na ação públicas'],
                ['proibido',   'Reduzir o outro a inimigo destrói o espaço comum'],
            ],
            'fonte'  => 'Fontes: Arendt, A condição humana (1958)',
            'notas'  => 'Quando só queremos convivência com quem pensa como nós, deixamos de viver politicamente e passamos a viver em guetos.',
        ],

        /* 9 ─────────────────────────────────────────── */
        [
            'layout' => 'dupla',
            'pos'    => [-1143, -3739, 4, 0.85],
            'rotulo' => 'Liberdade política',
            'eyebrow'=> 'Liberdade política',
            'titulo' => 'Liberdade não é apenas “fazer o que quero”',
            'paineis'=> [
                ['porta',   'Liberdade política',        ['Participar da construção do mundo comum', 'Exige escuta, palavra, discordância e compromisso'], 'luz'],
                ['cadeado', 'Quando a unidade sufoca',   ['Uma comunidade muito unida pode sufocar a liberdade', 'Unidade não pode significar eliminação da diferença'], 'sombra'],
            ],
            'fonte'  => 'Fontes: Arendt, “O que é liberdade?”, em Entre o passado e o futuro (1961)',
            'notas'  => 'Há discursos que prometem unidade, ordem e pureza moral, mas cobram um preço alto: o silêncio das dúvidas e a exclusão dos diferentes.',
        ],

        /* 10 ────────────────────────────────────────── */
        [
            'layout' => 'destaque',
            'visual' => 'broto',
            'pos'    => [2194, -3511, -10, 1.0],
            'rotulo' => 'Natalidade',
            'eyebrow'=> 'Natalidade',
            'titulo' => 'Natalidade: a capacidade de começar algo novo',
            'destaque' => 'Ninguém está condenado a repetir o mundo que recebeu',
            'destaque_legenda' => 'cada pessoa chega ao mundo como alguém singular',
            'itens'  => [
                ['trajeto',  'Mudar de trajetória é um ato de natalidade'],
                ['caminhos', 'Toda ação traz consequências imprevisíveis'],
                ['broto',    'Começar de novo: rever uma opinião, sair de um ambiente opressor, defender quem foi silenciado'],
            ],
            'fonte'  => 'Fontes: Arendt, A condição humana (1958)',
            'notas'  => 'A natalidade nos lembra que é possível começar de novo: rever uma opinião, sair de um ambiente opressor, defender alguém silenciado.',
        ],

        /* 11 ────────────────────────────────────────── */
        [
            'layout' => 'fluxo',
            'pos'    => [4316, -684, -1, 0.8],
            'rotulo' => 'Estudo de caso',
            'eyebrow'=> 'Estudo de caso',
            'titulo' => 'Caso: desinformação e omissão institucional',
            'etapas' => [
                ['megafone',        'Circula na universidade um conteúdo falso sobre uma minoria'],
                ['coracao-partido', 'Linguagem moral e emocional gera medo'],
                ['compartilhar',    'Colegas repetem a informação sem verificar'],
                ['instituicao',     'A instituição sabe, mas evita se posicionar'],
            ],
            'fonte'  => 'Fontes: Wardle e Derakhshan (2017); Arendt, “Verdade e política” (1961)',
            'notas'  => 'Esse caso mostra que desinformação não é apenas erro de informação: organiza emoções, inimigos e silêncios.',
        ],

        /* 12 ────────────────────────────────────────── */
        [
            'layout' => 'quadrantes',
            'pos'    => [3524, 2957, 10, 0.9],
            'rotulo' => 'Análise',
            'eyebrow'=> 'Análise',
            'titulo' => 'Leitura arendtiana do caso',
            'cards'  => [
                ['broto',        'Trabalho', 'Medo de perder vínculos, emprego ou aceitação social', ''],
                ['instituicao',  'Obra',     'A universidade deveria formar pensamento crítico', ''],
                ['conversa',     'Ação',     'Questionar, verificar, acolher e responder publicamente', ''],
                ['olho-fechado', 'Omissão',  'Deixar que o medo substitua o julgamento', 'alerta'],
            ],
            'fonte'  => 'Fontes: Arendt, A condição humana (1958); Responsabilidade e julgamento (2003)',
            'notas'  => 'A omissão institucional também é uma ação: mantém condições para que a injustiça continue.',
        ],

        /* 13 ────────────────────────────────────────── */
        [
            'layout' => 'checklist',
            'pos'    => [84, 4829, -1, 0.85],
            'rotulo' => 'Proposta',
            'eyebrow'=> 'Proposta',
            'titulo' => 'Responsabilidade pública em prática',
            'itens'  => [
                ['lupa',      'Verificar a informação antes de compartilhar'],
                ['etiqueta',  'Nomear o problema sem desumanizar as pessoas'],
                ['apoio',     'Apoiar quem foi atingido'],
                ['escudo',    'Cobrar posicionamento e protocolos da instituição'],
                ['debate',    'Criar espaços de escuta e debate'],
                ['ampulheta', 'Assumir que nenhuma ação garante resultado imediato'],
            ],
            'fonte'  => 'Fontes: Arendt, Responsabilidade e julgamento (2003); Wardle e Derakhshan (2017)',
            'notas'  => 'A responsabilidade não exige heroísmo diário; exige não se tornar cúmplice do silêncio.',
        ],

        /* 14 ────────────────────────────────────────── */
        [
            'layout' => 'conclusao',
            'pos'    => [-3760, 3386, -10, 1.05],
            'rotulo' => 'Conclusão',
            'eyebrow'=> 'Conclusão',
            'titulo' => 'Um projeto de vida responsável',
            'itens'  => [
                'Inclui sobrevivência, mas não se reduz a ela',
                'Constrói obra, mas não confunde sucesso com isolamento',
                'Exige ação, escuta e coragem de julgar',
                'Reconhece a pluralidade como condição da liberdade',
                'Confia na capacidade humana de começar algo novo',
            ],
            'pergunta' => 'Que mundo estamos ajudando a construir?',
            'fonte'  => 'Fontes: Arendt (1958; 1961; 1963; 2003)',
            'notas'  => 'Não se trata de ter todas as respostas, mas de não renunciar à pergunta sobre o mundo que estamos construindo.',
        ],

        /* 15 ────────────────────────────────────────── */
        [
            'layout' => 'referencias',
            'pos'    => [-5251, -645, 4, 0.8],
            'rotulo' => 'Referências',
            'eyebrow'=> 'Referências',
            'titulo' => 'Referências',
            'colunas'=> [
                'Obras de Arendt' => [
                    'ARENDT, Hannah. <i>A condição humana</i>. Rio de Janeiro: Forense Universitária.',
                    'ARENDT, Hannah. <i>Responsabilidade e julgamento</i>. Trad. Rosaura Eichenberg. São Paulo: Companhia das Letras, 2004.',
                    'ARENDT, Hannah. <i>Entre o passado e o futuro</i>. São Paulo: Perspectiva. (“O que é liberdade?”; “Verdade e política”)',
                    'ARENDT, Hannah. <i>Eichmann em Jerusalém</i>. São Paulo: Companhia das Letras, 1999.',
                    'ARENDT, Hannah. <i>Origens do totalitarismo</i>. São Paulo: Companhia das Letras.',
                    'ARENDT, Hannah. <i>A vida do espírito</i>. Rio de Janeiro: Civilização Brasileira.',
                    'ARENDT, Hannah. <i>Conferências sobre a filosofia política de Kant</i>. Rio de Janeiro: Relume-Dumará, 1993.',
                ],
                'Estudos e pesquisas' => [
                    'LAFER, Celso. <i>Hannah Arendt: pensamento, persuasão e poder</i>. São Paulo: Paz e Terra.',
                    'YOUNG-BRUEHL, Elisabeth. <i>Hannah Arendt: por amor ao mundo</i>. Rio de Janeiro: Relume-Dumará, 1997.',
                    'DAMON, William. <i>O que o jovem quer da vida?</i> São Paulo: Summus, 2009.',
                    'ASCH, S. E. Studies of independence and conformity. <i>Psychological Monographs</i>, v. 70, n. 9, 1956.',
                    'MILGRAM, S. Behavioral study of obedience. <i>J. Abnormal and Social Psychology</i>, v. 67, n. 4, p. 371–378, 1963.',
                    'VOSOUGHI, S.; ROY, D.; ARAL, S. The spread of true and false news online. <i>Science</i>, v. 359, n. 6380, p. 1146–1151, 2018.',
                    'WARDLE, C.; DERAKHSHAN, H. <i>Information Disorder</i>. Council of Europe, 2017.',
                ],
            ],
            'notas'  => 'Referências utilizadas no seminário.',
        ],
    ],
];
