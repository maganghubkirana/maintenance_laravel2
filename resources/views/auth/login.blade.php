<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#030305">
<title>Login - Maintenance System</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
*{box-sizing:border-box}html,body{min-height:100%;margin:0}body{font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif;background:#030305;color:#fff;overflow-x:hidden}
.login-page{min-height:100vh;position:relative;display:flex;overflow:hidden;background:radial-gradient(circle at 70% 50%,rgba(91,48,255,.16),transparent 34%),#030305}

/* ANIME SIDE */
.anime-side{width:55%;min-height:100vh;position:relative;overflow:hidden;background:#030305}
.anime-image{position:absolute;inset:-5%;width:110%;height:110%;object-fit:cover;object-position:center;filter:brightness(.70) contrast(1.12) saturate(1.15);animation:animeFloat 8s ease-in-out infinite;transition:transform .25s ease-out}
.anime-side:after{content:"";position:absolute;inset:0;background:linear-gradient(90deg,#030305 0%,rgba(3,3,5,.48) 18%,transparent 60%,rgba(3,3,5,.18) 100%),linear-gradient(0deg,rgba(3,3,5,.82),transparent 38%);pointer-events:none}
@keyframes animeFloat{0%,100%{transform:scale(1.06) translate3d(0,0,0)}50%{transform:scale(1.10) translate3d(-8px,-5px,0)}}
.reiatsu{position:absolute;z-index:3;right:20%;top:48%;width:120px;height:120px;border-radius:50%;background:radial-gradient(circle,#fff 0 8%,#d8c5ff 18%,#8b55ff 38%,rgba(78,25,210,.45) 57%,transparent 73%);filter:drop-shadow(0 0 16px #fff) drop-shadow(0 0 50px #743cff) drop-shadow(0 0 100px #4c1fff);animation:pulse 1.25s ease-in-out infinite alternate;mix-blend-mode:screen}
.reiatsu:before,.reiatsu:after{content:"";position:absolute;inset:-35px;border:2px solid rgba(167,117,255,.52);border-radius:50%;animation:ring 1.8s linear infinite}.reiatsu:after{inset:-72px;border-color:rgba(105,55,255,.22);animation-duration:3s;animation-direction:reverse}
@keyframes pulse{from{transform:scale(.78);opacity:.62}to{transform:scale(1.15);opacity:1}}@keyframes ring{0%{transform:scale(.55);opacity:.9}100%{transform:scale(1.35);opacity:0}}
.energy-line{position:absolute;z-index:3;height:2px;background:linear-gradient(90deg,transparent,#7c48ff,#fff,#7c48ff,transparent);box-shadow:0 0 9px #743cff,0 0 25px #743cff;opacity:.8;transform-origin:left;animation:beam 2.2s ease-in-out infinite}.energy-line.one{width:390px;right:7%;top:42%;transform:rotate(-13deg)}.energy-line.two{width:300px;right:4%;top:57%;transform:rotate(8deg);animation-delay:-.8s}.energy-line.three{width:240px;right:20%;top:70%;transform:rotate(-19deg);animation-delay:-1.3s}@keyframes beam{0%,100%{opacity:.15;transform:scaleX(.55) rotate(-13deg)}50%{opacity:1;transform:scaleX(1.12) rotate(-13deg)}}
.particles{position:absolute;inset:0;z-index:4;pointer-events:none}.particle{position:absolute;width:3px;height:3px;border-radius:50%;background:#bda2ff;box-shadow:0 0 9px #743cff,0 0 22px #743cff;animation:particle 7s linear infinite;opacity:0}.particle:nth-child(1){left:8%;top:75%;animation-delay:-1s}.particle:nth-child(2){left:18%;top:55%;animation-delay:-3s}.particle:nth-child(3){left:30%;top:80%;animation-delay:-5s}.particle:nth-child(4){left:44%;top:35%;animation-delay:-2s}.particle:nth-child(5){left:57%;top:72%;animation-delay:-4s}.particle:nth-child(6){left:70%;top:30%;animation-delay:-6s}.particle:nth-child(7){left:83%;top:76%;animation-delay:-2s}.particle:nth-child(8){left:92%;top:42%;animation-delay:-7s}@keyframes particle{0%{transform:translate(0,80px) scale(.4);opacity:0}20%{opacity:.85}80%{opacity:.45}100%{transform:translate(-130px,-190px) scale(1.35);opacity:0}}
.anime-caption{position:absolute;left:7%;bottom:7%;z-index:5}.anime-caption small{font-size:10px;letter-spacing:.48em;color:#b99dff}.anime-caption h1{margin:8px 0 4px;font-size:clamp(48px,6vw,86px);line-height:.82;letter-spacing:-.08em;font-weight:950;text-shadow:0 0 18px rgba(255,255,255,.2),0 0 45px rgba(116,60,255,.5)}.anime-caption h1 span{color:#8655ff}.anime-caption p{margin:0;color:rgba(255,255,255,.52);font-size:11px;letter-spacing:.28em;text-transform:uppercase}

/* LOGIN FORM SIDE */
.login-side{width:45%;min-height:100vh;position:relative;z-index:20;display:flex;align-items:center;justify-content:center;padding:30px 4vw;overflow-y:auto}.login-wrap{width:min(440px,100%);animation:appear .9s cubic-bezier(.2,.8,.2,1) both}@keyframes appear{from{opacity:0;transform:translateY(24px) scale(.97)}to{opacity:1;transform:none}}
.login-header{margin-bottom:20px}.badge{display:inline-flex;align-items:center;gap:8px;padding:7px 12px;border:1px solid rgba(139,92,255,.32);border-radius:999px;background:rgba(55,26,120,.12);color:#bda5ff;font-size:9px;font-weight:800;letter-spacing:.25em;text-transform:uppercase}.badge i{width:6px;height:6px;border-radius:50%;background:#8d5cff;box-shadow:0 0 12px #8d5cff;animation:blink 1.1s infinite}@keyframes blink{50%{opacity:.25;transform:scale(.6)}}
.login-header h2{margin:12px 0 0;font-size:clamp(42px,4vw,56px);line-height:.84;letter-spacing:-.08em;font-weight:950;text-transform:uppercase}.login-header h2 span{color:#8050ff;text-shadow:0 0 20px rgba(128,80,255,.7)}.login-header p{margin:10px 0 0;color:#8e8e9f;font-size:12px;line-height:1.6}

.login-card{position:relative;padding:26px;border:1px solid rgba(126,85,255,.24);border-radius:22px;background:linear-gradient(145deg,rgba(17,17,26,.93),rgba(6,6,10,.96));box-shadow:0 30px 80px rgba(0,0,0,.7),inset 0 1px rgba(255,255,255,.04),0 0 50px rgba(116,60,255,.06);backdrop-filter:blur(20px);overflow:hidden}.login-card:before{content:"";position:absolute;left:-100%;top:0;width:80%;height:2px;background:linear-gradient(90deg,transparent,#743cff,#fff,#743cff,transparent);box-shadow:0 0 18px #743cff;animation:scan 3s ease-in-out infinite}@keyframes scan{0%{left:-100%}55%,100%{left:150%}}
.card-title h3{margin:0 0 4px;font-size:18px}.card-title p{margin:0 0 20px;color:#777789;font-size:11px;line-height:1.5}

/* ERRORS */
.alert-box{margin-bottom:16px;padding:12px 14px;border-radius:12px;background:rgba(255,75,75,.1);border:1px solid rgba(255,75,75,.3);color:#ff7575;font-size:11px;line-height:1.5}.alert-box p{margin:2px 0}

.field{margin-bottom:16px}.field label{display:block;margin-bottom:6px;color:#b7b7c4;font-size:10px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}.input-wrap{position:relative}.input-wrap>svg{position:absolute;left:15px;top:50%;width:18px;height:18px;transform:translateY(-50%);color:#666677;pointer-events:none;transition:.2s}.input-wrap:focus-within>svg{color:#8b5cff;filter:drop-shadow(0 0 6px #743cff)}.input-wrap input{width:100%;height:46px;padding:0 16px 0 46px;border:1px solid rgba(140,140,170,.15);border-radius:12px;outline:none;background:rgba(0,0,0,.35);color:#fff;font:inherit;font-size:12px;transition:.2s}.input-wrap input::placeholder{color:#505061}.input-wrap input:focus{border-color:rgba(128,82,255,.72);background:rgba(28,18,50,.36);box-shadow:0 0 0 3px rgba(116,60,255,.07),0 0 25px rgba(116,60,255,.1)}

.password-toggle{position:absolute;right:10px;top:50%;width:34px;height:34px;display:grid;place-items:center;transform:translateY(-50%);border:0;background:transparent;color:#686879;cursor:pointer}.password-toggle:hover{color:#aa86ff}
.submit-btn{position:relative;width:100%;height:50px;margin-top:10px;border:0;border-radius:12px;overflow:hidden;cursor:pointer;color:#fff;font:inherit;font-size:12px;font-weight:900;letter-spacing:.09em;text-transform:uppercase;background:linear-gradient(100deg,#32127f,#743cff,#a06dff,#32127f);background-size:250% 100%;box-shadow:0 12px 32px rgba(116,60,255,.25),inset 0 1px rgba(255,255,255,.2);animation:gradient 4s linear infinite;transition:.2s}.submit-btn:before{content:"";position:absolute;left:-100%;top:0;width:80%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.35),transparent);transform:skewX(-20deg);animation:shine 2.8s infinite}@keyframes gradient{0%{background-position:0 50%}50%{background-position:100% 50%}100%{background-position:0 50%}}@keyframes shine{0%{left:-100%}55%,100%{left:150%}}.submit-btn:hover{transform:translateY(-2px);box-shadow:0 18px 45px rgba(116,60,255,.4),0 0 25px rgba(116,60,255,.2)}.submit-btn:active{transform:none}.submit-btn.loading{pointer-events:none}.submit-btn.loading .label{opacity:0}.spinner{display:none;position:absolute;left:50%;top:50%;width:20px;height:20px;margin:-10px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite}.submit-btn.loading .spinner{display:block}@keyframes spin{to{transform:rotate(360deg)}}

.footer{margin-top:20px;text-align:center;color:#5f5f6d;font-size:11px}.footer a{color:#a27bff;text-decoration:none;font-weight:800}.footer a:hover{color:#d2bfff}.security{display:flex;justify-content:center;gap:13px;margin-top:12px;color:#41414d;font-size:9px}.security span:before{content:"●";color:#743cff;font-size:5px;margin-right:4px;vertical-align:1px}

@media(max-width:950px){body{overflow-y:auto}.login-page{display:block;min-height:100vh}.anime-side{position:fixed;width:100%;height:100vh;opacity:.35;z-index:1}.anime-side:after{background:linear-gradient(90deg,rgba(3,3,5,.96),rgba(3,3,5,.6),rgba(3,3,5,.96))}.login-side{width:100%;min-height:100vh;padding:35px 20px}.login-wrap{max-width:440px}.anime-caption{display:none}.reiatsu{right:25%}}
@media(max-width:560px){.login-side{padding:20px 12px}.login-card{padding:20px 15px;border-radius:18px}.login-header h2{font-size:42px}}
</style>
</head>
<body>
<div class="login-page">
    <!-- Visual Kiri -->
    <section class="anime-side">
        <img id="animeImage" class="anime-image" src="{{ asset('assets/login-bleach2.jpeg') }}" alt="Bleach Artwork">
        <div class="reiatsu"></div>
        <div class="energy-line one"></div><div class="energy-line two"></div><div class="energy-line three"></div>
        <div class="particles"><i class="particle"></i><i class="particle"></i><i class="particle"></i><i class="particle"></i><i class="particle"></i><i class="particle"></i><i class="particle"></i><i class="particle"></i></div>
        <div class="anime-caption"><small>MAINTENANCE SYSTEM</small><h1>BLEACH<span>.</span></h1><p>Equipment Control Access</p></div>
    </section>

    <!-- Form Kanan -->
    <main class="login-side">
        <div class="login-wrap">
            <div class="login-header">
                <div class="badge"><i></i> SYSTEM ACCESS</div>
                <h2>SIGN <span>IN</span></h2>
                <p>Masuk ke sistem kelola peralatan & maintenance.</p>
            </div>

            <div class="login-card">
                <div class="card-title">
                    <h3>Authentication</h3>
                    <p>Masukkan kredensial akun Anda di bawah ini.</p>
                </div>

                <!-- NOTIFIKASI ERROR LARAVEL -->
                @if(session('error'))
                    <div class="alert-box">
                        <strong>⚠️ Gagal:</strong> {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-box">
                        @foreach ($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    
                    <!-- Username / Email Field -->
                    <div class="field">
                        <label for="username">Email / Username</label>
                        <div class="input-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                            <input 
                                id="username" 
                                type="text" 
                                name="username" 
                                value="{{ old('username') }}" 
                                required 
                                autofocus 
                                autocomplete="username" 
                                placeholder="Masukkan email atau username"
                            >
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="field">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password" 
                                placeholder="Masukkan password"
                            >
                            <button type="button" class="password-toggle" id="togglePassword" aria-label="Tampilkan password">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/><circle cx="12" cy="12" r="2.5"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button class="submit-btn" type="submit" id="loginButton">
                        <span class="label">LOGIN</span>
                        <span class="spinner"></span>
                    </button>
                </form>

                <div class="footer">
                    Belum punya akun? <a href="{{ route('register') }}">Buat akun</a>
                    <div class="security"><span>Secure Auth</span><span>Encrypted</span></div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
// Toggle Password
const password = document.getElementById('password');
const toggle = document.getElementById('togglePassword');
const form = document.getElementById('loginForm');
const btn = document.getElementById('loginButton');

toggle?.addEventListener('click', () => {
    const show = password.type === 'password';
    password.type = show ? 'text' : 'password';
});

// Loading state saat diklik
form?.addEventListener('submit', () => {
    btn.classList.add('loading');
});

// Parallax background
const side = document.querySelector('.anime-side');
const img = document.getElementById('animeImage');
const core = document.querySelector('.reiatsu');

window.addEventListener('pointermove', e => {
    if (!side || innerWidth <= 950) return;
    const x = e.clientX / innerWidth - 0.5;
    const y = e.clientY / innerHeight - 0.5;
    img.style.transform = `scale(1.09) translate3d(${x * -18}px, ${y * -12}px, 0)`;
    core.style.marginLeft = `${x * 22}px`;
    core.style.marginTop = `${y * 18}px`;
}, { passive: true });
</script>
</body>
</html>