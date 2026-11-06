<?php
/**
 * Seminário: Projeto de vida e responsabilidade pelo mundo comum
 * Hannah Arendt diante da polarização contemporânea
 *
 * Apresentação cinematográfica estilo Prezi em HTML + PHP + CSS (+ JS para a câmera).
 */
declare(strict_types=1);

require __DIR__ . '/includes/render.php';
$dados  = require __DIR__ . '/data/slides.php';
$meta   = $dados['meta'];
$slides = $dados['slides'];
$total  = count($slides);

/* Palavras gigantes que flutuam no fundo do mapa: [texto, x, y, rotação, tamanho] */
$palavras = [
    ['PENSAR',      -2100,  1900, -18, 620],
    ['JULGAR',      -4700,   300,  80, 560],
    ['AGIR',         3700,  1300, -12, 760],
    ['PLURALIDADE', -2300, -2650,  12, 470],
    ['NATALIDADE',   3400, -2350, -20, 470],
    ['MUNDO COMUM',     0,  6000,   0, 900],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($meta['titulo']) ?> · Hannah Arendt</title>
  <meta name="description" content="<?= e($meta['subtitulo']) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=<?= filemtime(__DIR__ . '/assets/css/style.css') ?>">
</head>
<body class="intro-ativa">

  <!-- Fundo: estrelas com paralaxe e efeito de dobra durante as viagens -->
  <canvas id="estrelas" aria-hidden="true"></canvas>
  <div class="nebulosa" aria-hidden="true"></div>

  <!-- Palco: o "mundo" inteiro é movido pela câmera -->
  <main id="palco" aria-live="polite">
    <div id="mundo">

      <!-- Camada decorativa do mapa -->
      <svg id="mapa-deco" aria-hidden="true">
        <g class="circulos">
          <circle r="1500"/><circle r="3200"/><circle r="4900"/><circle r="6600" class="pontilhado"/>
        </g>
        <path id="trilha-base"/>
        <path id="trilha-luz"/>
      </svg>

      <?php foreach ($palavras as [$txt, $x, $y, $r, $tam]): ?>
        <div class="palavra-gigante" style="transform: translate(<?= $x ?>px, <?= $y ?>px) translate(-50%, -50%) rotate(<?= $r ?>deg); font-size: <?= $tam ?>px"><?= e($txt) ?></div>
      <?php endforeach; ?>

      <?php foreach ($slides as $i => $s):
          [$x, $y, $r, $esc] = $s['pos'];
          $n = $i + 1; ?>
        <section class="quadro layout-<?= e($s['layout']) ?>"
                 id="q<?= $n ?>"
                 data-x="<?= $x ?>" data-y="<?= $y ?>" data-r="<?= $r ?>" data-s="<?= $esc ?>"
                 data-rotulo="<?= e($s['rotulo']) ?>"
                 aria-label="<?= e($n . '. ' . $s['rotulo']) ?>"
                 style="transform: translate(<?= $x ?>px, <?= $y ?>px) rotate(<?= $r ?>deg) scale(<?= $esc ?>) translate(-50%, -50%)">
          <div class="quadro-borda" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
          <div class="quadro-conteudo">
            <?= renderizar_quadro($s, $n, $meta) ?>
          </div>
          <template class="notas"><?= e($s['notas'] ?? '') ?></template>
        </section>
      <?php endforeach; ?>
    </div>
  </main>

  <!-- Efeitos de cinema -->
  <div class="vinheta" aria-hidden="true"></div>
  <div class="granulado" aria-hidden="true"></div>
  <div class="feixe" aria-hidden="true"></div>
  <div class="tarja tarja-topo" aria-hidden="true"></div>
  <div class="tarja tarja-base" aria-hidden="true"></div>

  <!-- Abertura -->
  <section id="abertura" aria-label="Abertura">
    <div class="ab-linha ab1">Universidade Católica de Brasília · Faculdade de Psicologia</div>
    <div class="ab-linha ab2">apresenta</div>
    <div class="ab-titulo">
      <span class="ab-nome">Hannah Arendt</span>
      <span class="ab-sub">e a responsabilidade pelo mundo comum</span>
    </div>
    <button id="btn-iniciar" type="button">
      <span class="play" aria-hidden="true"></span> Iniciar apresentação
    </button>
    <p class="ab-dica">Use os botões abaixo da tela · teclas ← → também funcionam</p>
  </section>

  <!-- Encerramento (sobre a visão geral do mapa) -->
  <section id="encerramento" aria-hidden="true">
    <p class="enc-eyebrow">Fim</p>
    <h2 class="enc-titulo">Obrigado!</h2>
    <p class="enc-pergunta">Que mundo estamos ajudando a construir?</p>
    <p class="enc-autores"><?= e($meta['autores']) ?></p>
  </section>

  <!-- Legenda do slide atual -->
  <div id="legenda" aria-hidden="true"><span id="leg-num">01</span><span id="leg-txt"></span></div>

  <!-- Painel de notas do apresentador -->
  <aside id="notas" aria-label="Notas do apresentador">
    <h4>Notas do apresentador</h4>
    <p id="notas-txt"></p>
  </aside>

  <!-- Navegação inferior -->
  <nav id="nav" aria-label="Navegação da apresentação">
    <div class="nav-progresso"><div id="barra"></div></div>
    <div class="nav-linha">
      <button class="nav-btn sec" id="btn-visao" type="button" title="Visão geral (O)">
        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        <span>Mapa</span>
      </button>

      <button class="nav-btn principal" id="btn-ant" type="button" title="Recuar (←)">
        <svg viewBox="0 0 24 24"><path d="M15 5 L8 12 L15 19"/></svg>
        <span>Recuar</span>
      </button>

      <div class="nav-centro">
        <div id="pontos" role="tablist" aria-label="Ir para o slide">
          <?php for ($k = 1; $k <= $total; $k++): ?>
            <button type="button" class="ponto" data-ir="<?= $k - 1 ?>" title="<?= e($k . '. ' . $slides[$k - 1]['rotulo']) ?>" aria-label="Slide <?= $k ?>"></button>
          <?php endfor; ?>
        </div>
        <div class="contador-nav"><b id="cont-atual">01</b> / <?= str_pad((string)$total, 2, '0', STR_PAD_LEFT) ?></div>
      </div>

      <button class="nav-btn principal" id="btn-prox" type="button" title="Avançar (→)">
        <span>Avançar</span>
        <svg viewBox="0 0 24 24"><path d="M9 5 L16 12 L9 19"/></svg>
      </button>

      <div class="nav-extra">
        <button class="nav-btn sec icone-so" id="btn-notas" type="button" title="Notas do apresentador (N)">
          <svg viewBox="0 0 24 24"><path d="M5 4 H15 L19 8 V20 H5 Z"/><path d="M8 11 H16 M8 15 H14"/></svg>
        </button>
        <button class="nav-btn sec icone-so" id="btn-tela" type="button" title="Tela cheia (F)">
          <svg viewBox="0 0 24 24"><path d="M4 9 V4 H9 M15 4 H20 V9 M20 15 V20 H15 M9 20 H4 V15"/></svg>
        </button>
      </div>
    </div>
  </nav>

  <script src="assets/js/prezi.js?v=<?= filemtime(__DIR__ . '/assets/js/prezi.js') ?>"></script>
</body>
</html>
