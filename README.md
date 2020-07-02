# MVC-Simple
Based on the ideas of the others packages such as Laravel, Yii, Symfony, but highly simplified. Covers only basic things that mvc could provide.

# Ideas which will/already implemented
- ORM: 97%
- Admin-panel:
    - Register specific model to the admin.php, it will be displayed on the admin-panel
    - (At least at the beginning): simple, without the support of any custom plugins.
    - The idea is that it requires only one line of code: registering the model in the file
    - Simple CRUD
    - Simplified Django-version of admin-panel
- Request validation like in Laravel
- Middleware
- Auth
    - Role system
- Seeds
- Helper-functions:
    - Cookies

#### Used technologies:
<ul>
    <li>Back-end
        <ul>
            <li><a href="https://medoo.in/">Medoo</a> -- for "speaking" with the database</li>
            <li><a href="https://symfony.com/doc/current/components/console.html">Symfony console</a> -- console commands
                <ul>
                    <li>"php public/index.php app:example-command"</li>
                </ul>
            </li>
            <li><a href="https://github.com/tightenco/collect">Collections</a> -- laravel-collections into non-laravel project</li>
            <li><a href="https://github.com/vlucas/phpdotenv">vlucas/phpdotenv"</a> -- parse .env-file</li>
            <li><a href="#">Carbon</a> -- well known Date/Time package</li>
        </ul>
    </li>
    <li>Front-end
        <ul>
            <li><a href="https://twig.symfony.com/">Twig</a> -- template-engine</li>
            <li><a href="https://mdbootstrap.com/">MBootstrap</a> -- bootstrap4-advanced</li>
        </ul>
    </li>
</ul>