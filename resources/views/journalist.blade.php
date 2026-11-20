<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Подать объявление — АвтоМаркет</title></head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background: #f1f5f9;">
    <x-header />
    <main style="max-width: 550px; margin: 35px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <h1 style="margin-top: 0; color: #0f172a;">Новое объявление</h1>
        <form action="{{ route('text.store', ['u' => request()->query('u')]) }}" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
            @csrf
            <label style="font-weight: 600; font-size: 0.9em;">Название товара или авто:<br>
                <input type="text" name="heading" placeholder="Например: ВАЗ 2114, 2012 г. или Комплект дисков R14" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; margin-top: 5px;" required>
            </label>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <label style="font-weight: 600; font-size: 0.9em;">Категория:<br>
                    <select name="categorie_id" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; margin-top: 5px;">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label style="font-weight: 600; font-size: 0.9em;">Цена (в рублях):<br>
                    <input type="number" name="price" placeholder="150000" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; margin-top: 5px;" required>
                </label>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <label style="font-weight: 600; font-size: 0.9em;">Город:<br>
                    <input type="text" name="city" placeholder="Ульяновск" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; margin-top: 5px;" required>
                </label>

                <label style="font-weight: 600; font-size: 0.9em;">Телефон для связи:<br>
                    <input type="text" name="phone" placeholder="+7 (999) 000-00-00" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; margin-top: 5px;" required>
                </label>
            </div>

            <label style="font-weight: 600; font-size: 0.9em;">Подробное описание (состояние, пробег, торг):<br>
                <textarea name="text" rows="5" placeholder="Опишите все детали..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; margin-top: 5px;" required></textarea>
            </label>

            <button type="submit" style="padding: 12px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: bold; font-size: 1em; cursor: pointer;">Опубликовать объявление</button>
        </form>
    </main>
    <x-footer />
</body>
</html>
