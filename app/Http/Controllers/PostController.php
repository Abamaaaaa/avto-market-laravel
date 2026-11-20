<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Text;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    private function getUser(Request $request) {
        $id = $request->query('u') ?? $request->input('u');
        return $id ? User::with('role')->find($id) : null;
    }

    // Главная: витрина объявлений + ПОИСК
       public function index(Request $request) {
        $search = $request->query('search');
        $query = Text::where('categorie_id', '!=', 6)->with(['category', 'author'])->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('heading', 'ILIKE', "%{$search}%")
                  ->orWhere('text', 'ILIKE', "%{$search}%");
            });
        }

        $texts = $query->get();
        $u = $this->getUser($request);
        return view('index', compact('texts', 'u', 'search'));
    }


    // Фильтр по категориям товаров
    public function category(Request $request, $id) {
        $category = Category::findOrFail($id);
        $texts = Text::where('categorie_id', $id)->with('author')->latest()->get();
        $u = $this->getUser($request);
        return view('category', compact('category', 'texts', 'u'));
    }

    // Вход
    public function loginView(Request $request) {
        $u = $this->getUser($request);
        return view('login', compact('u'));
    }

    public function login(Request $request) {
        $user = User::where('login', $request->input('login'))->first();
        if ($user && Hash::check($request->input('password'), $user->password)) {
            return redirect()->route('home', ['u' => $user->id]);
        }
        return back()->withErrors(['login' => 'Неверный логин или пароль.']);
    }

    // Регистрация: теперь сразу выдаем роль продавца (role_id = 2)
    public function registerView(Request $request) {
        $u = $this->getUser($request);
        return view('register', compact('u'));
    }

    public function register(Request $request) {
        $request->validate([
            'login' => 'required|unique:users,login|min:3',
            'password' => 'required|min:4'
        ]);
        
        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'role_id' => 2 // Сразу даем права подавать объявления
        ]);
        return redirect()->route('home', ['u' => $user->id]);
    }

    public function logout() {
        return redirect()->route('home');
    }

    // Форма подачи объявления
    public function journalistView(Request $request) {
        $u = $this->getUser($request);
        if (!$u) {
            return redirect()->route('login');
        }
        $categories = Category::all();
        return view('journalist', compact('categories', 'u'));
    }

    // Сохранение объявления (упаковываем цену, город и телефон в описание)
    public function storeText(Request $request) {
        $u = $this->getUser($request);
        if (!$u) abort(403);

        $request->validate([
            'heading' => 'required|max:255',
            'price' => 'required|numeric',
            'phone' => 'required|max:30',
            'city' => 'required|max:50',
            'text' => 'required',
            'categorie_id' => 'required'
        ]);

        // Формируем структурированную карточку товара в поле text
        $fullDescription = "💰 Цена: " . number_format($request->price, 0, '', ' ') . " ₽\n"
                         . "📍 Город: " . $request->city . "\n"
                         . "📞 Телефон: " . $request->phone . "\n"
                         . "────────────────────\n"
                         . $request->text;

        Text::create([
            'heading' => $request->heading,
            'text' => $fullDescription,
            'categorie_id' => $request->categorie_id,
            'user_id' => $u->id,
        ]);

        return redirect()->route('home', ['u' => $u->id]);
    }

    // Личный кабинет / Админка (Продавец видит свои лоты, Админ видит все)
    public function adminView(Request $request) {
        $u = $this->getUser($request);
        if (!$u) return redirect()->route('login');

        if ($u->role->name === 'admin') {
            $texts = Text::with('author', 'category')->latest()->get();
            $users = User::with('role')->orderBy('id')->get();
            $roles = Role::all();
        } else {
            // Обычный продавец видит только СВОИ объявления
            $texts = Text::where('user_id', $u->id)->with('author', 'category')->latest()->get();
            $users = collect();
            $roles = collect();
        }

        return view('admin', compact('texts', 'users', 'roles', 'u'));
    }

    // Удаление объявления (разрешено админу ИЛИ владельцу объявления)
    public function deleteText(Request $request, $id) {
        $u = $this->getUser($request);
        if (!$u) abort(403);

        $text = Text::findOrFail($id);
        if ($u->role->name === 'admin' || $text->user_id === $u->id) {
            $text->delete();
        } else {
            abort(403, 'Вы не можете удалить чужое объявление');
        }

        return redirect()->route('admin', ['u' => $u->id]);
    }

    // Смена ролей (только админ)
    public function changeRole(Request $request, $userId) {
        $u = $this->getUser($request);
        if (!$u || $u->role->name !== 'admin') abort(403);

        $user = User::findOrFail($userId);
        $user->role_id = $request->role_id;
        $user->save();
        return redirect()->route('admin', ['u' => $u->id]);
    }
    // Страница Календаря ТО
    public function calendarView(Request $request) {
        $u = $this->getUser($request);
        if (!$u) return redirect()->route('login');

        // Берем записи только из 6-й категории (Календарь ТО) для текущего пользователя
        $records = Text::where('categorie_id', 6)
                       ->where('user_id', $u->id)
                       ->latest()
                       ->get();

        return view('calendar', compact('records', 'u'));
    }

    // Сохранение новой даты в Календарь ТО
    public function storeCalendar(Request $request) {
        $u = $this->getUser($request);
        if (!$u) abort(403);

        $request->validate([
            'work_type' => 'required|max:255',
            'service_date' => 'required|date',
            'mileage' => 'required|numeric',
            'interval' => 'required|numeric',
        ]);

        // Считаем пробег следующей замены
        $nextMileage = $request->mileage + $request->interval;
        // Форматируем дату из ГГГГ-ММ-ДД в ДД.ММ.ГГГГ
        $formattedDate = date('d.m.Y', strtotime($request->service_date));

        $details = "📅 Дата проведения: " . $formattedDate . "\n"
                 . "🛣 Пробег на момент работ: " . number_format($request->mileage, 0, '', ' ') . " км\n"
                 . "🔔 Следующая замена через " . number_format($request->interval, 0, '', ' ') . " км ➔ на пробеге " . number_format($nextMileage, 0, '', ' ') . " км\n"
                 . ($request->note ? "📝 Заметка: " . $request->note : "");

        Text::create([
            'heading' => $request->work_type,
            'text' => $details,
            'categorie_id' => 6,
            'user_id' => $u->id,
        ]);

        return redirect()->route('calendar', ['u' => $u->id]);
    }
}
