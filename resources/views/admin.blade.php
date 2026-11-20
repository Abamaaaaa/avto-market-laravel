<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Управление объявлениями — АвтоМаркет</title></head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background: #f1f5f9;">
    <x-header />
    <main style="max-width: 900px; margin: 30px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <h1 style="margin-top: 0;">{{ $u->role->name === 'admin' ? 'Панель Администратора' : 'Мои активные объявления' }}</h1>

        @if($u->role->name === 'admin')
            <h3 style="color: #0284c7;">Пользователи и права доступа</h3>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 35px; font-size: 0.95em;">
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th align="left" style="padding: 12px;">Логин</th>
                    <th align="left" style="padding: 12px;">Права</th>
                    <th align="left" style="padding: 12px;">Назначить роль</th>
                </tr>
                @foreach($users as $user)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px;"><b>{{ $user->login }}</b></td>
                        <td style="padding: 12px;">{{ $user->role->name }}</td>
                        <td style="padding: 12px;">
                            <form action="{{ route('user.role', ['id' => $user->id, 'u' => request()->query('u')]) }}" method="POST" style="display: flex; gap: 8px;">
                                @csrf
                                <select name="role_id" style="padding: 6px; border-radius: 4px; border: 1px solid #cbd5e1;">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" style="padding: 6px 12px; background: #0284c7; color: #fff; border: none; border-radius: 4px; cursor: pointer;">ОК</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif

        <h3 style="color: #0f172a;">{{ $u->role->name === 'admin' ? 'Все объявления на площадке' : 'Список ваших лотов' }}</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 0.95em;">
            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <th align="left" style="padding: 12px;">Товар / Авто</th>
                <th align="left" style="padding: 12px;">Категория</th>
                <th align="left" style="padding: 12px;">Продавец</th>
                <th align="center" style="padding: 12px;">Действие</th>
            </tr>
            @forelse($texts as $text)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 12px;"><b>{{ $text->heading }}</b></td>
                    <td style="padding: 12px;">{{ $text->category->name ?? '-' }}</td>
                    <td style="padding: 12px;">{{ $text->author->login ?? '-' }}</td>
                    <td align="center" style="padding: 12px;">
                        <form action="{{ route('text.delete', ['id' => $text->id, 'u' => request()->query('u')]) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" style="padding: 6px 12px; background: #fee2e2; color: #dc2626; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Снять с продажи</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" style="padding: 20px; text-align: center; color: #64748b;">Объявлений пока нет.</td></tr>
            @endforelse
        </table>
    </main>
    <x-footer />
</body>
</html>
