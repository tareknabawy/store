<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$lapp_location = "../lapp"; // lapp folder location

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
 */

$array = array('en', 'ru', 'uk', 'tr');

if ($handle = opendir(__DIR__ . "/$lapp_location/resources/lang")) {
    $blacklist = array('.', '..');
    while (false !== ($file = readdir($handle))) {
        if (!in_array($file, $blacklist)) {

// Other Languages
            if (!in_array($file, $array)) {

                $admin = "        'slug' => 'Slug',
    'slug_in_use' => 'Slug in Use',
    'custom_meta_description' => 'Custom Meta Description',
    'enable_cache' => 'Enable System Cache',
    'pinned' => 'Pinned',
    'auto_comment_approval' => 'Approve Comments Automatically',
    'schema_breadcrumbs' => 'Schema.org Markup for Breadcrumbs',
    'cloudflare_ip' => 'The Site Runs on Cloudflare',
    'reading_time' => 'Show Estimated Reading Time on News Pages',
    'recommended_terms' => 'Recommended Search Terms',
    'browse' => 'Browse',
];";

                $general = "        'no_record_platform' => 'No record found in this platform',
                'recommended_terms' => 'Recommended Searches:',
];";

                $cookie_file_path = __DIR__ . "/$lapp_location/resources/lang/$file/admin.php";
                $contents = file_get_contents($cookie_file_path);
                file_put_contents($cookie_file_path, str_replace('];', $admin, $contents));

                $cookie_file_path = __DIR__ . "/$lapp_location/resources/lang/$file/general.php";
                $contents = file_get_contents($cookie_file_path);
                file_put_contents($cookie_file_path, str_replace('];', $general, $contents));

            }

            // English Language
            if ($file == 'en') {
                $en_admin = "        'slug' => 'Slug',
                'slug_in_use' => 'Slug in Use',
                'custom_meta_description' => 'Custom Meta Description',
                'enable_cache' => 'Enable System Cache',
                'pinned' => 'Pinned',
                'auto_comment_approval' => 'Approve Comments Automatically',
                'schema_breadcrumbs' => 'Schema.org Markup for Breadcrumbs',
                'cloudflare_ip' => 'The Site Runs on Cloudflare',
                'reading_time' => 'Show Estimated Reading Time on News Pages',
                'recommended_terms' => 'Recommended Search Terms',
                'browse' => 'Browse',
  ];";

                $en_general = "           'no_record_platform' => 'No record found in this platform',
                'recommended_terms' => 'Recommended Searches:',
  ];";

                $cookie_file_path = __DIR__ . "/$lapp_location/resources/lang/en/admin.php";
                $contents = file_get_contents($cookie_file_path);
                file_put_contents($cookie_file_path, str_replace('];', $en_admin, $contents));

                $cookie_file_path = __DIR__ . "/$lapp_location/resources/lang/en/general.php";
                $contents = file_get_contents($cookie_file_path);
                file_put_contents($cookie_file_path, str_replace('];', $en_general, $contents));
            }

            // Russian Language
            if ($file == 'ru') {
                $ru_admin = "            'slug' => 'Слаг',
                'slug_in_use' => 'Данный слаг уже используется',
                'custom_meta_description' => 'Пользовательское мета-описание',
                'enable_cache' => 'Включить системный кеш',
                'pinned' => 'Закреплено',
                'auto_comment_approval' => 'Утверждать комментарии автоматически',
                'schema_breadcrumbs' => 'Разметка Schema.org для хлебных крошек',
                'cloudflare_ip' => 'Сайт работает на Cloudflare',
                'reading_time' => 'Показывать приблизительное время чтения на страницах новостей',
                'recommended_terms' => 'Рекомендуемые условия поиска',
                'browse' => 'Просмотреть',
];";

                $ru_general = "           'no_record_platform' => 'Нет записей на этой платформе',
                'recommended_terms' => 'Рекомендуемые запросы:',
];";

                $cookie_file_path = __DIR__ . "/$lapp_location/resources/lang/ru/admin.php";
                $contents = file_get_contents($cookie_file_path);
                file_put_contents($cookie_file_path, str_replace('];', $ru_admin, $contents));

                $cookie_file_path = __DIR__ . "/$lapp_location/resources/lang/ru/general.php";
                $contents = file_get_contents($cookie_file_path);
                file_put_contents($cookie_file_path, str_replace('];', $ru_general, $contents));
            }

// Ukranian Language
            if ($file == 'uk') {
                $uk_admin = "            'slug' => 'Слаг',
                'slug_in_use' => 'Даний слаг вже використовується',
                'custom_meta_description' => 'Користувацький мета-опис',
                'enable_cache' => 'Включити системний кеш',
                'pinned' => 'Закріплено',
                'auto_comment_approval' => 'Схвалювати коментарі автоматично',
                'schema_breadcrumbs' => 'Розмітка Schema.org для хлібних крихт',
                'cloudflare_ip' => 'Сайт працює на Cloudflare',
                'reading_time' => 'Показувати приблизний час прочитання на сторінках новин',
                'recommended_terms' => 'Рекомендовані умови пошуку',
                'browse' => 'Переглянути',
  ];";

                $uk_general = "            'no_record_platform' => 'Немає записів на цій платформі',
                'recommended_terms' => 'Рекомендовані запити:',
  ];";

                $cookie_file_path = __DIR__ . "/$lapp_location/resources/lang/uk/admin.php";
                $contents = file_get_contents($cookie_file_path);
                file_put_contents($cookie_file_path, str_replace('];', $uk_admin, $contents));

                $cookie_file_path = __DIR__ . "/$lapp_location/resources/lang/uk/general.php";
                $contents = file_get_contents($cookie_file_path);
                file_put_contents($cookie_file_path, str_replace('];', $uk_general, $contents));
            }

// Turkish Language
            if ($file == 'tr') {
                $tr_admin = "              'slug' => 'Slug',
                'slug_in_use' => 'Slug Kullanımda',
                'custom_meta_description' => 'Özel Meta Açıklaması',
                'enable_cache' => 'Önbellek Sistemini Kullan',
                'pinned' => 'Sabitlenmiş',
                'auto_comment_approval' => 'Yorumları Otomatik Olarak Onayla',
                'schema_breadcrumbs' => 'Breadcrumbs\'lar için Schema.org İşaretlemesi Kullan',
                'cloudflare_ip' => 'Site Cloudflare Üzerinde Çalışıyor',
                'reading_time' => 'Haberler Sayfasında Tahmini Okunma Süresini Göster',
                'recommended_terms' => 'Önerilen Arama Kelimeleri',
                'browse' => 'Gözat',
  ];";

                $tr_general = "            'no_record_platform' => 'Bu platformda içerik bulunamadı',
                'recommended_terms' => 'Önerilen Aramalar:',
  ];";

                $cookie_file_path = __DIR__ . "/$lapp_location/resources/lang/tr/admin.php";
                $contents = file_get_contents($cookie_file_path);
                file_put_contents($cookie_file_path, str_replace('];', $tr_admin, $contents));

                $cookie_file_path = __DIR__ . "/$lapp_location/resources/lang/tr/general.php";
                $contents = file_get_contents($cookie_file_path);
                file_put_contents($cookie_file_path, str_replace('];', $tr_general, $contents));
            }

        }
    }
    closedir($handle);
}

require __DIR__ . "/$lapp_location/vendor/autoload.php";

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
 */

$app = require_once __DIR__ . "/$lapp_location/bootstrap/app.php";

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
 */

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Add rows to settings table

DB::update("INSERT INTO `settings` (`id`, `name`, `value`) VALUES (NULL, 'auto_comment_approval', '0');");
DB::update("INSERT INTO `settings` (`id`, `name`, `value`) VALUES (NULL, 'enable_cache', '1');");
DB::update("INSERT INTO `settings` (`id`, `name`, `value`) VALUES (NULL, 'schema_breadcrumbs', '1');");
DB::update("INSERT INTO `settings` (`id`, `name`, `value`) VALUES (NULL, 'cloudflare_ip', '0');");
DB::update("INSERT INTO `settings` (`id`, `name`, `value`) VALUES (NULL, 'reading_time', '1');");
DB::update("INSERT INTO `settings` (`id`, `name`, `value`) VALUES (NULL, 'recommended_terms', '');");

DB::update("ALTER TABLE categories
ADD description varchar(255) NULL
  AFTER title;");

DB::update("ALTER TABLE applications
ADD pinned int(1) NOT NULL DEFAULT 0
  AFTER featured;");

DB::update("ALTER TABLE applications
ADD custom_description varchar(255) NULL
  AFTER description;");

// Clear cache
Cache::flush();

echo "OK";