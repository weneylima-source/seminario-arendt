<?php
/**
 * Funções de renderização dos quadros da apresentação.
 * Cada layout devolve o HTML interno de um quadro de 1600 × 900 px.
 */

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

/** Ícone tingível (usa a imagem PNG como máscara CSS). */
function icone(string $nome, string $classe = ''): string
{
    $url = 'assets/img/icons/' . rawurlencode($nome) . '.png';
    return '<span class="ico ' . e($classe) . '" style="-webkit-mask-image:url(\'' . $url . '\');mask-image:url(\'' . $url . '\')" aria-hidden="true"></span>';
}

/** Cabeçalho padrão: rótulo + título. $html permite <em> no título. */
function cabecalho(array $s, int $n): string
{
    $num = str_pad((string)$n, 2, '0', STR_PAD_LEFT);
    return '<header class="cab">'
         . '<p class="eyebrow rv" style="--i:0"><span class="eyebrow-num">' . $num . '</span>' . e($s['eyebrow']) . '</p>'
         . '<h2 class="titulo split">' . $s['titulo'] . '</h2>'
         . '</header>';
}

function rodape(array $s, int $n): string
{
    $html = '';
    if (!empty($s['fonte'])) {
        $html .= '<p class="fonte rv" style="--i:12">' . e($s['fonte']) . '</p>';
    }
    $html .= '<span class="fantasma" aria-hidden="true">' . str_pad((string)$n, 2, '0', STR_PAD_LEFT) . '</span>';
    return $html;
}

function lista_icones(array $itens, int $inicio = 2, string $classe = 'lista'): string
{
    $html = '<ul class="' . $classe . '">';
    foreach ($itens as $k => [$ic, $txt]) {
        $html .= '<li class="rv" style="--i:' . ($inicio + $k) . '">' . icone($ic) . '<span>' . e($txt) . '</span></li>';
    }
    return $html . '</ul>';
}

/* ════════════════════════════════════════════════════════════════════════
   LAYOUTS
   ════════════════════════════════════════════════════════════════════════ */

function layout_titulo(array $s, int $n, array $meta): string
{
    return '
    <div class="titulo-wrap">
      <svg class="orbitas" viewBox="0 0 600 600" aria-hidden="true">
        <defs>
          <radialGradient id="gA" cx="50%" cy="50%" r="50%"><stop offset="0" stop-color="#e0a458" stop-opacity=".95"/><stop offset="1" stop-color="#e0a458" stop-opacity=".15"/></radialGradient>
          <radialGradient id="gB" cx="50%" cy="50%" r="50%"><stop offset="0" stop-color="#b83a55" stop-opacity=".9"/><stop offset="1" stop-color="#b83a55" stop-opacity=".1"/></radialGradient>
          <radialGradient id="gC" cx="50%" cy="50%" r="50%"><stop offset="0" stop-color="#f3ece2" stop-opacity=".85"/><stop offset="1" stop-color="#f3ece2" stop-opacity=".08"/></radialGradient>
        </defs>
        <g class="orb-rot">
          <circle class="orb o1" cx="250" cy="250" r="140" fill="url(#gB)"/>
          <circle class="orb o2" cx="350" cy="250" r="140" fill="url(#gA)"/>
          <circle class="orb o3" cx="300" cy="337" r="140" fill="url(#gC)"/>
        </g>
        <circle cx="300" cy="290" r="270" fill="none" stroke="#e0a458" stroke-opacity=".35" stroke-dasharray="2 10" class="anel-gira"/>
        <circle cx="300" cy="290" r="292" fill="none" stroke="#f3ece2" stroke-opacity=".12" class="anel-gira inv"/>
      </svg>
      <div class="titulo-txt">
        <p class="eyebrow rv" style="--i:0"><span class="eyebrow-num">01</span>' . e($s['eyebrow']) . '</p>
        <h1 class="titulo-mega split">' . e($meta['titulo']) . '</h1>
        <p class="subtitulo rv" style="--i:6">' . e($meta['subtitulo']) . '</p>
        <div class="linha-ouro rv" style="--i:7"></div>
        <p class="instituicao rv" style="--i:8">' . e($meta['instituicao']) . '</p>
        <p class="autores rv" style="--i:9">' . e($meta['autores']) . ' — ' . e($meta['data']) . '</p>
      </div>
    </div>';
}

function layout_problema(array $s, int $n): string
{
    return cabecalho($s, $n) . '
    <div class="grade-problema">
      ' . lista_icones($s['itens']) . '
      <div class="estatistica rv" style="--i:8">
        <div class="ondas" aria-hidden="true"><i></i><i></i><i></i></div>
        <div class="numero"><span class="contador" data-alvo="' . (int)$s['numero'] . '">0</span><small>%</small></div>
        <p>' . e($s['numero_legenda']) . '</p>
      </div>
    </div>' . rodape($s, $n);
}

function layout_linha_tempo(array $s, int $n): string
{
    $marcos = '';
    foreach ($s['marcos'] as $k => [$ano, $txt]) {
        $marcos .= '<li class="marco" style="--i:' . (2 + $k) . '"><b>' . e($ano) . '</b><span>' . e($txt) . '</span></li>';
    }
    return cabecalho($s, $n) . '
    <div class="linha-tempo">
      <div class="lt-trilho"><div class="lt-luz"></div></div>
      <ol>' . $marcos . '</ol>
    </div>
    ' . lista_icones($s['itens'], 7, 'lista duas-col') . rodape($s, $n);
}

function layout_triade(array $s, int $n): string
{
    $cards = '';
    foreach ($s['cards'] as $k => [$ic, $tit, $txt]) {
        $cards .= '<article class="card-triade rv" style="--i:' . (2 + $k * 2) . '; --h:' . (370 + $k * 55) . 'px">'
                . '<div class="card-ico">' . icone($ic) . '</div>'
                . '<h3>' . e($tit) . '</h3><p>' . e($txt) . '</p>'
                . '<span class="degrau">' . ($k + 1) . '</span></article>';
        if ($k < count($s['cards']) - 1) {
            $cards .= '<div class="seta rv" style="--i:' . (3 + $k * 2) . '"><svg viewBox="0 0 80 24"><path d="M0 12 H70 M60 2 L74 12 L60 22"/></svg></div>';
        }
    }
    return cabecalho($s, $n) . '<div class="triade">' . $cards . '</div>' . rodape($s, $n);
}

function layout_aneis(array $s, int $n): string
{
    $legendas = '';
    foreach ($s['itens'] as $k => [$ic, $tit, $txt]) {
        $legendas .= '<li class="rv anel-leg a' . $k . '" style="--i:' . (3 + $k * 2) . '">' . icone($ic)
                   . '<div><b>' . e($tit) . '</b><span>' . e($txt) . '</span></div></li>';
    }
    return cabecalho($s, $n) . '
    <div class="aneis-wrap">
      <div class="aneis" aria-hidden="true">
        <div class="anel r2 rv" style="--i:7"><span>Pertencer</span></div>
        <div class="anel r1 rv" style="--i:5"><span>Realizar-se</span></div>
        <div class="anel r0 rv" style="--i:3"><span>Sobreviver</span></div>
      </div>
      <ul class="aneis-legenda">' . $legendas . '</ul>
    </div>
    <blockquote class="pergunta rv" style="--i:10">' . e($s['pergunta']) . '</blockquote>' . rodape($s, $n);
}

function layout_citacao(array $s, int $n): string
{
    return cabecalho($s, $n) . '
    <div class="grade-citacao">
      <figure class="citacao rv" style="--i:2">
        ' . icone('aspas', 'aspas-ico') . '
        <blockquote class="split-lento">' . e($s['citacao']) . '</blockquote>
        <figcaption>' . e($s['citacao_legenda']) . '</figcaption>
        <div class="risco"></div>
      </figure>
      ' . lista_icones($s['itens'], 5) . '
    </div>' . rodape($s, $n);
}

function layout_balanca(array $s, int $n): string
{
    $itens = '';
    foreach ($s['itens'] as $k => [$ic, $txt]) {
        $itens .= '<li class="rv b' . $k . '" style="--i:' . (3 + $k) . '">' . icone($ic) . '<span>' . e($txt) . '</span></li>';
    }
    return cabecalho($s, $n) . '
    <div class="balanca-wrap">
      <svg class="balanca-svg rv" style="--i:2" viewBox="0 0 400 320" aria-hidden="true">
        <line x1="200" y1="40" x2="200" y2="290" class="b-haste"/>
        <path d="M140 300 H260" class="b-haste"/>
        <circle cx="200" cy="40" r="10" class="b-pino"/>
        <g class="b-braco">
          <line x1="60" y1="70" x2="340" y2="70" class="b-haste"/>
          <g class="b-prato esq"><path d="M60 70 L20 170 M60 70 L100 170"/><path d="M10 170 Q60 210 110 170 Z" class="b-cuia"/></g>
          <g class="b-prato dir"><path d="M340 70 L300 170 M340 70 L380 170"/><path d="M290 170 Q340 210 390 170 Z" class="b-cuia"/></g>
        </g>
      </svg>
      <ul class="balanca-itens">' . $itens . '</ul>
    </div>' . rodape($s, $n);
}

function visual_multidao(): string
{
    // Formas diferentes, cores diferentes — iguais em humanidade, nunca idênticos.
    $html = '<div class="multidao" aria-hidden="true">';
    $formas = ['circ', 'quadrado', 'tri', 'circ', 'losango', 'circ', 'quadrado'];
    for ($i = 0; $i < 42; $i++) {
        $f = $formas[($i * 5 + intdiv($i, 3)) % count($formas)];
        $h = (($i * 47) % 70) - 10;
        $html .= '<i class="p ' . $f . '" style="--k:' . $i . '; --hue:' . $h . '"></i>';
    }
    return $html . '</div>';
}

function visual_broto(): string
{
    return '<svg class="broto-svg" viewBox="0 0 300 380" aria-hidden="true">
      <path class="b-solo" d="M20 340 Q150 320 280 340"/>
      <path class="b-caule" d="M150 340 C150 280 140 230 150 160"/>
      <path class="b-folha f1" d="M150 220 C110 210 80 180 78 140 C118 145 145 175 150 220Z"/>
      <path class="b-folha f2" d="M150 175 C190 165 225 130 228 85 C185 92 155 125 150 175Z"/>
      <circle class="b-semente" cx="150" cy="150" r="6"/>
      <g class="b-raios"><line x1="150" y1="60" x2="150" y2="20"/><line x1="90" y1="80" x2="65" y2="50"/><line x1="210" y1="80" x2="235" y2="50"/></g>
    </svg>';
}

function layout_destaque(array $s, int $n): string
{
    $visual = $s['visual'] === 'multidao' ? visual_multidao() : visual_broto();
    return cabecalho($s, $n) . '
    <div class="grade-destaque v-' . e($s['visual']) . '">
      <div class="destaque rv" style="--i:2">
        ' . $visual . '
        <p class="destaque-frase">' . e($s['destaque']) . '</p>
        <p class="destaque-leg">' . e($s['destaque_legenda']) . '</p>
      </div>
      ' . lista_icones($s['itens'], 5) . '
    </div>' . rodape($s, $n);
}

function layout_dupla(array $s, int $n): string
{
    $html = '';
    foreach ($s['paineis'] as $k => [$ic, $tit, $linhas, $tom]) {
        $li = '';
        foreach ($linhas as $j => $l) {
            $li .= '<li class="rv" style="--i:' . (4 + $k * 3 + $j) . '">' . e($l) . '</li>';
        }
        $html .= '<article class="painel ' . e($tom) . ' rv" style="--i:' . (2 + $k * 3) . '">'
               . '<div class="painel-ico">' . icone($ic) . '</div>'
               . '<h3>' . e($tit) . '</h3><ul>' . $li . '</ul></article>';
        if ($k === 0) {
            $html .= '<div class="versus rv" style="--i:4"><span>×</span></div>';
        }
    }
    return cabecalho($s, $n) . '<div class="dupla">' . $html . '</div>' . rodape($s, $n);
}

function layout_fluxo(array $s, int $n): string
{
    $html = '';
    foreach ($s['etapas'] as $k => [$ic, $txt]) {
        $html .= '<li class="etapa" style="--i:' . (2 + $k * 2) . '">'
               . '<div class="etapa-num">' . ($k + 1) . '</div>'
               . '<div class="etapa-ico">' . icone($ic) . '</div>'
               . '<p>' . e($txt) . '</p></li>';
    }
    return cabecalho($s, $n) . '
    <div class="fluxo">
      <svg class="fluxo-linha" viewBox="0 0 1400 40" preserveAspectRatio="none" aria-hidden="true"><path d="M20 20 H1380"/></svg>
      <ol>' . $html . '</ol>
    </div>
    <p class="fluxo-alerta rv" style="--i:11">Desinformação não é apenas erro de informação: organiza emoções, inimigos e silêncios.</p>'
    . rodape($s, $n);
}

function layout_quadrantes(array $s, int $n): string
{
    $html = '';
    foreach ($s['cards'] as $k => [$ic, $tit, $txt, $tom]) {
        $html .= '<article class="quad ' . e($tom) . ' rv" style="--i:' . (2 + $k * 2) . '">'
               . icone($ic) . '<div><h3>' . e($tit) . '</h3><p>' . e($txt) . '</p></div></article>';
    }
    return cabecalho($s, $n) . '<div class="quadrantes">' . $html . '</div>' . rodape($s, $n);
}

function layout_checklist(array $s, int $n): string
{
    $html = '';
    foreach ($s['itens'] as $k => [$ic, $txt]) {
        $html .= '<li class="chk rv" style="--i:' . (2 + $k) . '">'
               . '<span class="chk-box"><svg viewBox="0 0 24 24"><path d="M5 12.5 L10 17 L19 7"/></svg></span>'
               . icone($ic) . '<span class="chk-txt">' . e($txt) . '</span></li>';
    }
    return cabecalho($s, $n) . '<ul class="checklist">' . $html . '</ul>'
         . '<p class="lema rv" style="--i:10">A responsabilidade não exige heroísmo diário; exige não se tornar cúmplice do silêncio.</p>'
         . rodape($s, $n);
}

function layout_conclusao(array $s, int $n): string
{
    $html = '';
    foreach ($s['itens'] as $k => $txt) {
        $html .= '<li class="rv" style="--i:' . (2 + $k) . '"><span class="estrela-ponto"></span>' . e($txt) . '</li>';
    }
    return cabecalho($s, $n) . '
    <div class="grade-conclusao">
      <ol class="conclusao-lista">' . $html . '</ol>
      <div class="pergunta-final rv" style="--i:8">
        <div class="pf-halo" aria-hidden="true"></div>
        <p class="maquina" data-texto="' . e($s['pergunta']) . '"></p>
      </div>
    </div>' . rodape($s, $n);
}

function layout_referencias(array $s, int $n): string
{
    $html = '';
    $i = 2;
    foreach ($s['colunas'] as $tit => $refs) {
        $li = '';
        foreach ($refs as $r) {
            $li .= '<li>' . $r . '</li>';
        }
        $html .= '<section class="ref-col rv" style="--i:' . $i++ . '"><h3>' . e($tit) . '</h3><ul>' . $li . '</ul></section>';
    }
    return cabecalho($s, $n) . '<div class="referencias">' . $html . '</div>' . rodape($s, $n);
}

/** Despacha para o layout correto. */
function renderizar_quadro(array $s, int $n, array $meta): string
{
    $fn = 'layout_' . $s['layout'];
    if (!function_exists($fn)) {
        return '<p>Layout desconhecido: ' . e($s['layout']) . '</p>';
    }
    return $s['layout'] === 'titulo' ? $fn($s, $n, $meta) : $fn($s, $n);
}
