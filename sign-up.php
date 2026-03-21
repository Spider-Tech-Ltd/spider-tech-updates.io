<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Sign Up | Spider Tech Ltd.</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-background": "#e2e2eb",
                        "on-surface": "#e2e2eb",
                        "tertiary-fixed-dim": "#ffb786",
                        "surface-container-low": "#191b22",
                        "surface-container-highest": "#33343b",
                        "on-tertiary": "#502400",
                        "inverse-surface": "#e2e2eb",
                        "outline-variant": "#424754",
                        "surface-dim": "#111319",
                        "on-secondary-fixed": "#0d1c2e",
                        "on-secondary": "#233144",
                        "surface-container-lowest": "#0c0e14",
                        "on-tertiary-fixed": "#311400",
                        "error-container": "#93000a",
                        "tertiary": "#ffb786",
                        "on-tertiary-fixed-variant": "#723600",
                        "primary-fixed-dim": "#adc6ff",
                        "surface": "#111319",
                        "surface-container-high": "#282a30",
                        "outline": "#8c909f",
                        "inverse-primary": "#005ac2",
                        "on-primary-fixed-variant": "#004395",
                        "primary-fixed": "#d8e2ff",
                        "secondary-container": "#3c4a5e",
                        "tertiary-container": "#df7412",
                        "on-primary-fixed": "#001a42",
                        "surface-variant": "#33343b",
                        "on-primary-container": "#00285d",
                        "primary-container": "#4d8eff",
                        "on-tertiary-container": "#461f00",
                        "secondary": "#b9c7df",
                        "surface-container": "#1e1f26",
                        "secondary-fixed": "#d5e3fc",
                        "on-secondary-container": "#abb9d1",
                        "on-primary": "#002e6a",
                        "on-error-container": "#ffdad6",
                        "on-error": "#690005",
                        "on-secondary-fixed-variant": "#3a485b",
                        "tertiary-fixed": "#ffdcc6",
                        "secondary-fixed-dim": "#b9c7df",
                        "surface-bright": "#373940",
                        "error": "#ffb4ab",
                        "surface-tint": "#adc6ff",
                        "on-surface-variant": "#c2c6d6",
                        "background": "#111319",
                        "inverse-on-surface": "#2e3037",
                        "primary": "#adc6ff"
                    },
                    fontFamily: {
                        "headline": ["Inter"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .circuit-bg {
            background-image: radial-gradient(circle at 2px 2px, rgba(173, 198, 255, 0.05) 1px, transparent 0);
            background-size: 32px 32px;
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body overflow-x-hidden min-h-screen flex flex-col">
<!-- Top Navigation (Shell Supressed but Brand Identity Maintained) -->
<header class="fixed top-0 w-full z-50 bg-[#111319]/80 backdrop-blur-xl border-b border-[#adc6ff]/10 shadow-[0_0_20px_rgba(173,198,255,0.05)]">
<div class="flex justify-between items-center px-8 h-16 w-full">
<div class="text-xl font-black tracking-tighter text-[#adc6ff] uppercase font-['Inter']">
                Spider Tech Ltd.
            </div>
<div class="flex gap-4">
<span class="material-symbols-outlined text-[#adc6ff]/60 hover:text-[#adc6ff] cursor-pointer transition-all active:scale-95" data-icon="help">help</span>
<span class="material-symbols-outlined text-[#adc6ff]/60 hover:text-[#adc6ff] cursor-pointer transition-all active:scale-95" data-icon="settings">settings</span>
</div>
</div>
</header>
<main class="flex-grow flex pt-16">
<!-- Split Screen Layout -->
<div class="flex w-full min-h-[calc(100vh-64px)]">
<!-- Left Side: Value Proposition -->
<section class="hidden lg:flex lg:w-1/2 bg-surface-container-lowest relative overflow-hidden items-center justify-center p-12 border-r border-outline-variant/10">
<!-- Architectural Accents -->
<div class="absolute inset-0 circuit-bg pointer-events-none opacity-50"></div>
<div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none" style="background-image: linear-gradient(rgba(173, 198, 255, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(173, 198, 255, 0.1) 1px, transparent 1px); background-size: 100px 100px;"></div>
<div class="relative z-10 max-w-lg">
<h1 class="text-5xl font-extrabold tracking-tighter text-on-surface mb-12 leading-tight">
                        Precision Engineering <br/><span class="text-primary">Starts Here.</span>
</h1>
<div class="space-y-10">
<!-- Feature 1 -->
<div class="flex gap-6 group">
<div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary/10 border border-primary/20 flex items-center justify-center text-primary transition-all group-hover:bg-primary group-hover:text-on-primary">
<span class="material-symbols-outlined" data-icon="hub" style="font-variation-settings: 'FILL' 1;">hub</span>
</div>
<div>
<h3 class="text-lg font-bold text-on-surface mb-1 uppercase tracking-wider">Exclusive Industry Updates</h3>
<p class="text-on-surface-variant text-sm leading-relaxed">Direct feeds from our R&amp;D labs and industrial partners, keeping you ahead of the technical curve.</p>
</div>
</div>
<!-- Feature 2 -->
<div class="flex gap-6 group">
<div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary/10 border border-primary/20 flex items-center justify-center text-primary transition-all group-hover:bg-primary group-hover:text-on-primary">
<span class="material-symbols-outlined" data-icon="engineering" style="font-variation-settings: 'FILL' 1;">engineering</span>
</div>
<div>
<h3 class="text-lg font-bold text-on-surface mb-1 uppercase tracking-wider">Solve Engineering Challenges</h3>
<p class="text-on-surface-variant text-sm leading-relaxed">Access to proprietary toolsets and collaborative frameworks designed for complex industrial problem-solving.</p>
</div>
</div>
<!-- Feature 3 -->
<div class="flex gap-6 group">
<div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary/10 border border-primary/20 flex items-center justify-center text-primary transition-all group-hover:bg-primary group-hover:text-on-primary">
<span class="material-symbols-outlined" data-icon="bolt" style="font-variation-settings: 'FILL' 1;">bolt</span>
</div>
<div>
<h3 class="text-lg font-bold text-on-surface mb-1 uppercase tracking-wider">Accelerate Tech Growth</h3>
<p class="text-on-surface-variant text-sm leading-relaxed">Tools built for the high-velocity precision of tomorrow, ensuring your infrastructure is future-proof.</p>
</div>
</div>
</div>
<!-- Visual Accent -->
<div class="mt-20 pt-10 border-t border-outline-variant/20 flex items-center gap-4 opacity-50">
<div class="h-[1px] w-24 bg-primary"></div>
<span class="text-[10px] uppercase tracking-[0.3em] font-bold text-primary">System Integrity: Optimal</span>
</div>
</div>
</section>
<!-- Right Side: Registration Card -->
<section class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-surface">
<div class="w-full max-w-md">
<!-- Glassmorphism Card -->
<div class="bg-surface-container-high/40 backdrop-blur-xl border border-primary/30 rounded-xl p-8 sm:p-10 shadow-[0_0_40px_rgba(77,142,255,0.1)] relative overflow-hidden group">
<!-- Kinetic Pulse Border (Simulated) -->
<div class="absolute inset-0 border-2 border-primary/20 rounded-xl pointer-events-none group-hover:border-primary/40 transition-colors duration-500"></div>
<div class="mb-8 relative z-10">
<h2 class="text-3xl font-black text-on-surface tracking-tight mb-2">Join the Network</h2>
<p class="text-on-surface-variant font-medium">Get exclusive access to the industrial tech of tomorrow.</p>
</div>
<!-- Registration Form -->
<form class="space-y-4 relative z-10" onsubmit="return false;">
<div class="space-y-1">
<label class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant ml-1">Full Name</label>
<input class="w-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface rounded-lg px-4 py-3 focus:ring-0 focus:border-primary transition-all outline-none placeholder:text-on-surface-variant/30" placeholder="e.g. Alan Turing" type="text"/>
</div>
<div class="space-y-1">
<label class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant ml-1">Professional Email</label>
<input class="w-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface rounded-lg px-4 py-3 focus:ring-0 focus:border-primary transition-all outline-none placeholder:text-on-surface-variant/30" placeholder="name@company.tech" type="email"/>
</div>
<div class="space-y-1">
<label class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant ml-1">Company / Role</label>
<input class="w-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface rounded-lg px-4 py-3 focus:ring-0 focus:border-primary transition-all outline-none placeholder:text-on-surface-variant/30" placeholder="Senior Systems Architect" type="text"/>
</div>
<div class="space-y-1">
<label class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant ml-1">Password</label>
<input class="w-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface rounded-lg px-4 py-3 focus:ring-0 focus:border-primary transition-all outline-none placeholder:text-on-surface-variant/30" placeholder="••••••••" type="password"/>
</div>
<div class="flex items-center gap-3 py-2">
<input class="w-4 h-4 rounded border-outline-variant/30 bg-surface-container-lowest text-primary focus:ring-offset-0 focus:ring-0" type="checkbox"/>
<label class="text-xs text-on-surface-variant">I agree to the <a class="text-primary hover:underline" href="#">Terms of Service</a> and <a class="text-primary hover:underline" href="#">Privacy Policy</a></label>
</div>
<button class="w-full bg-gradient-to-br from-primary to-primary-container text-on-primary font-bold py-4 rounded-lg shadow-[0_0_20px_rgba(173,198,255,0.3)] hover:shadow-[0_0_30px_rgba(173,198,255,0.5)] active:scale-[0.98] transition-all uppercase tracking-widest text-sm">
                                Create My Free Account
                            </button>
</form>
<div class="relative my-8">
<div class="absolute inset-0 flex items-center"><div class="w-full border-t border-outline-variant/20"></div></div>
<div class="relative flex justify-center text-[10px] uppercase tracking-[0.2em] font-bold text-on-surface-variant/50"><span class="bg-surface-container-high px-3">Or continue with</span></div>
</div>
<!-- Social Sign Up -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 relative z-10">
<button class="flex items-center justify-center gap-2 bg-[#0077b5] text-white py-3 px-4 rounded-lg font-bold text-sm hover:brightness-110 active:scale-95 transition-all">
<svg class="w-4 h-4" fill="currentColor" viewbox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path></svg>
                                LinkedIn
                            </button>
<button class="flex items-center justify-center gap-2 bg-transparent border border-outline-variant/30 text-on-surface py-3 px-4 rounded-lg font-bold text-sm hover:bg-surface-variant/30 active:scale-95 transition-all">
<svg class="w-4 h-4" viewbox="0 0 24 24"><path d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115z" fill="#EA4335"></path><path d="M16.04 18.013c-1.09.303-2.26.477-3.46.477a7.077 7.077 0 0 1-7.314-4.873l-4.026 3.115C3.198 21.302 7.27 24 12 24c3.055 0 5.782-1.145 7.91-3l-3.87-2.987z" fill="#FBBC05"></path><path d="M19.91 21c2.254-2.145 3.59-5.327 3.59-9 0-.627-.054-1.236-.155-1.827H12v4.418h6.41c-.277 1.382-1.054 2.545-2.218 3.327l3.718 3.082z" fill="#4285F4"></path><path d="M1.24 17.35l4.026-3.115A7.054 7.054 0 0 1 4.91 12c0-1.027.218-2.018.609-2.918L1.493 5.967C.536 7.736 0 9.782 0 12c0 2.218.536 4.264 1.24 6.033z" fill="#34A853"></path></svg>
                                Google
                            </button>
</div>
<div class="mt-8 text-center">
<p class="text-[11px] font-medium uppercase tracking-[0.1em] text-[#adc6ff]/50">
                                Already a member? <a class="text-primary hover:text-primary-fixed-dim transition-colors" href="#">Sign in here →</a>
</p>
</div>
</div>
</div>
</section>
</div>
</main>
<!-- Footer (Mapped from JSON) -->
<footer class="w-full py-8 mt-auto bg-[#0c0e14] border-t border-[#adc6ff]/5">
<div class="flex flex-col md:flex-row justify-between items-center px-12 gap-6">
<div class="text-[11px] font-medium uppercase tracking-[0.1em] text-[#adc6ff]/50">
                © 2024 Spider Tech Ltd. Precision Engineered.
            </div>
<div class="flex flex-wrap justify-center gap-6">
<a class="text-[11px] font-medium uppercase tracking-[0.1em] text-[#adc6ff]/40 hover:text-[#adc6ff] transition-colors cursor-pointer" href="#">Privacy Policy</a>
<a class="text-[11px] font-medium uppercase tracking-[0.1em] text-[#adc6ff]/40 hover:text-[#adc6ff] transition-colors cursor-pointer" href="#">Terms of Service</a>
<a class="text-[11px] font-medium uppercase tracking-[0.1em] text-[#adc6ff]/40 hover:text-[#adc6ff] transition-colors cursor-pointer" href="#">Security Architecture</a>
<a class="text-[11px] font-medium uppercase tracking-[0.1em] text-[#adc6ff]/40 hover:text-[#adc6ff] transition-colors cursor-pointer" href="#">Contact Support</a>
</div>
</div>
</footer>
</body></html>