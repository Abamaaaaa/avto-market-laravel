@php
    $uid = request()->query('u');
    $u = $uid ? \App\Models\User::with('role')->find($uid) : null;
    $q = $u ? ['u' => $u->id] : [];
@endphp

<header style="background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%); color: #fff; padding: 16px 30px; display: flex; justify-content: space-between; align-items: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
    <div style="display: flex; align-items: center; gap: 25px;">
        <a href="{{ route('home', $q) }}" style="color: #38bdf8; text-decoration: none; font-size: 1.4em; font-weight: 800; letter-spacing: 0.5px;">
            ⚡ АВТО<span style="color: #fff;">МАРКЕТ</span>
        </a>
        <nav style="display: flex; gap: 15px; flex-wrap: wrap;">
            @foreach(\App\Models\Category::where('id', '!=', 6)->get() as $cat)
                <a href="{{ route('category', array_merge(['id' => $cat->id], $q)) }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.95em;">{{ $cat->name }}</a>
            @endforeach
        </nav>
    </div>

    <div style="display: flex; align-items: center; gap: 12px;">
        @if($u)
            <a href="{{ route('calendar', $q) }}" style="background: #8b5cf6; color: #fff; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.95em;">
                📅 Календарь ТО
            </a>
            <a href="{{ route('journalist', $q) }}" style="background: #10b981; color: #fff; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.95em;">
                + Объявление
            </a>
            <a href="{{ route('admin', $q) }}" style="background: #334155; color: #f8fafc; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-size: 0.95em;">
                {{ $u->role->name === 'admin' ? '👑 Админка' : '👤 Лоты (' . $u->login . ')' }}
            </a>
            <a href="{{ route('home') }}" style="color: #f87171; text-decoration: none; font-size: 0.9em; margin-left: 5px;">Выйти</a>
        @else
            <a href="{{ route('login') }}" style="color: #38bdf8; text-decoration: none; font-weight: 600;">Войти</a>
            <a href="{{ route('register') }}" style="background: #0284c7; color: #fff; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600;">Регистрация</a>
        @endif
    </div>
</header>
