/**
 * ArenaSport — Interactive Isometric Sport Animations
 * Pure SVG + dynamic keyframe generator for sports selection
 */

(function () {
  'use strict';

  const INK = '#10243A';
  const SC = t => 1 / (1 + 1.5 * t);
  const P = (u, t) => {
    const k = SC(t);
    return [150 + u * 135 * k, -26.7 + 191.7 * k];
  };
  const f1 = n => n.toFixed(1);
  const pts = a => a.map(([u, t]) => P(u, t).map(f1).join(',')).join(' ');
  const ln = (a, w = 1.2) =>
    `<polyline points="${pts(a)}" fill="none" stroke="#fff" stroke-width="${w}" stroke-linejoin="round" opacity=".9"/>`;
  const circ = (cu, ct, a, rt, d0 = 0, d1 = 360) => {
    const r = [];
    for (let d = d0; d <= d1; d += 10) {
      const q = (d * Math.PI) / 180;
      const t = ct + a * rt * Math.sin(q);
      if (t >= 0 && t <= 1) r.push([cu + a * Math.cos(q), t]);
    }
    return r;
  };
  const BOX = [[-1, 0], [-1, 1], [1, 1], [1, 0], [-1, 0]];
  const mesh = (x1, x2, top, h, gap = 4) => {
    let m = '';
    for (let x = x1 + gap; x < x2; x += gap) m += `M${f1(x)} ${f1(top)}v${f1(h)}`;
    for (let y = gap; y < h; y += gap) m += `M${f1(x1)} ${f1(top + y)}H${f1(x2)}`;
    return `<path d="${m}" stroke="rgba(255,255,255,.35)" stroke-width=".5" fill="none"/>`;
  };

  const an = (n, x = '') => `class="anim" style="animation-name:${n};${x}"`;
  const HALF = 'animation-delay:calc(var(--d,2.4s) / -2)';
  const QTR = 'animation-delay:calc(var(--d,2.4s) / -4)';

  function lines(s) {
    const i = s.id;
    let g = ln(BOX, 1.6);
    if (i === 'tenis') {
      g += ln([[-0.75, 0], [-0.75, 1]]) +
        ln([[0.75, 0], [0.75, 1]]) +
        ln([[-0.75, 0.27], [0.75, 0.27]]) +
        ln([[-0.75, 0.73], [0.75, 0.73]]) +
        ln([[0, 0.27], [0, 0.73]]);
    } else if (i === 'padel') {
      g += ln([[-1, 0.15], [1, 0.15]]) +
        ln([[-1, 0.85], [1, 0.85]]) +
        ln([[0, 0.15], [0, 0.85]]);
    } else if (i === 'badminton') {
      g += ln([[-0.85, 0], [-0.85, 1]]) +
        ln([[0.85, 0], [0.85, 1]]) +
        ln([[-1, 0.35], [1, 0.35]]) +
        ln([[-1, 0.65], [1, 0.65]]) +
        ln([[0, 0], [0, 0.35]]) +
        ln([[0, 0.65], [0, 1]]);
    } else if (i === 'voli') {
      g += ln([[-1, 0.333], [1, 0.333]]) + ln([[-1, 0.667], [1, 0.667]]);
    } else if (s.m === 'goal') {
      g += ln([[-1, 0.5], [1, 0.5]]) +
        ln(circ(0, 0.5, 0.28, 0.25)) +
        ln([[-s.box, 1], [-s.box, s.by], [s.box, s.by], [s.box, 1]]) +
        ln([[-s.box, 0], [-s.box, 1 - s.by], [s.box, 1 - s.by], [s.box, 0]]);
    }
    return g;
  }

  function person(o) {
    const k = SC(o.t);
    const [x, y] = P(o.u || 0, o.t);
    const sk = '#F0C09B';
    const D = o.d || '';
    const ST = `fill="none" stroke="${sk}" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"`;
    let arms = '';
    if (o.arms) {
      arms = `<g class="anim" style="transform-origin:0px -56px;animation-name:${o.arms[1]};${D}"><path d="${o.arms[0]}" ${ST}/></g>`;
    }
    if (o.rk) {
      const [rx, ry, f] = o.rk;
      const cy = -48 - ry;
      arms = `<path d="M-7 -56L-12 -47L-9 -39" ${ST}/><g class="anim" style="transform-origin:7px -56px;animation-name:arm;${D}"><path d="M7 -56L12 -47L15 -42" ${ST}/><path d="M15.5 -42L17.5 -48" stroke="${INK}" stroke-width="2"/><ellipse cx="19" cy="${cy}" rx="${rx}" ry="${ry}" transform="rotate(14 19 ${cy})" fill="${f ? INK : 'rgba(255,255,255,.2)'}" stroke="${INK}" stroke-width="1.8"/></g>`;
    }
    const head = o.front
      ? `<circle cy="-66" r="5.4" fill="${sk}"/><path d="M-5.9 -66a5.9 5.9 0 0 1 11.8 0Q0 -69.5 -5.9 -66Z" fill="${o.hair}"/>`
      : `<circle cy="-66" r="5.8" fill="${o.hair}"/>`;
    const lk = o.kick ? an('legk', 'transform-origin:3px -29px') : '';
    const lw = `stroke="${sk}" stroke-width="4.4" fill="none" stroke-linecap="round" stroke-linejoin="round"`;
    return `<g ${o.lat ? an(o.lat) : ''}><g transform="translate(${f1(x)} ${f1(y)}) scale(${o.flip ? -k : k} ${k})"><ellipse rx="14" ry="3" fill="rgba(0,0,0,.25)"/><g ${an(o.body || 'bob', D)}>
<path d="M-3 -29L-10 -15L-11 -2" ${lw}/><ellipse cx="-11" cy="-1" rx="4.4" ry="2.2" fill="#fff"/>
<g ${lk}><path d="M3 -29L10 -15L11 -2" ${lw}/><ellipse cx="11" cy="-1" rx="4.4" ry="2.2" fill="#fff"/></g>
<path d="M-7 -38L7 -38L9 -26L1 -28L-1 -28L-9 -26Z" fill="${o.shorts}"/>
<path d="M-7.5 -58Q0 -62 7.5 -58L6.5 -37L-6.5 -37Z" fill="${o.shirt}" stroke="rgba(16,36,58,.4)" stroke-width=".7"/>${arms}${head}</g></g></g>`;
  }

  const wall = a =>
    `<polygon points="${a
      .map(([u, t, h]) => {
        const [x, y] = P(u, t);
        return f1(x) + ',' + f1(y - h * SC(t));
      })
      .join(' ')}" fill="rgba(255,255,255,.13)" stroke="rgba(255,255,255,.5)" stroke-width=".6"/>`;

  const NEAR = { shirt: '#F4F7FA', shorts: '#10243A', hair: '#3A2418' };
  const FAR = { shirt: '#FFD23F', shorts: '#10243A', hair: '#2A1A12', front: 1 };

  function generateArt(s) {
    const id = s.id;
    const R = s.R || 3;
    let css = '';
    const kf = (n, fn, N, mk) => {
      let o = `@keyframes ${n}{`;
      for (let i = 0; i <= N; i++) {
        const t = i / N;
        o += `${(t * 100).toFixed(2)}%{${mk(fn(t))}}`;
      }
      css += o + '}';
    };
    const bmk = p => {
      const [x, y] = P(p.u, p.t);
      const k = SC(p.t);
      return `translate:${f1(x)}px ${f1(y - (p.h + R) * k)}px;scale:${(k * R).toFixed(3)};opacity:${p.a ?? 1}`;
    };
    const smk = p => {
      const [x, y] = P(p.u, p.t);
      const k = SC(p.t);
      return `translate:${f1(x)}px ${f1(y)}px;scale:${(k * R).toFixed(3)};opacity:${(((p.a ?? 1) * 0.4) / (1 + p.h / 45)).toFixed(2)}`;
    };

    let g = `<defs><linearGradient id="g-${id}" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#000" stop-opacity=".25"/><stop offset="1" stop-color="#000" stop-opacity="0"/></linearGradient></defs><rect width="300" height="180" fill="${s.o}"/><rect width="300" height="42" fill="#0E1B2C"/><rect y="37" width="300" height="8" fill="var(--sport-primary, #f97316)"/>`;
    g += [30, 105, 180, 255]
      .map(
        x =>
          `<text x="${x}" y="43" font-size="6" font-weight="800" fill="#fff" text-anchor="middle" letter-spacing=".8">ARENASPORT</text>`
      )
      .join('');
    g += `<polygon points="${pts([[-1.25, -0.12], [1.25, -0.12], [1.25, 1.06], [-1.25, 1.06]])}" fill="${s.o}"/><polygon points="${pts(BOX)}" fill="${s.c}"/><polygon points="${pts(BOX)}" fill="url(#g-${id})"/>` +
      lines(s);

    let fn,
      front = '',
      back = '',
      ball = '',
      pop = '',
      dur = '2.4s';

    if (s.m === 'net') {
      const T1 = 0.38;
      fn = τ => {
        const ret = τ >= 0.5;
        const x = ret ? τ - 0.5 : τ;
        let t, h;
        if (s.bz) {
          if (x < T1) {
            const q = x / T1;
            t = 0.1 + 0.62 * q;
            h = s.hit * (1 - q) + 4 * s.A * q * (1 - q);
          } else {
            const q = (x - T1) / (0.5 - T1);
            t = 0.72 + 0.18 * q;
            h = s.hit * q + 48 * q * (1 - q);
          }
        } else {
          const q = x / 0.5;
          t = 0.1 + 0.8 * q;
          h = s.hit + 4 * s.A * q * (1 - q);
        }
        return { u: 0.3 * Math.cos(2 * Math.PI * τ), t: ret ? 1 - t : t, h };
      };
      kf(id + 'n', τ => 0.3 * Math.cos(2 * Math.PI * τ) - 0.13, 24, u => `translate:${f1(P(u, 0.04)[0] - 150)}px 0`);
      kf(id + 'f', τ => 0.3 * Math.cos(2 * Math.PI * τ) + 0.14, 24, u => `translate:${f1(P(u, 0.96)[0] - 150)}px 0`);
      const tool = s.hands
        ? { arms: ['M-6 -56L-5 -47L-1 -41M6 -56L5 -47L1 -41', 'push'] }
        : { rk: s.rk };
      if (s.walls) {
        g +=
          wall([[-1, 0, 0], [-1, 1, 0], [-1, 1, 120], [-1, 0, 120]]) +
          wall([[1, 0, 0], [1, 1, 0], [1, 1, 120], [1, 0, 120]]) +
          wall([[-1, 1, 0], [1, 1, 0], [1, 1, 120], [-1, 1, 120]]);
      }
      const [nb, nt] = s.net;
      const k = SC(0.5);
      const [x1, gy] = P(-1.08, 0.5);
      const [x2] = P(1.08, 0.5);
      const top = gy - nt * k;
      const h = (nt - nb) * k;
      const net = `<rect x="${f1(x1)}" y="${f1(top)}" width="${f1(x2 - x1)}" height="${f1(h)}" fill="rgba(255,255,255,.2)"/>${mesh(x1, x2, top, h, 3.5)}<rect x="${f1(x1)}" y="${f1(top)}" width="${f1(x2 - x1)}" height="1.8" fill="#fff"/><path d="M${f1(x1)} ${f1(gy)}V${f1(top - 1)}M${f1(x2)} ${f1(gy)}V${f1(top - 1)}" stroke="#d5dde5" stroke-width="1.8"/>`;
      back = person({ ...FAR, ...tool, t: 0.96, flip: 1, lat: id + 'f', d: HALF });
      if (s.dbl) back += person({ ...FAR, ...tool, t: 0.92, u: 0.62, flip: 1, d: QTR });
      front = net + person({ ...NEAR, ...tool, t: 0.04, lat: id + 'n' });
      if (s.dbl) front += person({ ...NEAR, ...tool, t: 0.08, u: -0.62, d: QTR });
      dur = s.hands ? '3s' : '2.4s';
    } else if (s.m === 'goal') {
      fn = τ => {
        let t = 0.22,
          u = 0,
          h = 0;
        if (τ > 0.22 && τ <= 0.94) {
          const q = Math.min(1, (τ - 0.22) / 0.4);
          t = 0.22 + 0.75 * q;
          u = 0.12 * q;
          h = 4 * s.A * q * (1 - q);
        }
        const a = τ < 0.88 ? 1 : τ < 0.94 ? 1 - (τ - 0.88) / 0.06 : τ < 0.97 ? 0 : (τ - 0.97) / 0.03;
        return { u, t, h, a };
      };
      const [gx1, gy] = P(-s.gw, 1);
      const [gx2] = P(s.gw, 1);
      const gt = gy - s.gh * SC(1);
      const gh = gy - gt;
      g += `<rect x="${f1(gx1)}" y="${f1(gt)}" width="${f1(gx2 - gx1)}" height="${f1(gh)}" fill="rgba(255,255,255,.2)" stroke="#fff" stroke-width="1.8"/>${mesh(gx1, gx2, gt, gh, 3)}`;
      back = person({
        ...FAR,
        shirt: '#FFD23F',
        t: 0.965,
        arms: ['M-7 -56L-17 -60L-23 -69M7 -56L17 -60L23 -69', 'none'],
        body: 'dive'
      });
      front = person({
        ...NEAR,
        t: 0.1,
        kick: 1,
        arms: ['M-7 -56L-11 -46L-9 -38M7 -56L11 -46L9 -38', 'none']
      });
      pop = 'GOL!';
      dur = '3.2s';
    }

    kf(id + 'b', fn, 60, bmk);
    kf(id + 's', fn, 60, smk);

    ball = `<ellipse ${an(id + 's')} rx="1.3" ry=".5" fill="#000"/>`;
    const bl = `<circle ${an(id + 'b')} r="1" fill="${s.ball}" stroke="rgba(16,36,58,.6)" stroke-width=".25"/>`;
    const txt = pop
      ? `<text x="150" y="86" text-anchor="middle" font-size="24" font-weight="800" fill="#fff" stroke="${INK}" stroke-width="3" paint-order="stroke" class="pop anim" style="animation-name:pop">${pop}</text>`
      : '';

    // Append dynamic styles into DOM
    if (typeof document !== 'undefined') {
      const styleTag = document.createElement('style');
      styleTag.textContent = css;
      document.head.appendChild(styleTag);
    }

    return `<svg viewBox="0 0 300 180" aria-hidden="true" style="--d:${dur}">${g}${ball}${back}${front}${bl}${txt}</svg>`;
  }

  // Sports Catalog matching Database Categories
  const SPORTS = [
    {
      id: 'futsal',
      slug: 'futsal',
      categoryId: 1,
      n: 'Futsal',
      c: '#E8762B',
      o: '#9C4A14',
      p: 150000,
      courts: 2,
      d: '5 vs 5 &bull; Vinyl & Interlock',
      m: 'goal',
      A: 10,
      R: 4,
      ball: '#fff',
      gw: 0.3,
      gh: 70,
      box: 0.55,
      by: 0.8
    },
    {
      id: 'minisoccer',
      slug: 'mini-soccer',
      categoryId: 2,
      n: 'Mini Soccer',
      c: '#3FA346',
      o: '#1F6B2A',
      p: 350000,
      courts: 1,
      d: '7 vs 7 &bull; Rumput Sintetis Bintang 2',
      m: 'goal',
      A: 30,
      R: 4.4,
      ball: '#fff',
      gw: 0.4,
      gh: 80,
      box: 0.7,
      by: 0.72
    },
    {
      id: 'badminton',
      slug: 'badminton',
      categoryId: 3,
      n: 'Badminton',
      c: '#2FA07A',
      o: '#16604A',
      p: 50000,
      courts: 2,
      d: 'Tunggal & Ganda &bull; Karpet BWF',
      m: 'net',
      rk: [5, 8, 0],
      hit: 52,
      A: 30,
      bz: 0,
      net: [32, 62],
      R: 2.6,
      ball: '#fff'
    },
    {
      id: 'voli',
      slug: 'voli',
      categoryId: 4,
      n: 'Bola Voli',
      c: '#E9B96A',
      o: '#2F6FB2',
      p: 80000,
      courts: 1,
      d: '6 vs 6 &bull; Lapangan Indoor Kayu',
      m: 'net',
      hands: 1,
      hit: 62,
      A: 55,
      bz: 0,
      net: [57, 97],
      R: 5,
      ball: '#fff'
    },
    {
      id: 'tenis',
      slug: 'tenis',
      categoryId: 5,
      n: 'Tenis Lapangan',
      c: '#2F63D4',
      o: '#2E8B57',
      p: 120000,
      courts: 2,
      d: 'Hard Court Standar ITF',
      m: 'net',
      rk: [6, 8, 0],
      hit: 34,
      A: 40,
      bz: 1,
      net: [0, 36],
      R: 3,
      ball: '#D8F25A'
    },
    {
      id: 'padel',
      slug: 'padel',
      categoryId: 6,
      n: 'Padel',
      c: '#2E6BE0',
      o: '#17407F',
      p: 200000,
      courts: 1,
      d: 'Panoramik &bull; Dinding Kaca Tempered',
      m: 'net',
      rk: [6, 7.5, 1],
      hit: 34,
      A: 42,
      bz: 1,
      net: [0, 36],
      R: 3,
      ball: '#D8F25A',
      dbl: 1,
      walls: 1
    }
  ];

  // Helper format rupiah
  const rp = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');

  /**
   * Render Sport Selector into a container
   * @param {string|HTMLElement} target - Selector or element
   * @param {Object} options - { currentSlug: '', baseUrl: '', onSelect: function }
   */
  function renderSportCards(target, options = {}) {
    const el = typeof target === 'string' ? document.querySelector(target) : target;
    if (!el) return;

    // Dynamically sync court counts and prices from database categories
    const catList = options.categories || window.ARENA_CATEGORIES || null;
    if (Array.isArray(catList) && catList.length > 0) {
      catList.forEach(cat => {
        const catId = parseInt(cat.id, 10);
        const catSlug = String(cat.slug || '').toLowerCase().trim();
        const catName = String(cat.name || '').toLowerCase().trim();

        const s = SPORTS.find(sp => 
          sp.categoryId === catId || 
          sp.slug.toLowerCase().trim() === catSlug ||
          sp.n.toLowerCase().trim() === catName
        );

        if (s) {
          if (cat.courts_count !== undefined && cat.courts_count !== null) {
            s.courts = parseInt(cat.courts_count, 10);
          }
          if (cat.min_price && parseInt(cat.min_price, 10) > 0) {
            s.p = parseInt(cat.min_price, 10);
          }
        }
      });
    }

    const currentSlug = options.currentSlug || '';
    const baseUrl = (options.baseUrl || '').replace(/\/$/, '');

    let html = '';
    SPORTS.forEach(s => {
      const isSelected = currentSlug === s.slug;
      const targetUrl = baseUrl ? `${baseUrl}/booking?category=${s.slug}#daftar-lapangan` : `javascript:void(0)`;
      const svgArt = generateArt(s);

      html += `
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
          <a href="${targetUrl}" 
             class="sport-select-card ${isSelected ? 'on active' : ''}" 
             data-sport-id="${s.id}" 
             data-slug="${s.slug}"
             data-category-id="${s.categoryId}"
             role="button"
             aria-pressed="${isSelected}">
            <div class="sport-canvas-wrap">
              ${svgArt}
              <span class="sport-card-tag">${s.courts} Lapangan</span>
            </div>
            <div class="sport-card-info">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <h5 class="sport-card-title mb-0">${s.n}</h5>
                <span class="sport-card-price">Mulai ${rp(s.p)}/jam</span>
              </div>
              <p class="sport-card-desc mb-2">${s.d}</p>
              <div class="d-flex align-items-center justify-content-end pt-1 border-top">
                <span class="badge ${isSelected ? 'bg-warning text-dark' : 'bg-light text-secondary border'}">
                  ${isSelected ? 'Dipilih' : 'Pilih Lapangan'} <i class="bi bi-chevron-right ms-1"></i>
                </span>
              </div>
            </div>
          </a>
        </div>
      `;
    });

    el.innerHTML = html;

    // Mobile touch interaction: tap to play / toggle animation
    const cards = el.querySelectorAll('.sport-select-card');
    cards.forEach(card => {
      // Allow touch to start animation
      card.addEventListener('touchstart', function () {
        cards.forEach(c => c.classList.remove('is-touch-playing'));
        this.classList.add('is-touch-playing');
      }, { passive: true });

      if (typeof options.onSelect === 'function') {
        card.addEventListener('click', function (e) {
          e.preventDefault();
          const wasActive = this.classList.contains('active');
          cards.forEach(c => {
            c.classList.remove('on', 'active');
            c.setAttribute('aria-pressed', 'false');
          });
          if (!wasActive) {
            this.classList.add('on', 'active');
            this.setAttribute('aria-pressed', 'true');
            options.onSelect(this.dataset.slug, this.dataset.categoryId, this);
          } else {
            options.onSelect('', '', null);
          }
        });
      }
    });
  }

  // Expose globally
  window.ArenaSportAnimations = {
    SPORTS,
    generateArt,
    renderSportCards
  };

})();
