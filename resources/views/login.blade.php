<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Вход в систему</title></head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4;">
    <x-header />
    <main style="padding: 20px; max-width: 400px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h1>Вход</h1>
        @if($errors->any())
            <div style="padding: 10px; background: #f8d7da; color: #721c24; margin-bottom: 15px;">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('login') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            @csrf
            <label>Логин:<br><input type="text" name="login" style="width: 100%; padding: 8px; box-sizing: border-box;" required></label>
            <label>Пароль:<br><input type="password" name="password" style="width: 100%; padding: 8px; box-sizing: border-box;" required></label>
            <button type="submit" style="padding: 10px; background: #0275d8; color: white; border: none; border-radius: 4px; cursor: pointer;">Войти</button>
        </form>
        <p style="font-size: 0.85em; color: #666; margin-top: 20px;">
            Тестовые аккаунты (пароль везде <b>123456</b>):<br>
            Админ: <b>admin</b> | Журналист: <b>reporter</b> | Читатель: <b>reader</b>
        </p>
    </main>
    <x-footer />
</body>
</html>
