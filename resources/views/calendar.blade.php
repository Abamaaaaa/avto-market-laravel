<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Сервисный Календарь ТО — АвтоМаркет</title></head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background: #f1f5f9; color: #1e293b;">
    <x-header />

    <main style="max-width: 950px; margin: 30px auto; padding: 0 20px; display: grid; grid-template-columns: 350px 1fr; gap: 25px; align-items: start;">
        
        <!-- Левая колонка: Форма добавления даты -->
        <div style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-top: 4px solid #8b5cf6;">
            <h2 style="margin-top: 0; font-size: 1.3em; color: #0f172a;">📅 Новая отметка в календаре</h2>
            <form action="{{ route('calendar.store', ['u' => request()->query('u')]) }}" method="POST" style="display: flex; flex-direction: column; gap: 14px;">
                @csrf
                <label style="font-weight: 600; font-size: 0.9em;">Что меняли / обслуживали:<br>
                    <input type="text" name="work_type" placeholder="Например: Замена масла в двигателе" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; margin-top: 5px;" required>
                </label>

                <label style="font-weight: 600; font-size: 0.9em;">Выберите дату в календаре:<br>
                    <input type="date" name="service_date" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; margin-top: 5px; font-family: inherit;" required>
                </label>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <label style="font-weight: 600; font-size: 0.85em;">Текущий пробег (км):<br>
                        <input type="number" name="mileage" placeholder="125000" style="width: 100%; padding: 9px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; margin-top: 5px;" required>
                    </label>

                    <label style="font-weight: 600; font-size: 0.85em;">Через сколько менять:<br>
                        <select name="interval" style="width: 100%; padding: 9px; border: 1px solid #cbd5e1; border-radius: 6px; margin-top: 5px;">
                            <option value="7000">Через 7 000 км</option>
                            <option value="8000" selected>Через 8 000 км</option>
                            <option value="10000">Через 10 000 км</option>
                            <option value="15000">Через 15 000 км</option>
                            <option value="50000">Через 50 000 км (ГРМ)</option>
                        </select>
                    </label>
                </div>

                <label style="font-weight: 600; font-size: 0.9em;">Заметка (марка масла, артикул):<br>
                    <input type="text" name="note" placeholder="Лукойл Генезис 5W-40, фильтр Mann" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; margin-top: 5px;">
                </label>

                <button type="submit" style="padding: 12px; background: #8b5cf6; color: white; border: none; border-radius: 6px; font-weight: bold; font-size: 1em; cursor: pointer; margin-top: 5px;">
                    Сохранить в календарь
                </button>
            </form>
        </div>

        <!-- Правая колонка: Сервисная книжка пользователя -->
        <div style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            <h2 style="margin-top: 0; font-size: 1.4em; color: #0f172a;">История обслуживания ({{ $u->login }})</h2>
            
            @forelse($records as $rec)
                <div style="border-left: 4px solid #8b5cf6; background: #f8fafc; padding: 16px; border-radius: 0 8px 8px 0; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: start; gap: 15px;">
                    <div>
                        <h3 style="margin: 0 0 8px 0; color: #0f172a;">{{ $rec->heading }}</h3>
                        <div style="font-size: 0.95em; line-height: 1.6; color: #334155; white-space: pre-line;">{{ $rec->text }}</div>
                    </div>
                    <form action="{{ route('text.delete', ['id' => $rec->id, 'u' => request()->query('u')]) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" title="Удалить запись" style="background: #fee2e2; color: #dc2626; border: none; padding: 6px 10px; border-radius: 6px; cursor: pointer; font-weight: bold;">✕</button>
                    </form>
                </div>
            @empty
                <div style="text-align: center; padding: 40px 20px; color: #64748b; background: #f8fafc; border-radius: 8px;">
                    <p style="font-size: 1.1em; margin: 0 0 8px 0;">Сервисная книжка пока пуста</p>
                    <p style="font-size: 0.9em; margin: 0;">Выберите дату в календаре слева и запишите последнюю замену масла или расходников.</p>
                </div>
            @endforelse
        </div>

    </main>
    <x-footer />
</body>
</html>
