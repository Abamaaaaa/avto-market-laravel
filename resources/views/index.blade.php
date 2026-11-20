<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>АвтоМаркет — Доска объявлений</title></head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background: #f1f5f9; color: #1e293b;">
    <x-header />

    <!-- Блок поиска -->
    <div style="background: #1e293b; padding: 30px 20px; text-align: center; border-bottom: 1px solid #334155;">
        <h1 style="color: #fff; margin: 0 0 15px 0; font-size: 1.8em;">Поиск автомобилей и запчастей</h1>
        <form action="{{ route('home') }}" method="GET" style="max-width: 650px; margin: 0 auto; display: flex; gap: 10px;">
            @if(request()->query('u'))
                <input type="hidden" name="u" value="{{ request()->query('u') }}">
            @endif
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Например: ВАЗ 2114, генератор, зимняя резина..." style="flex: 1; padding: 12px 16px; border-radius: 8px; border: none; font-size: 1em; outline: none;">
            <button type="submit" style="padding: 12px 24px; background: #0284c7; color: #fff; border: none; border-radius: 8px; font-weight: bold; font-size: 1em; cursor: pointer;">Найти</button>
            @if(!empty($search))
                <a href="{{ route('home', request()->query('u') ? ['u' => request()->query('u')] : []) }}" style="padding: 12px 16px; background: #475569; color: #fff; text-decoration: none; border-radius: 8px; display: flex; align-items: center;">Сбросить</a>
            @endif
        </form>
    </div>

    <!-- Сетка объявлений -->
    <main style="max-width: 1050px; margin: 30px auto; padding: 0 20px;">
        <h2 style="margin-bottom: 20px; color: #0f172a;">
            {{ !empty($search) ? "Результаты поиска по запросу «{$search}»:" : 'Свежие объявления' }}
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(310px, 1fr)); gap: 20px;">
            @forelse($texts as $text)
                <div style="background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.07); border: 1px solid #e2e8f0; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <span style="display: inline-block; background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-size: 0.8em; font-weight: 600; margin-bottom: 10px;">
                            {{ $text->category->name ?? 'Запчасти' }}
                        </span>
                        <h3 style="margin: 0 0 12px 0; font-size: 1.25em; color: #0f172a;">{{ $text->heading }}</h3>
                        <div style="background: #f8fafc; padding: 12px; border-radius: 8px; font-size: 0.95em; line-height: 1.5; color: #334155; white-space: pre-line; border: 1px solid #f1f5f9;">{{ $text->text }}</div>
                    </div>
                    
                    <div style="margin-top: 15px; padding-top: 12px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; font-size: 0.85em; color: #64748b;">
                        <span>Продавец: <b>{{ $text->author->login ?? 'Частник' }}</b></span>
                        <span>{{ $text->created_at ? $text->created_at->format('d.m.Y') : 'Сегодня' }}</span>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; background: #fff; padding: 40px; text-align: center; border-radius: 12px; color: #64748b;">
                    <h3>Объявлений пока нет</h3>
                    <p>Зарегистрируйтесь или войдите на сайт, чтобы выставить свой автомобиль или запчасти на продажу!</p>
                </div>
            @endforelse
        </div>
    </main>
    <x-footer />
</body>
</html>
