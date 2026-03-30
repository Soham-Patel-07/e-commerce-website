# How to Upload Project to GitHub

Follow these step-by-step instructions to upload your Laravel e-commerce project to GitHub.

---

## Prerequisites

1. **Git installed** - Download from https://git-scm.com
2. **GitHub account** - Create at https://github.com

---

## Step 1: Install Git (if not installed)

Download and install Git from: https://git-scm.com

---

## Step 2: Configure Git

Open terminal/command prompt and configure your name and email:

```bash
git config --global user.name "Your Name"
git config --global user.email "your@email.com"
```

---

## Step 3: Create GitHub Repository

1. Go to https://github.com
2. Login to your account
3. Click the **+** icon (top right) → **New repository**
4. Fill in details:
   - **Repository name:** `ecommerce` (or your preferred name)
   - **Description:** Multi-vendor e-commerce platform with Laravel
   - **Public** or **Private** (choose)
   - ✅ **DO NOT** check "Add a README file"
   - ✅ **DO NOT** check "Add .gitignore"
5. Click **Create repository**
6. **Important:** Copy the repository URL - it will look like:
   ```
   https://github.com/yourusername/ecommerce.git
   ```

---

## Step 4: Prepare Your Project

Before uploading, clean up unnecessary files:

```bash
cd C:\xampp\htdocs\ecom
```

### Create .gitignore File

Create or update `.gitignore` in project root to exclude:

```
/vendor/
/node_modules/
/.env
/.env.backup
/.phpunit.result.cache
/storage/*.key
.DS_Store
Thumbs.db
```

---

## Step 5: Initialize Git Repository

```bash
cd C:\xampp\htdocs\ecom
git init
```

---

## Step 6: Add Files to Git

Add all files to staging:

```bash
git add .
```

---

## Step 7: First Commit

Create your first commit:

```bash
git commit -m "Initial commit - Multi-vendor E-commerce Platform with Laravel"
```

---

## Step 8: Connect to GitHub

Replace `yourusername` and `ecommerce` with your actual GitHub username and repo name:

```bash
git remote add origin https://github.com/yourusername/ecommerce.git
```

---

## Step 9: Push to GitHub

Upload your code to GitHub:

```bash
git push -u origin master
```

Or if using main branch:

```bash
git push -u origin main
```

---

## Step 10: Verify Upload

1. Go to your GitHub repository URL
2. Refresh the page
3. You should see all your files uploaded

---

## Important Notes

### What to Upload
✅ Controllers, Models, Views, Routes, Migrations, Seeders

### What NOT to Upload (in .gitignore)
- `/vendor/` - Composer dependencies (can reinstall)
- `/node_modules/` - NPM packages
- `.env` - Contains database credentials
- `storage/app/public/` - Uploaded files

### After Cloning on Another Computer

If someone clones your repo, they need to run:

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate --seed

# Create storage link
php artisan storage:link
```

---

## Troubleshooting

### Error: Permission Denied
Make sure you have push access to the repository

### Error: Remote Already Exists
```bash
git remote remove origin
git remote add origin https://github.com/yourusername/ecommerce.git
```

### Push Rejected
If you made changes on GitHub directly, pull first:
```bash
git pull origin master --allow-unrelated-histories
git push origin master
```

---

## Summary of Commands

```bash
# 1. Initialize
cd C:\xampp\htdocs\ecom
git init

# 2. Add files
git add .

# 3. Commit
git commit -m "Your message"

# 4. Connect (one time)
git remote add origin https://github.com/YOUR_USERNAME/ecommerce.git

# 5. Push
git push -u origin master
```

---

**Done! Your project is now on GitHub!**
