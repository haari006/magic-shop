InfinityFree deployment checklist

1) Create account and site
- Sign up at https://infinityfree.net/.
- Create a new site (free subdomain is fine).
- Account if0_40775033
- 3NyuPaxd2dY
- if0_40775033_user	if0_40775033`

2) Create MySQL database
- In the InfinityFree control panel, open "MySQL Databases".
- Create a new database and user.
- Note the DB host, name, username, and password.

3) Upload project
- Use FileZilla (or the File Manager) with the FTP credentials from InfinityFree.
- Upload all files in this project to the site's `htdocs` directory.
- Do not upload `config.local.example.php` as-is.

4) Configure secrets
- Create a file named `config.local.php` in the site root (same folder as `config.php`).
- Use `config.local.example.php` as the template and fill in:
  - `$host`, `$user`, `$pass`, `$db` from InfinityFree
  - `$stripe_secret_key` and `$stripe_webhook_secret` from Stripe

5) Create database tables
- Open phpMyAdmin from the InfinityFree control panel.
- Create the `users` and `orders` tables using the SQL in `readme.txt`.

6) Stripe webhook
- In Stripe (test mode), add a webhook endpoint:
  - URL: `https://YOUR_SUBDOMAIN.infinityfreeapp.com/stripe_webhook.php`
  - Event: `checkout.session.completed`
- Copy the signing secret into `config.local.php`.

Notes
- InfinityFree does not support environment variables on the free plan, so use `config.local.php`.
- If Stripe calls fail, confirm that cURL is enabled in the hosting environment.
