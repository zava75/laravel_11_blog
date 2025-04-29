<h2>Laravel 11 Blog - Docker Stack Overview</h2>
<p>This project uses a Docker-based development environment with the following services:</p>

<ul>
  <li><strong>PHP-FPM</strong> - PHP 8.4.x with Xdebug configured for local development (<code>php-fpm</code> container).</li>
  <li><strong>Nginx</strong> - Web server to serve the Laravel application (<code>nginx</code> container).</li>
  <li><strong>MySQL 8</strong> - Database server for the Laravel backend (<code>mysql</code> container).</li>
  <li><strong>phpMyAdmin</strong> - Web interface for managing MySQL databases (<code>phpmyadmin</code> container).</li>
  <li><strong>Redis</strong> - In-memory data store used for caching (<code>redis</code> container).</li>
</ul>

<p><strong>Notes:</strong></p>
<ul>
  <li>Docker Compose version: <code>3.8</code></li>
  <li>Application code is mounted from <code>./src</code> to <code>/var/www/html</code> inside the containers.</li>
  <li>MySQL is exposed on port <code>6666</code>, phpMyAdmin on <code>9090</code>.</li>
  <li>Nginx serves the application on <code>http://localhost</code>.</li>
  <li>Redis is available on the default port <code>6379</code>.</li>
</ul>

<hr>

<h2>1) Mailtrap Setup for Email Testing</h2>
<ul>
  <li>Sign up at <a href="https://mailtrap.io" target="_blank">Mailtrap.io</a> and create a free account.</li>
  <li>Create a new Inbox.</li>
  <li>Configure Laravel by adding the following to your <code>.env</code> file for Mailtrap:</li>
</ul>

<pre><code>MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=example@yourapp.com
MAIL_FROM_NAME="${APP_NAME}"
</code></pre>

<p>Replace <code>MAIL_USERNAME</code> and <code>MAIL_PASSWORD</code> with your Mailtrap credentials. All emails sent from Laravel will appear in your Mailtrap inbox.</p>

<h3>Alternatively: Configure SMTP for Gmail</h3>

<ul>
  <li>To send real emails via Gmail, update your <code>.env</code> file with the following:</li>
</ul>

<pre><code>MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_email_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
</code></pre>

<p><strong>Important:</strong> For Gmail:</p>
<ul>
  <li>Enable "Less secure app access" in your Google account settings (or create an App Password if you have 2FA enabled).</li>
  <li>Use the App Password instead of your actual Gmail password for better security.</li>
</ul>

<hr>

<h2>2) Start Docker</h2>
<p>Run the following command from your project root:</p>

<pre><code>docker compose up --build
</code></pre>

<p>This will build and start all containers in detached mode.</p>

<hr>

<h2>3) MySQL Container Setup for Laravel Blog</h2>

<ul>
  <li><strong>a) Access MySQL Container:</strong></li>
</ul>
<pre><code>docker exec -it mysql bash
</code></pre>

<ul>
  <li><strong>b) Log into MySQL:</strong></li>
</ul>
<pre><code>mysql -u root -p
</code></pre>
<p>Enter the root password (default: <code>root</code>).</p>

<ul>
  <li><strong>c) Create Database and User:</strong></li>
</ul>
<pre><code>
CREATE DATABASE laravel_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
</code></pre>
<pre><code>
CREATE USER 'laravel_blog'@'%' IDENTIFIED WITH caching_sha2_password BY 'laravel_blog';
</code></pre>
<pre><code>
GRANT ALL PRIVILEGES ON laravel_blog.* TO 'laravel_blog'@'%';
</code></pre>
<pre><code>
FLUSH PRIVILEGES;
</code></pre>

<ul>
  <li><strong>d) Exit MySQL:</strong></li>
</ul>
<pre><code>exit
</code></pre>

<ul>
  <li><strong>c) Exit container MySQL:</strong></li>
</ul>
<pre><code>exit
</code></pre>

<p>This setup will ensure your MySQL container is ready for your Laravel application.</p>

<hr>

<h2>4) Running Laravel Application with Docker (PHP-FPM)</h2>

<ul>
  <li><strong>Enter the PHP-FPM container:</strong></li>
</ul>
<pre><code>docker exec -it php-fpm bash
</code></pre>

<ul>
  <li><strong>Install dependencies:</strong></li>
</ul>
<pre><code>composer install
</code></pre>

<ul>
  <li><strong>Then run:</strong></li>
</ul>
<pre><code>php artisan project:start
</code></pre>

<ul>
  <li><strong>To fully refresh (reset migrations, seed database, clear caches):</strong></li>
</ul>
<pre><code>php artisan project:start --refresh
</code></pre>

<h2>5) Admin & User Panel Login</h2>

<p>After successfully starting the Laravel application, you can access the admin dashboard:</p>

<ul>
  <li><strong>Login URL:</strong> <code>http://localhost/login</code></li>
  <li><strong>Admin URL:</strong> <code>http://localhost/admin</code></li>
  <li><strong>Dashboard URL:</strong> <code>http://localhost/dashboard</code></li>
  <li><strong>Email:</strong> <code>admin-laravel-blog@gmail.com</code></li>
  <li><strong>Password:</strong> <code>admin-laravel-blog</code></li>
</ul>

<h2>6) Queue Troubleshooting for Posts and Comments</h2>
<p>If queues do not work when submitting posts or comments, open a new terminal window and run the following:</p>

<ol>
  <li><strong>Enter the PHP-FPM container:</strong></li>
</ol>
<pre><code>docker exec -it php-fpm bash</code></pre>

<ol start="2">
  <li><strong>Start the queue worker manually:</strong></li>
</ol>
<pre><code>php artisan queue:work</code></pre>

<p>This will start processing any pending jobs related to posts and comments.</p>

<p><strong>Note:</strong> On a production server, you must configure <code>Supervisor</code> to ensure the queue worker runs continuously in the background.</p>

