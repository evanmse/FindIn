# FindIN MVP - Quick Start Guide 🚀

## 5-Second Setup

### Option 1: PHP Built-in Server (Fastest)
```bash
cd /Users/s.sy/Documents/ISEP/APP\ INFO/FINDIN\ MVP/findin-mvp-main
php -S localhost:8000
```
Open: **http://localhost:8000** 

Done! ✅

---

## What You'll See

### Landing Page (/)
- Dark purple hero with FindIN branding
- Feature cards explaining the platform
- Stats showing company/user numbers
- Call-to-action buttons
- Mobile responsive with hamburger menu

### Login (/login)
- Email/password form
- Link to register
- Database-backed authentication
- Auto-creates test user if needed

### Registration (/register)
- User registration form
- Password hashing
- Email validation
- Redirects to login after signup

### Dashboard (/dashboard) [Protected]
- Welcome message with stats
- Your skills display
- Skill count metrics
- Mobile-friendly sidebar navigation

---

## Test Credentials

Use any email/password to test (auto-creates user on first login):

```
Email: test@findin.dev
Password: testpass123
```

Or create your own during registration!

---

## Features to Try

### 1. **Mobile Menu** (on tablets/phones)
- Tap the hamburger icon (☰) in top-right
- Slide menu appears from left
- Tap a link to navigate and close menu

### 2. **Dark/Light Theme Toggle**
- Click moon icon (🌙) in header
- Theme persists after refresh
- Check browser console: `localStorage.getItem('findin-theme')`

### 3. **Responsive Layout**
- Resize browser to < 768px
- Desktop nav changes to hamburger
- Cards stack vertically
- Content reflows automatically

### 4. **Authentication Flow**
1. Go to `/register` → create account
2. Redirects to `/login`
3. Login with credentials
4. Redirects to `/dashboard` (protected)
5. Click "Logout" to return to landing page

---

## File Locations

```
Project Root: /Users/s.sy/Documents/ISEP/APP INFO/FINDIN MVP/findin-mvp-main/

Key Files:
- index.php              → Router (all routes)
- assets/css/style.css  → All styling
- assets/js/main.js     → Interactivity
- views/index.php       → Landing page
- views/auth/login.php  → Login form
- views/auth/register.php → Registration
- views/dashboard/index.php → Dashboard
- views/layouts/header.php → Global header
- views/layouts/footer.php → Global footer
```

---

## Database Options

### SQLite (Default - No Setup Needed!)
```bash
# Just run the server, SQLite is auto-created
php -S localhost:8000
```

### MySQL with XAMPP
1. Start XAMPP (Apache + MySQL)
2. Import database:
   ```bash
   mysql -u root < create_database_simple.sql
   ```
3. Set environment variable:
   ```bash
   export DB_TYPE=mysql
   ```
4. Start server:
   ```bash
   php -S localhost:8000
   ```

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| "Port 8000 in use" | `lsof -i :8000` then `kill -9 PID` |
| "Views not found" | Ensure `cd` to project root before running server |
| "Stylesheet not loading" | Check browser console for 404 errors |
| "Mobile menu not opening" | Check browser DevTools (F12) for JS errors |
| "Always redirected to login" | Clear browser cookies/cache, SQLite DB may be corrupted |

---

## Useful Commands

```bash
# Kill PHP server
kill $(lsof -t -i :8000)

# Check if port 8000 is available
lsof -i :8000

# Validate PHP syntax
php -l index.php

# View SQLite database
sqlite3 data/findin.db ".tables"

# Check Git status
git status

# View recent commits
git log --oneline -5
```

---

## Browser DevTools Tips

### Check Theme Storage
Open browser console (F12) and run:
```javascript
localStorage.getItem('findin-theme')      // Should return "dark" or "light"
localStorage.setItem('findin-theme', 'light')  // Change theme
```

### Test Responsive Design
1. Press `F12` to open DevTools
2. Press `Ctrl+Shift+M` (or Cmd+Shift+M on Mac) for responsive view
3. Set width to `375px` (mobile)
4. Resize to `768px` (tablet)
5. Resize to `1200px+` (desktop)

### Check Network
- Open DevTools → Network tab
- Refresh page
- Look for red 404 errors
- Check CSS/JS loading

---

## Next Steps

✅ **Landing page** is complete  
✅ **Authentication** works  
✅ **Dashboard** ready  

🚀 **To build features:**

1. **Add Skill Management**
   - Create `views/dashboard/skills.php`
   - Add form to create/edit skills
   - Store in database

2. **Create Search**
   - Build search form on landing
   - Query skills by keyword
   - Display matching users

3. **Add Admin Panel**
   - Create `views/admin/` views
   - Check user role before showing
   - Manage users/skills/departments

---

## Contact & Support

This is a development version. For production:
1. Set up proper error logging
2. Add CSRF protection
3. Implement rate limiting
4. Set secure headers
5. Use environment files (.env)

---

## Happy Coding! 🎉

The platform is ready to use and extend. Start with the landing page, test the auth flow, then build features on the dashboard!

Questions? Check `IMPLEMENTATION_COMPLETE.md` for detailed documentation.
