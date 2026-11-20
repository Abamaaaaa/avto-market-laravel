<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>{{ $category->name }} — АвтоМаркет</title></head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background: #f1f5f9;">
    <x-header />
    <main style="max-width: 1050px; margin: 30px auto; padding: 0 20px;">
        <h1 style="color: #0f172a;">Раздел: {{ $category->name }}</h1>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(310px, 1fr)); gap: 20px;">
            @forelse($texts as $text)
                <div style="background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.07); border: 1px solid #e2e8f0;">
                    <h3 style="margin: 0 0 12px 0; color: #0f172a;">{{ $text->heading }}</h3>
                    <div style="background: #f8fafc; padding: 12px; border-radius: 8px; font-size: 0.95em; line-height: 1.5; white-space: pre-line;">{{ $text->text }}</div>
                    <p style="margin: 12px 0 0 0; font-size: 0.85em; color: #64748b;">Продавец: <b>{{ $text->author->login ?? 'Частник' }}</b></p>
                </div>
            @empty
                <p style="color: #64748b;">В этом разделе пока нет объявлений.</p>
            @endforelse
        </div>
    </main>
    <x-footer />
</body>
</html>
