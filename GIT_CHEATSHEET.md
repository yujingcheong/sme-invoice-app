# Git Cheatsheet for Laravel Beginners

Quick reference for the most common git commands you'll use while working on this project.

---

## Basic Workflow

### 1. Check what changed
```bash
git status
```
Shows which files you've modified, created, or deleted.

### 2. Stage your changes
```bash
# Stage a specific file
git add path/to/file.php

# Stage all changes
git add .
```

### 3. Commit your changes
```bash
git commit -m "Brief description of what you changed"
```

Good commit messages:
- ✅ "Add customer phone validation"
- ✅ "Fix invoice total calculation bug"
- ❌ "Fixed stuff" (too vague)
- ❌ "WIP" (meaningless)

### 4. Push to remote
```bash
git push
```

**IMPORTANT**: When you push to the `main` branch on GitHub, Render will automatically deploy the new version. Allow 2-3 minutes for deployment to complete.

---

## Viewing History

### See recent commits
```bash
git log --oneline
```

### See what changed in a specific file
```bash
git log -p path/to/file.php
```

### See who changed a line
```bash
git blame path/to/file.php
```

---

## Undoing Mistakes

### Discard changes to a file (before staging)
```bash
git checkout -- path/to/file.php
```
**CAUTION**: This permanently deletes your unsaved changes!

### Unstage a file (but keep changes)
```bash
git reset HEAD path/to/file.php
```

### Undo last commit (but keep changes)
```bash
git reset HEAD~1
```

### Undo last commit AND discard changes
```bash
git reset --hard HEAD~1
```
**CAUTION**: This permanently deletes the commit AND your changes!

---

## Branches (Optional)

If you want to experiment without affecting the main code:

### Create and switch to a new branch
```bash
git checkout -b feature-name
```

### Switch back to main
```bash
git checkout main
```

### Merge branch into main
```bash
git checkout main
git merge feature-name
```

---

## Common Scenarios

### "I made a typo in my last commit message"
```bash
git commit --amend -m "Corrected commit message"
```

### "I accidentally committed a secret (.env file)"
```bash
# Remove from git but keep locally
git rm --cached .env
git commit -m "Remove .env from git"

# Make sure .env is in .gitignore
echo ".env" >> .gitignore
git add .gitignore
git commit -m "Add .env to gitignore"
```

### "I want to see what changed before committing"
```bash
git diff
```

### "My push was rejected"
This usually means someone else pushed changes. Pull their changes first:
```bash
git pull
# Resolve any conflicts if needed
git push
```

---

## Deployment via Render

**How it works:**
1. You push code to GitHub: `git push`
2. Render detects the push automatically
3. Render builds and deploys the new version
4. Your site updates in ~2-3 minutes

**To check deployment status:**
- Go to Render dashboard: https://dashboard.render.com
- Click your service → "Events" tab
- Look for "Deploy succeeded" or check error logs

**Cold starts:** If nobody visited your site in 15+ minutes, the first request after deploy may take 30-60 seconds (free tier limitation).

---

## Tips

1. **Commit often** — Small, frequent commits are better than large, infrequent ones
2. **Pull before you push** — Especially if working with others
3. **Don't commit .env** — It's already in .gitignore, keep it that way
4. **Test locally first** — Run `php artisan migrate` and `php artisan serve` to verify changes work before pushing

---

## Need Help?

- Git Basics: https://rogerdudler.github.io/git-guide/
- GitHub Guides: https://guides.github.com/
- Render Docs: https://render.com/docs

Remember: Git mistakes are almost always fixable. Don't panic!
