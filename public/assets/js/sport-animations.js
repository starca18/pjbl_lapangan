/**
 * ArenaSport — Interactive 3D Isometric Sport Animations (V3)
 * Pure SVG + Dynamic Physics-Driven Keyframe Generator
 * Styles: Athletic Figures, Stadium Floodlights, Authentic Balls/Shuttlecock & Auto-Play
 */

(function () {
  'use strict';

  const INK = '#0f172a';
  // Isometric perspective factor
  const SC = t => 1 / (1 + 1.45 * t);
  const P = (u, t) => {
    const k = SC(t);
    return [150 + u * 135 * k, -26.7 + 191.7 * k];
  };
  const f1 = n => Number(n).toFixed(1);
  const pts = a => a.map(([u, t]) => P(u, t).map(f1).join(',')).join(' ');
  const ln = (a, w = 1.3, c = '#ffffff', op = 0.9) =>
    `<polyline points="${pts(a)}" fill="none" stroke="${c}" stroke-width="${w}" stroke-linejoin="round" opacity="${op}"/>`;
  
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

  // Generate fine net or wire mesh
  const mesh = (x1, x2, top, h, gap = 3.5, color = 'rgba(255,255,255,.4)') => {
    let m = '';
    for (let x = x1 + gap; x < x2; x += gap) m += `M${f1(x)} ${f1(top)}v${f1(h)}`;
    for (let y = gap; y < h; y += gap) m += `M${f1(x1)} ${f1(top + y)}H${f1(x2)}`;
    return `<path d="${m}" stroke="${color}" stroke-width=".5" fill="none"/>`;
  };

  const an = (n, x = '') => `class="anim" style="animation-name:${n};${x}"`;
  const HALF = 'animation-delay:calc(var(--d,2.4s) / -2)';
  const QTR = 'animation-delay:calc(var(--d,2.4s) / -4)';

  // Court Markings
  function lines(s) {
    const i = s.id;
    let g = ln(BOX, 1.8);
    if (i === 'tenis') {
      g += ln([[-0.75, 0], [-0.75, 1]], 1.4) +
        ln([[0.75, 0], [0.75, 1]], 1.4) +
        ln([[-0.75, 0.28], [0.75, 0.28]], 1.4) +
        ln([[-0.75, 0.72], [0.75, 0.72]], 1.4) +
        ln([[0, 0.28], [0, 0.72]], 1.4);
    } else if (i === 'padel') {
      g += ln([[-1, 0.16], [1, 0.16]], 1.4) +
        ln([[-1, 0.84], [1, 0.84]], 1.4) +
        ln([[0, 0.16], [0, 0.84]], 1.4);
    } else if (i === 'badminton') {
      g += ln([[-0.85, 0], [-0.85, 1]], 1.3) +
        ln([[0.85, 0], [0.85, 1]], 1.3) +
        ln([[-1, 0.35], [1, 0.35]], 1.3) +
        ln([[-1, 0.65], [1, 0.65]], 1.3) +
        ln([[0, 0], [0, 0.35]], 1.3) +
        ln([[0, 0.65], [0, 1]], 1.3);
    } else if (i === 'voli') {
      // 3-meter attack lines and center line
      g += ln([[-1, 0.333], [1, 0.333]], 1.5) +
        ln([[-1, 0.5], [1, 0.5]], 1.8) +
        ln([[-1, 0.667], [1, 0.667]], 1.5);
    } else if (s.m === 'goal') {
      // Soccer / Futsal center line and penalty boxes
      g += ln([[-1, 0.5], [1, 0.5]], 1.6) +
        ln(circ(0, 0.5, 0.28, 0.25), 1.5) +
        ln([[-s.box, 1], [-s.box, s.by], [s.box, s.by], [s.box, 1]], 1.5) +
        ln([[-s.box, 0], [-s.box, 1 - s.by], [s.box, 1 - s.by], [s.box, 0]], 1.5);
    }
    return g;
  }

  /**
   * Render Proportional Athletic Player Figure
   */
  function person(o) {
    const k = SC(o.t);
    const [x, y] = P(o.u || 0, o.t);
    const sk = o.skin || '#F0C09B';
    const D = o.d || '';
    const ST = `fill="none" stroke="${sk}" stroke-width="3.8" stroke-linecap="round" stroke-linejoin="round"`;
    let arms = '';

    // Arms & Equipment
    if (o.arms) {
      arms = `<g class="anim" style="transform-origin:0px -56px;animation-name:${o.arms[1]};${D}"><path d="${o.arms[0]}" ${ST}/></g>`;
    }

    if (o.volleySpike) {
      // Two arms raised high for spike
      arms = `<path d="M-8 -54 L-14 -72 L-10 -84 M8 -54 L14 -72 L10 -84" ${ST}/>`;
    }

    if (o.volleyReady) {
      // Forearm platform clasped together for bump pass
      arms = `<path d="M-8 -52 L-3 -40 L0 -35 M8 -52 L3 -40 L0 -35" ${ST}/>`;
    }

    if (o.gkGloves) {
      // Goalkeeper hands with neon gloves
      arms = `<path d="M-8 -52 L-16 -58 L-22 -66" ${ST}/><ellipse cx="-23" cy="-68" rx="4" ry="4" fill="#d9f828" stroke="#0f172a" stroke-width="1.2"/><path d="M8 -52 L16 -58 L22 -66" ${ST}/><ellipse cx="23" cy="-68" rx="4" ry="4" fill="#d9f828" stroke="#0f172a" stroke-width="1.2"/>`;
    }

    if (o.rk) {
      const [rx, ry, isPadel] = o.rk;
      const cy = -46 - ry;
      if (isPadel) {
        // Padel paddle: solid carbon oval with perforation dots
        arms = `<path d="M-8 -54 L-13 -44 L-10 -36" ${ST}/>
          <g class="anim" style="transform-origin:7px -54px;animation-name:arm;${D}">
            <path d="M8 -54 L13 -44 L16 -39" ${ST}/>
            <path d="M16.5 -39 L18.5 -46" stroke="#0f172a" stroke-width="2.5"/>
            <ellipse cx="20" cy="${cy}" rx="${rx}" ry="${ry}" transform="rotate(15 20 ${cy})" fill="#1e293b" stroke="#0f172a" stroke-width="1.8"/>
            <circle cx="20" cy="${cy}" r="1.2" fill="#0f172a"/>
            <circle cx="18" cy="${cy-2}" r="0.8" fill="#ffffff" opacity=".7"/>
            <circle cx="22" cy="${cy+2}" r="0.8" fill="#ffffff" opacity=".7"/>
          </g>`;
      } else {
        // Badminton / Tennis racket with strings & head
        arms = `<path d="M-8 -54 L-13 -44 L-10 -36" ${ST}/>
          <g class="anim" style="transform-origin:7px -54px;animation-name:arm;${D}">
            <path d="M8 -54 L13 -44 L16 -39" ${ST}/>
            <path d="M16.5 -39 L19 -47" stroke="#0f172a" stroke-width="2"/>
            <ellipse cx="21" cy="${cy}" rx="${rx}" ry="${ry}" transform="rotate(14 21 ${cy})" fill="rgba(255,255,255,.25)" stroke="#0f172a" stroke-width="1.8"/>
            <line x1="21" y1="${cy-ry+1}" x2="21" y2="${cy+ry-1}" stroke="#94a3b8" stroke-width="0.8"/>
            <line x1="${21-rx+1}" y1="${cy}" x2="${21+rx-1}" y2="${cy}" stroke="#94a3b8" stroke-width="0.8"/>
          </g>`;
      }
    }

    // Athletic Head & Hair/Headband
    const head = o.front
      ? `<circle cy="-65" r="5.6" fill="${sk}"/>
         <path d="M-5.6 -65 a5.6 5.6 0 0 1 11.2 0 Q0 -69 -5.6 -65Z" fill="${o.hair}"/>
         <rect x="-5.4" y="-66.5" width="10.8" height="2" rx="1" fill="${o.band || '#ffffff'}"/>`
      : `<circle cy="-65" r="5.8" fill="${o.hair}"/>
         <rect x="-5.6" y="-66.5" width="11.2" height="2.2" rx="1" fill="${o.band || '#ffffff'}"/>`;

    // Dynamic Kick / Run Animation
    const lk = o.kick ? an('legk', 'transform-origin:3px -28px') : '';
    const lw = `stroke="${sk}" stroke-width="4.2" fill="none" stroke-linecap="round" stroke-linejoin="round"`;
    
    // Athletic Jersey with V-neck & Number
    const num = o.num || '7';
    const jerseyGraphic = `
      <path d="M-8.5 -57 L8.5 -57 L7 -36 L-7 -36 Z" fill="${o.shirt}" stroke="rgba(15,23,42,.3)" stroke-width=".8"/>
      <path d="M-8.5 -57 L-4 -48 M8.5 -57 L4 -48" stroke="#ffffff" stroke-width="1.2" opacity=".7"/>
      <text x="0" y="-43" font-size="7.5" font-weight="900" fill="#ffffff" text-anchor="middle" font-family="'Kanit', sans-serif" opacity=".95">${num}</text>
    `;

    return `<g ${o.lat ? an(o.lat) : ''}>
      <g transform="translate(${f1(x)} ${f1(y)}) scale(${o.flip ? -k : k} ${k})">
        <!-- Contact Floor Shadow -->
        <ellipse rx="15" ry="3.5" fill="rgba(0,0,0,.35)"/>
        <g ${an(o.body || 'bob', D)}>
          <!-- Left Leg & Athletic Sneaker -->
          <path d="M-4 -28 L-10 -14 L-11 -1" ${lw}/>
          <ellipse cx="-11.5" cy="0" rx="4.8" ry="2.4" fill="#ffffff" stroke="#0f172a" stroke-width="0.8"/>
          <path d="M-13 -0.5 L-8 -0.5" stroke="${o.shorts}" stroke-width="1.2"/>
          
          <!-- Right Leg & Athletic Sneaker -->
          <g ${lk}>
            <path d="M4 -28 L10 -14 L11 -1" ${lw}/>
            <ellipse cx="11.5" cy="0" rx="4.8" ry="2.4" fill="#ffffff" stroke="#0f172a" stroke-width="0.8"/>
            <path d="M8 -0.5 L13 -0.5" stroke="${o.shorts}" stroke-width="1.2"/>
          </g>

          <!-- Sport Shorts with athletic trim -->
          <path d="M-8 -37 L8 -37 L10 -24 L2 -26 L-2 -26 L-10 -24 Z" fill="${o.shorts}"/>
          <path d="M-8 -36 L-10 -24 M8 -36 L10 -24" stroke="#ffffff" stroke-width="1" opacity=".6"/>

          <!-- Torso, Arms & Head -->
          ${jerseyGraphic}
          ${arms}
          ${head}
        </g>
      </g>
    </g>`;
  }

  // Padel Glass Walls
  const wall = (a, type = 'side') => {
    const ptsStr = a.map(([u, t, h]) => {
      const [x, y] = P(u, t);
      return f1(x) + ',' + f1(y - h * SC(t));
    }).join(' ');
    
    // Glass with realistic specular shine highlight
    return `<polygon points="${ptsStr}" fill="rgba(255,255,255,.14)" stroke="rgba(255,255,255,.6)" stroke-width=".8"/>
      <polygon points="${ptsStr}" fill="url(#padel-glass-shine)" opacity=".6"/>`;
  };

  const NEAR = { shirt: '#ea580c', shorts: '#0f172a', hair: '#1e293b', band: '#ffffff', num: '7' };
  const FAR = { shirt: '#0284c7', shorts: '#0f172a', hair: '#29180b', band: '#38bdf8', front: 1, num: '10' };

  /**
   * Main Artwork & Physics Generator for Sport Cards
   */
  function generateArt(s) {
    const id = s.id;
    const R = s.R || 3.2;
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
      return `translate:${f1(x)}px ${f1(y)}px;scale:${(k * R).toFixed(3)};opacity:${(((p.a ?? 1) * 0.45) / (1 + p.h / 40)).toFixed(2)}`;
    };

    // Defs: Gradients, Shading & Stadium Floodlights
    let g = `
      <defs>
        <linearGradient id="stadium-light-left-${id}" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="#ffffff" stop-opacity="0.28"/>
          <stop offset="40%" stop-color="#ffffff" stop-opacity="0.08"/>
          <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
        </linearGradient>
        <linearGradient id="stadium-light-right-${id}" x1="1" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="#ffffff" stop-opacity="0.28"/>
          <stop offset="40%" stop-color="#ffffff" stop-opacity="0.08"/>
          <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
        </linearGradient>
        <linearGradient id="court-depth-${id}" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="#000000" stop-opacity="0.32"/>
          <stop offset="100%" stop-color="#000000" stop-opacity="0.04"/>
        </linearGradient>
        <linearGradient id="padel-glass-shine" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="#ffffff" stop-opacity="0.45"/>
          <stop offset="30%" stop-color="#ffffff" stop-opacity="0.05"/>
          <stop offset="70%" stop-color="#ffffff" stop-opacity="0.2"/>
          <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
        </linearGradient>
      </defs>
      <!-- Stadium Dark Night Background -->
      <rect width="300" height="180" fill="#070d18"/>
      
      <!-- LED Arena Top Ribbon Banner -->
      <rect width="300" height="34" fill="#050a12"/>
      <rect y="31" width="300" height="3.5" fill="var(--sport-primary, #ea580c)"/>
      <g font-family="'Kanit', sans-serif" font-style="italic" font-weight="900" font-size="6.5" letter-spacing="1">
        <text x="50" y="22" fill="#ffffff" opacity=".85" text-anchor="middle">ARENA<tspan fill="#f97316">SPORT</tspan></text>
        <text x="150" y="22" fill="#ffffff" opacity=".85" text-anchor="middle">ARENA<tspan fill="#f97316">SPORT</tspan></text>
        <text x="250" y="22" fill="#ffffff" opacity=".85" text-anchor="middle">ARENA<tspan fill="#f97316">SPORT</tspan></text>
      </g>
      <!-- LED Spotlight fixtures -->
      <circle cx="20" cy="10" r="3" fill="#ffffff" opacity=".9"/>
      <circle cx="280" cy="10" r="3" fill="#ffffff" opacity=".9"/>

      <!-- Stadium Floodlight Beams -->
      <polygon points="15,10 65,10 135,180 0,180" fill="url(#stadium-light-left-${id})" pointer-events="none"/>
      <polygon points="285,10 235,10 165,180 300,180" fill="url(#stadium-light-right-${id})" pointer-events="none"/>

      <!-- Outer Court Apron -->
      <polygon points="${pts([[-1.25, -0.12], [1.25, -0.12], [1.25, 1.06], [-1.25, 1.06]])}" fill="${s.o}"/>
    `;

    // Specific Court Textures
    if (id === 'minisoccer') {
      // Base grass
      g += `<polygon points="${pts(BOX)}" fill="${s.c}"/>`;
      // Alternating mowed lawn stripes for authentic turf
      for (let u = -1; u < 1; u += 0.333) {
        g += `<polygon points="${pts([[u, 0], [u + 0.166, 0], [u + 0.166, 1], [u, 1]])}" fill="#1a6e2e" opacity="0.35"/>`;
      }
    } else if (id === 'tenis') {
      // US Open 2-tone: Green Apron + Blue Main Court
      g += `<polygon points="${pts(BOX)}" fill="#1d6b47"/>`;
      g += `<polygon points="${pts([[-0.75, 0], [0.75, 0], [0.75, 1], [-0.75, 1]])}" fill="#1e5cb8"/>`;
    } else if (id === 'futsal') {
      // Parquet wood/vinyl reflection
      g += `<polygon points="${pts(BOX)}" fill="${s.c}"/>`;
      g += `<polygon points="${pts([[-1, 0.3], [1, 0.3], [1, 0.65], [-1, 0.65]])}" fill="#ffffff" opacity="0.08"/>`;
    } else {
      g += `<polygon points="${pts(BOX)}" fill="${s.c}"/>`;
    }

    // Court Depth Shadow & Court Lines
    g += `<polygon points="${pts(BOX)}" fill="url(#court-depth-${id})"/>` + lines(s);

    let fn,
      front = '',
      back = '',
      ball = '',
      ballShadow = '',
      pop = '',
      dur = '2.6s';

    // Sports Mechanics
    if (s.m === 'net') {
      const T1 = 0.38;
      fn = τ => {
        const ret = τ >= 0.5;
        const x = ret ? τ - 0.5 : τ;
        let t, h;
        if (s.bz) {
          // Tennis / Padel ground bounce physics
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
          // Badminton / Voli clean aerial arc
          const q = x / 0.5;
          t = 0.1 + 0.8 * q;
          h = s.hit + 4 * s.A * q * (1 - q);
        }
        return { u: 0.32 * Math.cos(2 * Math.PI * τ), t: ret ? 1 - t : t, h };
      };

      // Near & Far player sway
      kf(id + 'n', τ => 0.32 * Math.cos(2 * Math.PI * τ) - 0.12, 24, u => `translate:${f1(P(u, 0.04)[0] - 150)}px 0`);
      kf(id + 'f', τ => 0.32 * Math.cos(2 * Math.PI * τ) + 0.12, 24, u => `translate:${f1(P(u, 0.96)[0] - 150)}px 0`);

      // Padel 3D Glass Walls & Steel Posts
      if (s.walls) {
        g += wall([[-1, 0, 0], [-1, 1, 0], [-1, 1, 115], [-1, 0, 115]], 'left') +
             wall([[1, 0, 0], [1, 1, 0], [1, 1, 115], [1, 0, 115]], 'right') +
             wall([[-1, 1, 0], [1, 1, 0], [1, 1, 115], [-1, 1, 115]], 'back');
      }

      // Net Structure
      const [nb, nt] = s.net;
      const k = SC(0.5);
      const [x1, gy] = P(-1.06, 0.5);
      const [x2] = P(1.06, 0.5);
      const top = gy - nt * k;
      const h = (nt - nb) * k;

      // Antenna rods for Volleyball
      let antennas = '';
      if (id === 'voli') {
        antennas = `
          <line x1="${f1(x1 + 18)}" y1="${f1(top - 16)}" x2="${f1(x1 + 18)}" y2="${f1(top + h)}" stroke="#ef4444" stroke-width="1.8" stroke-dasharray="3,3"/>
          <line x1="${f1(x2 - 18)}" y1="${f1(top - 16)}" x2="${f1(x2 - 18)}" y2="${f1(top + h)}" stroke="#ef4444" stroke-width="1.8" stroke-dasharray="3,3"/>
        `;
      }

      const netHtml = `
        <rect x="${f1(x1)}" y="${f1(top)}" width="${f1(x2 - x1)}" height="${f1(h)}" fill="rgba(255,255,255,.2)"/>
        ${mesh(x1, x2, top, h, 3.2, id === 'badminton' ? 'rgba(15,23,42,.6)' : 'rgba(255,255,255,.45)')}
        <rect x="${f1(x1)}" y="${f1(top)}" width="${f1(x2 - x1)}" height="2.2" fill="#ffffff"/>
        <path d="M${f1(x1)} ${f1(gy)}V${f1(top - 2)}M${f1(x2)} ${f1(gy)}V${f1(top - 2)}" stroke="#cbd5e1" stroke-width="2.2"/>
        ${antennas}
      `;

      if (id === 'voli') {
        back = person({ ...FAR, volleySpike: 1, t: 0.96, flip: 1, lat: id + 'f', d: HALF, body: 'jump' });
        front = netHtml + person({ ...NEAR, volleyReady: 1, t: 0.05, lat: id + 'n' });
        dur = '2.8s';
      } else {
        const tool = { rk: s.rk };
        back = person({ ...FAR, ...tool, t: 0.96, flip: 1, lat: id + 'f', d: HALF });
        if (s.dbl) back += person({ ...FAR, ...tool, t: 0.92, u: 0.58, flip: 1, d: QTR, shirt: '#38bdf8' });
        front = netHtml + person({ ...NEAR, ...tool, t: 0.05, lat: id + 'n' });
        if (s.dbl) front += person({ ...NEAR, ...tool, t: 0.08, u: -0.58, d: QTR, shirt: '#f97316' });
        dur = '2.4s';
      }

    } else if (s.m === 'goal') {
      // Soccer / Futsal Goal Mechanics
      fn = τ => {
        let t = 0.22, u = 0, h = 0;
        if (τ > 0.20 && τ <= 0.92) {
          const q = Math.min(1, (τ - 0.20) / 0.42);
          t = 0.22 + 0.76 * q;
          u = 0.14 * q;
          h = 4 * s.A * q * (1 - q);
        }
        const a = τ < 0.86 ? 1 : τ < 0.92 ? 1 - (τ - 0.86) / 0.06 : τ < 0.96 ? 0 : (τ - 0.96) / 0.04;
        return { u, t, h, a };
      };

      const [gx1, gy] = P(-s.gw, 1);
      const [gx2] = P(s.gw, 1);
      const gt = gy - s.gh * SC(1);
      const gh = gy - gt;
      
      // 3D Goal with depth posts & hexagon netting
      g += `
        <rect x="${f1(gx1)}" y="${f1(gt)}" width="${f1(gx2 - gx1)}" height="${f1(gh)}" fill="rgba(255,255,255,.18)" stroke="#ffffff" stroke-width="2.2"/>
        ${mesh(gx1, gx2, gt, gh, 3, 'rgba(255,255,255,.45)')}
      `;

      // Diving Goalkeeper with Neon Gloves
      back = person({
        ...FAR,
        shirt: '#eab308', // Neon Goalkeeper kit
        shorts: '#0f172a',
        t: 0.965,
        gkGloves: 1,
        body: 'dive',
        num: '1'
      });

      // Striker in kicking follow-through
      front = person({
        ...NEAR,
        t: 0.12,
        kick: 1,
        shirt: '#ea580c',
        num: '9'
      });

      pop = 'GOL!';
      dur = '3.0s';
    }

    // Keyframes for ball trajectory & ground shadow
    kf(id + 'b', fn, 60, bmk);
    kf(id + 's', fn, 60, smk);

    // Dynamic Ball Ground Shadow
    ballShadow = `<ellipse ${an(id + 's')} rx="1.6" ry=".6" fill="#000000"/>`;

    // Authentic Sport Balls
    let ballElement = '';
    if (id === 'badminton') {
      // Shuttlecock (Kok) with conical feathers & cork
      ballElement = `
        <g ${an(id + 'b')}>
          <path d="M-2 -3.5 L2 -3.5 L1.2 0 L-1.2 0 Z" fill="#ffffff" stroke="#cbd5e1" stroke-width="0.3"/>
          <circle cx="0" cy="0.4" r="1.3" fill="#e2d4b7" stroke="#92400e" stroke-width="0.3"/>
        </g>
      `;
    } else if (id === 'tenis') {
      // Optic Neon Tennis ball with white curved seam
      ballElement = `
        <g ${an(id + 'b')}>
          <circle r="1.5" fill="#d9f828" stroke="#0f172a" stroke-width="0.3"/>
          <path d="M-1 -0.8 Q0 0 -1 0.8 M1 -0.8 Q0 0 1 0.8" stroke="#ffffff" stroke-width="0.4" fill="none"/>
        </g>
      `;
    } else if (id === 'voli') {
      // Tricolor Volleyball (Yellow / Blue / White)
      ballElement = `
        <g ${an(id + 'b')}>
          <circle r="1.9" fill="#ffffff" stroke="#0f172a" stroke-width="0.3"/>
          <path d="M-1.4 0 Q0 -1.4 1.4 0" stroke="#1d4ed8" stroke-width="0.9" fill="none"/>
          <path d="M0 -1.4 Q1.4 0 0 1.4" stroke="#facc15" stroke-width="0.9" fill="none"/>
        </g>
      `;
    } else if (id === 'minisoccer' || id === 'futsal') {
      // Classic Pentagon Soccer/Futsal Ball
      ballElement = `
        <g ${an(id + 'b')}>
          <circle r="1.8" fill="#ffffff" stroke="#0f172a" stroke-width="0.35"/>
          <polygon points="0,-0.8 -0.7,-0.2 -0.4,0.6 0.4,0.6 0.7,-0.2" fill="#0f172a"/>
        </g>
      `;
    } else {
      // Padel ball
      ballElement = `
        <g ${an(id + 'b')}>
          <circle r="1.4" fill="#d9f828" stroke="#0f172a" stroke-width="0.3"/>
        </g>
      `;
    }

    // Goal Popup Celebration
    const txt = pop
      ? `<g class="pop anim" style="animation-name:pop">
           <text x="150" y="86" text-anchor="middle" font-family="'Kanit', sans-serif" font-style="italic" font-size="26" font-weight="900" fill="#facc15" stroke="${INK}" stroke-width="3.5" paint-order="stroke">${pop}</text>
         </g>`
      : '';

    // Append dynamic styles into DOM
    if (typeof document !== 'undefined') {
      const styleTag = document.createElement('style');
      styleTag.textContent = css;
      document.head.appendChild(styleTag);
    }

    return `<svg viewBox="0 0 300 180" aria-hidden="true" style="--d:${dur}">${g}${ballShadow}${back}${front}${ballElement}${txt}</svg>`;
  }

  // Sports Catalog matching Database Categories
  const SPORTS = [
    {
      id: 'futsal',
      slug: 'futsal',
      categoryId: 1,
      n: 'Futsal',
      c: '#d96528',
      o: '#7c2d12',
      p: 150000,
      courts: 2,
      d: '5 vs 5 &bull; Vinyl & Interlock',
      m: 'goal',
      A: 12,
      R: 3.8,
      gw: 0.32,
      gh: 72,
      box: 0.55,
      by: 0.8
    },
    {
      id: 'minisoccer',
      slug: 'mini-soccer',
      categoryId: 2,
      n: 'Mini Soccer',
      c: '#2d8838',
      o: '#14532d',
      p: 350000,
      courts: 1,
      d: '7 vs 7 &bull; Rumput Sintetis Bintang 2',
      m: 'goal',
      A: 32,
      R: 4.2,
      gw: 0.42,
      gh: 82,
      box: 0.72,
      by: 0.72
    },
    {
      id: 'badminton',
      slug: 'badminton',
      categoryId: 3,
      n: 'Badminton',
      c: '#0e6b47',
      o: '#064e3b',
      p: 50000,
      courts: 2,
      d: 'Tunggal & Ganda &bull; Karpet BWF',
      m: 'net',
      rk: [5, 7.5, 0],
      hit: 54,
      A: 32,
      bz: 0,
      net: [32, 64],
      R: 3.2
    },
    {
      id: 'voli',
      slug: 'voli',
      categoryId: 4,
      n: 'Bola Voli',
      c: '#d59a57',
      o: '#1e3a8a',
      p: 80000,
      courts: 1,
      d: '6 vs 6 &bull; Lapangan Indoor Kayu',
      m: 'net',
      hit: 64,
      A: 58,
      bz: 0,
      net: [58, 100],
      R: 4.2
    },
    {
      id: 'tenis',
      slug: 'tenis',
      categoryId: 5,
      n: 'Tenis Lapangan',
      c: '#1e5cb8',
      o: '#14532d',
      p: 120000,
      courts: 2,
      d: 'Hard Court Standar ITF',
      m: 'net',
      rk: [6, 8, 0],
      hit: 35,
      A: 42,
      bz: 1,
      net: [0, 36],
      R: 3.2
    },
    {
      id: 'padel',
      slug: 'padel',
      categoryId: 6,
      n: 'Padel',
      c: '#1b5fcd',
      o: '#0f2952',
      p: 200000,
      courts: 1,
      d: 'Panoramik &bull; Dinding Kaca Tempered',
      m: 'net',
      rk: [6, 7.5, 1],
      hit: 35,
      A: 42,
      bz: 1,
      net: [0, 36],
      R: 3.2,
      dbl: 1,
      walls: 1
    }
  ];

  // Helper format rupiah
  const rp = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');

  /**
   * Render Sport Selector into a container
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
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
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
