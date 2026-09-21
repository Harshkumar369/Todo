# To-Do Diary App with Login (PHP + MySQL + HTML + CSS + JS)

## Setup Steps (Fresh Install)

1. **XAMPP install karo** (agar nahi hai): https://www.apachefriends.org
2. XAMPP Control Panel me **Apache** aur **MySQL** start karo.
3. Is puri `todo-app` folder ko copy karke yahan paste karo:
   - Windows: `C:\xampp\htdocs\todo-app`
   - Mac: `/Applications/XAMPP/htdocs/todo-app`
4. Browser me kholo: `http://localhost/phpmyadmin`
5. `database.sql` file ka code copy karke phpMyAdmin ke **SQL tab** me run karo
   (ya "Import" option se `database.sql` file directly import kar do).
6. Ab browser me kholo: `http://localhost/todo-app/register.php`
7. Apna account bana lo (naam, email, password) — automatically login ho jaoge.

## Agar Pehle Se App Chala Rahe Ho (Purana Database Hai)

Agar tumne pehle se `todo_db` bana rakha hai (login system ke bina), to `database.sql`
dobara mat chalana — iski jagah `migration.sql` file phpMyAdmin ke SQL tab me chalao.
Ye purane tasks table me users table aur user_id column add kar dega.

## Project Files
- `database.sql` → Fresh install ke liye database + tables (users + tasks)
- `migration.sql` → Purane database ko upgrade karne ke liye (login add karne ke liye)
- `config.php` → Database connection + session start
- `register.php` → Naya account banane ka page (signup)
- `login.php` → Login page
- `logout.php` → Logout script
- `index.php` → Main page (sidebar + task list shell) — login check karta hai
- `get_tasks.php` → Sirf logged-in user ke tasks fetch karta hai (filter ke hisaab se)
- `add_task.php` → Naya task add karta hai (logged-in user ke naam se)
- `update_status.php` → Task complete/pending toggle karta hai (sirf apna task)
- `edit_task.php` → Existing task edit/maintain karta hai (sirf apna task)
- `delete_task.php` → Task delete karta hai (sirf apna task)
- `style.css` → Diary-style design + login/signup page styling
- `script.js` → Frontend logic — filter tabs, progress grid, edit, add, delete

## Features
- ✅ **Login / Signup system** — har user ka apna alag account aur private task list
- ✅ Passwords securely hashed (`password_hash`) — plain text me kabhi save nahi hote
- ✅ Left sidebar: Today / This Week / This Month / This Year filter tabs
- ✅ Progress grid — har task ke liye ek chhota box, complete hone par red fill ho jata hai
- ✅ Right side top par naya task create karne ka option
- ✅ Diary-line style task list with animated checkbox (✓ draw animation)
- ✅ Task edit/maintain karne ka option (✎ icon click karke)
- ✅ Task delete karne ka option
- ✅ Har user sirf apne khud ke tasks dekh/edit/delete kar sakta hai
- ✅ Sab kuch AJAX se kaam karta hai (page reload nahi hota)

## Link Share Karne Ke Baad
Jab is app ko online host karoge (hosting guide pehle discuss ki thi), to jisko bhi link
doge, wo `register.php` se apna khud ka account bana lega aur apna private to-do list
use kar payega. Ek user doosre ka data nahi dekh sakta.

## Resume ke liye points
- Built a full-stack To-Do Diary app with user authentication (signup/login/logout) using PHP sessions
- Implemented secure password hashing (`password_hash`/`password_verify`) and per-user data isolation
- Designed CRUD (Create, Read, Update, Delete) functionality with MySQLi prepared statements to prevent SQL injection
- Used AJAX (JavaScript Fetch API) for real-time updates without page reload
- Built time-based filtering (day/week/month/year) with a custom progress-tracking UI


