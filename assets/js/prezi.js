/* ════════════════════════════════════════════════════════════════════════
   Motor de câmera estilo Prezi + efeitos cinematográficos
   ════════════════════════════════════════════════════════════════════════ */
(() => {
  'use strict';

  const $ = (s, c = document) => c.querySelector(s);
  const $$ = (s, c = document) => [...c.querySelectorAll(s)];
  const body = document.body;
  const mundo = $('#mundo');
  const quadros = $$('.quadro');
  const TOTAL = quadros.length;
  const FW = 1600, FH = 900;

  const dados = quadros.map(q => ({
    el: q,
    x: +q.dataset.x, y: +q.dataset.y, r: +q.dataset.r, s: +q.dataset.s,
    rotulo: q.dataset.rotulo,
    notas: ($('template.notas', q)?.innerHTML || '').trim()
  }));

  /* ── Divide títulos em palavras para a revelação ─────────────────────── */
  function dividir(el) {
    let k = 0;
    const andar = no => {
      [...no.childNodes].forEach(filho => {
        if (filho.nodeType === 3) {
          const frag = document.createDocumentFragment();
          filho.textContent.split(/(\s+)/).forEach(parte => {
            if (!parte) return;
            if (/^\s+$/.test(parte)) { frag.appendChild(document.createTextNode(' ')); return; }
            const w = document.createElement('span'); w.className = 'w';
            const i = document.createElement('i'); i.textContent = parte; i.style.setProperty('--w', k++);
            w.appendChild(i); frag.appendChild(w);
          });
          no.replaceChild(frag, filho);
        } else if (filho.nodeType === 1) andar(filho);
      });
    };
    andar(el);
  }
  $$('.split').forEach(dividir);

  /* ── Trilha que liga os quadros (curva suave) ────────────────────────── */
  const trilhaBase = $('#trilha-base');
  const trilhaLuz = $('#trilha-luz');
  function caminho(pts) {
    if (pts.length < 2) return `M${pts[0].x} ${pts[0].y}`;
    let d = `M${pts[0].x} ${pts[0].y}`;
    for (let i = 0; i < pts.length - 1; i++) {
      const p0 = pts[i - 1] || pts[i], p1 = pts[i], p2 = pts[i + 1], p3 = pts[i + 2] || p2;
      const c1 = { x: p1.x + (p2.x - p0.x) / 6, y: p1.y + (p2.y - p0.y) / 6 };
      const c2 = { x: p2.x - (p3.x - p1.x) / 6, y: p2.y - (p3.y - p1.y) / 6 };
      d += ` C${c1.x} ${c1.y} ${c2.x} ${c2.y} ${p2.x} ${p2.y}`;
    }
    return d;
  }
  trilhaBase.setAttribute('d', caminho(dados));
  trilhaLuz.setAttribute('d', caminho(dados));
  const compTotal = trilhaLuz.getTotalLength();
  const medidor = document.createElementNS('http://www.w3.org/2000/svg', 'path');
  const compAte = dados.map((_, i) => { medidor.setAttribute('d', caminho(dados.slice(0, i + 1))); return i ? medidor.getTotalLength() : 0; });
  trilhaLuz.style.strokeDasharray = compTotal;
  trilhaLuz.style.strokeDashoffset = compTotal;

  /* ── Câmera ──────────────────────────────────────────────────────────── */
  const cam = { x: 0, y: 0, z: 0.05, r: 0 };
  const navH = () => $('#nav').offsetHeight || 110;

  function area() {
    const W = innerWidth, H = innerHeight;
    const topo = 20, baixo = navH();
    return { W, H, cx: W / 2, cy: topo + (H - topo - baixo) / 2, aw: W, ah: H - topo - baixo };
  }

  function visaoQuadro(d) {
    const a = area();
    const z = Math.min((a.aw * 0.92) / FW, (a.ah * 0.94) / FH) / d.s;
    return { x: d.x, y: d.y, z, r: d.r };
  }

  function visaoGeral() {
    let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;
    dados.forEach(d => {
      const w = FW * d.s / 2, h = FH * d.s / 2;
      minX = Math.min(minX, d.x - w); maxX = Math.max(maxX, d.x + w);
      minY = Math.min(minY, d.y - h); maxY = Math.max(maxY, d.y + h);
    });
    const a = area();
    const z = Math.min(a.aw / (maxX - minX), a.ah / (maxY - minY)) * 0.9;
    return { x: (minX + maxX) / 2, y: (minY + maxY) / 2, z, r: 0 };
  }

  function aplicar() {
    const a = area();
    mundo.style.transform =
      `translate(${a.cx}px, ${a.cy}px) scale(${cam.z}) rotate(${-cam.r}deg) translate(${-cam.x}px, ${-cam.y}px)`;
  }

  const suave = t => t < .5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
  const suave5 = t => t < .5 ? 16 * Math.pow(t, 5) : 1 - Math.pow(-2 * t + 2, 5) / 2;

  let animId = null;
  function voar(alvo, aoChegar) {
    cancelAnimationFrame(animId);
    const de = { ...cam };
    const dx = alvo.x - de.x, dy = alvo.y - de.y;
    let dr = alvo.r - de.r; dr = ((dr + 540) % 360) - 180;
    const a = area();
    const zMeio = Math.min(a.aw / (Math.abs(dx) + FW * 1.3), a.ah / (Math.abs(dy) + FH * 1.3));
    const l0 = Math.log(de.z), l1 = Math.log(alvo.z);
    const salto = Math.max(0, (l0 + l1) / 2 - Math.log(zMeio));
    const dur = 1500 + Math.min(900, salto * 420);
    const t0 = performance.now();

    body.classList.add('viajando');
    body.classList.remove('chegou');
    mundo.classList.add('movendo');

    const passo = agora => {
      const t = Math.min(1, (agora - t0) / dur);
      const e = suave(t), ep = salto > .2 ? suave5(t) : e;
      cam.x = de.x + dx * ep;
      cam.y = de.y + dy * ep;
      cam.r = de.r + dr * e;
      cam.z = Math.exp(l0 + (l1 - l0) * e - salto * Math.sin(Math.PI * t));
      aplicar();
      if (t < 1) animId = requestAnimationFrame(passo);
      else {
        cam.r = alvo.r;
        body.classList.remove('viajando');
        mundo.classList.remove('movendo');   // re-rasteriza o texto nítido
        void body.offsetWidth;
        body.classList.add('chegou');
        aoChegar && aoChegar();
      }
    };
    animId = requestAnimationFrame(passo);
  }

  /* ── Estado / navegação ──────────────────────────────────────────────── */
  let atual = -1;          // -1 = visão geral; TOTAL = encerramento
  let modo = 'intro';
  const btnAnt = $('#btn-ant'), btnProx = $('#btn-prox'), btnVisao = $('#btn-visao');
  const pontos = $$('.ponto');
  const vistos = new Set();

  function atualizarUI() {
    const i = atual;
    btnAnt.disabled = i <= 0 && !body.classList.contains('modo-visao');
    btnProx.disabled = i >= TOTAL;
    pontos.forEach((p, k) => {
      p.classList.toggle('atual', k === i);
      p.classList.toggle('visto', vistos.has(k));
    });
    const n = i >= TOTAL ? 'FIM' : String(Math.max(1, i + 1)).padStart(2, '0');
    $('#cont-atual').textContent = n;
    $('#leg-num').textContent = i >= TOTAL ? '—' : (i < 0 ? '◎' : n);
    $('#leg-txt').textContent = i >= TOTAL ? 'Encerramento' : (i < 0 ? 'Visão geral' : dados[i].rotulo);
    $('#notas-txt').innerHTML = i >= 0 && i < TOTAL ? dados[i].notas : 'Sem notas nesta etapa.';
    $('#barra').style.width = (i >= TOTAL ? 100 : Math.max(0, (i + 1) / TOTAL * 100)) + '%';
    btnVisao.classList.toggle('ligado', body.classList.contains('modo-visao'));
    const luz = i < 0 ? compAte[TOTAL - 1] * (vistos.size ? 1 : 0) : compAte[Math.min(i, TOTAL - 1)];
    trilhaLuz.style.strokeDashoffset = compTotal - (i >= TOTAL ? compTotal : luz);
    if (i >= 0 && i < TOTAL) history.replaceState(null, '', '#' + (i + 1));
  }

  function ir(i) {
    if (modo === 'intro') return;
    i = Math.max(0, Math.min(TOTAL, i));
    const anterior = quadros[atual];
    body.classList.remove('modo-visao', 'fim');
    anterior && anterior.classList.remove('ativo');
    quadros.forEach(q => q.classList.remove('preparar'));
    atual = i;

    if (i === TOTAL) {            // encerramento: recua para o mapa inteiro
      body.classList.add('fim');
      atualizarUI();
      voar(visaoGeral());
      return;
    }

    const q = quadros[i];
    q.classList.add('preparar', 'ativo');
    pararEfeitos(q);
    vistos.add(i);
    atualizarUI();
    voar(visaoQuadro(dados[i]), () => {
      if (atual !== i) return;
      q.classList.remove('preparar');
      iniciarEfeitos(q);
    });
  }

  function visao() {
    if (modo === 'intro') return;
    if (body.classList.contains('modo-visao')) { ir(Math.max(0, atual)); return; }
    quadros.forEach(q => q.classList.remove('ativo', 'preparar'));
    body.classList.remove('fim');
    body.classList.add('modo-visao');
    atualizarUI();
    voar(visaoGeral());
  }

  const proximo = () => body.classList.contains('modo-visao') ? ir(Math.max(0, atual)) : ir(atual + 1);
  const anterior = () => body.classList.contains('modo-visao') ? ir(Math.max(0, atual)) : ir(atual - 1);

  btnProx.addEventListener('click', proximo);
  btnAnt.addEventListener('click', anterior);
  btnVisao.addEventListener('click', visao);
  pontos.forEach(p => p.addEventListener('click', () => ir(+p.dataset.ir)));
  quadros.forEach((q, k) => q.addEventListener('click', () => { if (body.classList.contains('modo-visao') || body.classList.contains('fim')) ir(k); }));

  $('#btn-notas').addEventListener('click', e => {
    body.classList.toggle('notas-abertas');
    e.currentTarget.classList.toggle('ligado', body.classList.contains('notas-abertas'));
  });
  const telaCheia = () => {
    if (!document.fullscreenElement) document.documentElement.requestFullscreen?.().catch(() => {});
    else document.exitFullscreen?.();
  };
  $('#btn-tela').addEventListener('click', telaCheia);

  addEventListener('keydown', e => {
    if (e.target.closest('input, textarea')) return;
    if (modo === 'intro') {
      if (['Enter', ' ', 'ArrowRight'].includes(e.key)) { e.preventDefault(); iniciar(); }
      return;
    }
    switch (e.key) {
      case 'ArrowRight': case 'PageDown': case ' ': e.preventDefault(); proximo(); break;
      case 'ArrowLeft': case 'PageUp': e.preventDefault(); anterior(); break;
      case 'Home': ir(0); break;
      case 'End': ir(TOTAL - 1); break;
      case 'o': case 'O': case 'Escape': visao(); break;
      case 'n': case 'N': $('#btn-notas').click(); break;
      case 'f': case 'F': telaCheia(); break;
    }
  });

  // Gesto de deslizar no celular/tablet
  let toqueX = null;
  addEventListener('touchstart', e => { toqueX = e.touches[0].clientX; }, { passive: true });
  addEventListener('touchend', e => {
    if (toqueX === null || modo === 'intro') return;
    const d = e.changedTouches[0].clientX - toqueX;
    if (Math.abs(d) > 60) (d < 0 ? proximo : anterior)();
    toqueX = null;
  });

  addEventListener('resize', () => {
    cancelAnimationFrame(animId);
    const alvo = body.classList.contains('modo-visao') || body.classList.contains('fim') || atual < 0
      ? visaoGeral() : visaoQuadro(dados[atual]);
    Object.assign(cam, alvo); aplicar();
    body.classList.remove('viajando'); mundo.classList.remove('movendo');
    quadros.forEach(q => { if (q.classList.contains('preparar')) { q.classList.remove('preparar'); iniciarEfeitos(q); } });
    ajustarCanvas();
  });

  /* ── Efeitos específicos ao chegar ───────────────────────────────────── */
  const timers = new WeakMap();
  function pararEfeitos(q) {
    (timers.get(q) || []).forEach(t => { clearTimeout(t); clearInterval(t); cancelAnimationFrame(t); });
    timers.set(q, []);
    $$('.contador', q).forEach(c => c.textContent = '0');
    $$('.maquina', q).forEach(m => m.textContent = '');
  }
  function iniciarEfeitos(q) {
    const lista = timers.get(q) || [];
    $$('.contador', q).forEach(c => {
      const alvo = +c.dataset.alvo;
      lista.push(setTimeout(() => {
        const t0 = performance.now();
        const tick = agora => {
          const t = Math.min(1, (agora - t0) / 1800);
          c.textContent = Math.round(alvo * (1 - Math.pow(1 - t, 4)));
          if (t < 1) lista.push(requestAnimationFrame(tick));
        };
        lista.push(requestAnimationFrame(tick));
      }, 1300));
    });
    $$('.maquina', q).forEach(m => {
      const txt = m.dataset.texto; let k = 0;
      lista.push(setTimeout(() => {
        const id = setInterval(() => {
          m.textContent = txt.slice(0, ++k);
          if (k >= txt.length) clearInterval(id);
        }, 55);
        lista.push(id);
      }, 1500));
    });
    timers.set(q, lista);
  }
  // Na visão geral, os contadores e textos devem aparecer completos
  $$('.contador').forEach(c => c.textContent = c.dataset.alvo);
  $$('.maquina').forEach(m => m.textContent = m.dataset.texto);

  /* ── Campo de estrelas com paralaxe e efeito de dobra ────────────────── */
  const cv = $('#estrelas'), cx = cv.getContext('2d');
  let W = 0, H = 0, DPR = 1;
  const estrelas = [];
  function ajustarCanvas() {
    DPR = Math.min(2, devicePixelRatio || 1);
    W = innerWidth; H = innerHeight;
    cv.width = W * DPR; cv.height = H * DPR;
    cx.setTransform(DPR, 0, 0, DPR, 0, 0);
  }
  ajustarCanvas();
  for (let i = 0; i < 420; i++) {
    estrelas.push({
      u: Math.random(), v: Math.random(),
      d: Math.pow(Math.random(), 2) * .9 + .1,
      tw: Math.random() * Math.PI * 2,
      cor: Math.random() < .12 ? '246,207,143' : (Math.random() < .08 ? '230,120,150' : '243,236,226'),
      px: null, py: null
    });
  }
  const zRef = 0.3;
  function desenhar(agora) {
    cx.clearRect(0, 0, W, H);
    const T = Math.max(W, H) * 2.2;
    const giro = -cam.r * Math.PI / 180;
    const cs = Math.cos(giro), sn = Math.sin(giro);
    const viajando = body.classList.contains('viajando');
    for (const s of estrelas) {
      let x = (s.u * T - cam.x * s.d * 0.12) % T; if (x < 0) x += T; x -= T / 2;
      let y = (s.v * T - cam.y * s.d * 0.12) % T; if (y < 0) y += T; y -= T / 2;
      const m = Math.min(3, Math.max(.45, Math.pow(cam.z / zRef, s.d * .55)));
      x *= m; y *= m;
      const sx = W / 2 + x * cs - y * sn * s.d;
      const sy = H / 2 + x * sn * s.d + y * cs;
      const brilho = .35 + .65 * Math.abs(Math.sin(s.tw + agora * .0012 * s.d));
      const a = (.25 + s.d * .75) * brilho;
      const raio = .5 + s.d * 1.6;
      if (viajando && s.px !== null) {
        const ddx = sx - s.px, ddy = sy - s.py, dist = Math.hypot(ddx, ddy);
        if (dist > 1.5 && dist < 260) {
          cx.strokeStyle = `rgba(${s.cor},${Math.min(1, a * 1.2)})`;
          cx.lineWidth = raio * 1.3; cx.lineCap = 'round';
          cx.beginPath(); cx.moveTo(s.px - ddx * 2.5, s.py - ddy * 2.5); cx.lineTo(sx, sy); cx.stroke();
          s.px = sx; s.py = sy; continue;
        }
      }
      cx.fillStyle = `rgba(${s.cor},${a})`;
      cx.beginPath(); cx.arc(sx, sy, raio, 0, Math.PI * 2); cx.fill();
      s.px = sx; s.py = sy;
    }
    requestAnimationFrame(desenhar);
  }
  requestAnimationFrame(desenhar);

  /* ── Abertura ────────────────────────────────────────────────────────── */
  const inicial = Math.max(0, Math.min(TOTAL - 1, (parseInt(location.hash.slice(1), 10) || 1) - 1));
  Object.assign(cam, visaoGeral());
  cam.z *= 0.35;            // começa ainda mais longe, para o mergulho inicial
  aplicar();
  atualizarUI();

  function iniciar() {
    if (modo !== 'intro') return;
    modo = 'apresentando';
    if (matchMedia('(pointer: fine)').matches) telaCheia();
    body.classList.remove('intro-ativa');
    body.classList.add('pronto');
    // 1º plano: aproxima até o mapa inteiro; 2º: mergulha no primeiro quadro
    setTimeout(() => {
      body.classList.add('modo-visao');
      voar(visaoGeral(), () => setTimeout(() => ir(inicial), 700));
    }, 300);
  }
  $('#btn-iniciar').addEventListener('click', iniciar);
})();
