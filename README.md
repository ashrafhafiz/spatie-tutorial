<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Cloning The Tutorial

```angular2html
git clone https://github.com/ashrafhafiz/spatie-tutorial.git

cp .env.example .env

composer install

php artisan key:generate

php artisan migrate --seed
```
## Laravel Toastr Notifications
## Method 1: Direct & Easy Way
The easiest way if to follow this example: [Laravel 8 Toastr Notifications Example](https://techsolutionstuff.com/post/laravel-8-toastr-notifications-example)

Using toastr.js you can display a success message, warning message and error with the help of a session in laravel 8.

There are many types of notification available to display different messages in laravel 8 or PHP like display messages using bootstrap modal, simple pop-up notification using jquery, display notification using flash message, and toastr message notification. Also, you can customize as per your requirements like a progress bar, close button, the timing of notification showing.

First you need to add bootstrap CSS, toastr notification jquery, toastr CSS and toastr js in you main view blade file, I have added below CDN in **<head>** tag.
```html
<head>
    <title>Laravel 8 Toastr Notification Example - Techsolutionstuff</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0- 
     alpha/css/bootstrap.css" rel="stylesheet">
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>
```
Then after we will add differents toastr message in script tag like below.

```javascript
<script>
  @if(Session::has('message'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.error("{{ session('error') }}");
  @endif

  @if(Session::has('info'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.info("{{ session('info') }}");
  @endif

  @if(Session::has('warning'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.warning("{{ session('warning') }}");
  @endif
</script>
```

After that, we need to display messages in the view file using a redirect URL in the controller. So, we need to add some code in the controller also. So, copy the below code in your controller.

```php
return redirect()->route('your route name')->with('message','Data added Successfully');

return redirect()->route('your route name')->with('error','Data Deleted');

return redirect()->route('your route name')->with('Warning','Are you sure you want to delete? ');

return redirect()->route('your route name')->with('info','This is xyz information');
```

So, we are done with our code part for toastr notifications example In Laravel 8.

## Method 2: PHPFLasher
[PHPFlasher](https://php-flasher.github.io/docs/) offers a solid integration with the Laravel Framework, and it also supports older versions of the framework From laravel 4.0 to laravel 8.

PHPFlasher is a project by [Younes KHOUBZA](https://www.linkedin.com/in/younes-khoubza/).

### installation :

You can install the  **PHPFlasher**  Laravel package using composer.  
This is the base package for all Laravel adapters and which display  `tailwindcss`  notifications by default.

`composer require php-flasher/flasher-laravel`

Then add the service provider to  `config/app.php`.

> in Laravel version 5.5 and beyond this step can be skipped if package auto-discovery is enabled.

```ini
'providers' => [
    ...
    Flasher\Laravel\FlasherServiceProvider::class,
    ...
];

```

Optionally include the Facade in  `config/app.php`.

```kotlin
'Flasher' => Flasher\Laravel\Facade\Flasher::class,

```

As optional if you want to change the default configuration, you can publish the configuration file:

`php artisan vendor:publish --tag='flasher-config'`

### Usage:

1.  add  `@flasher_render`  at the bottom of your blade view

    ```xml
     <!doctype html>
     <html>
         <head>
             <title>PHP Flasher</title>
         </head>
         <body>
    
             @flasher_render
         </body>
     </html>
    
    ```

2.  dispatch  `notifications`  from anywhere in your application

    ```php
     namespace App\Http\Controllers;
    
     use App\Post;
     use App\Http\Requests\PostRequest;
     use Flasher\Prime\FlasherInterface;
    
     class PostController extends Controller
     {
         public function store(PostRequest $request, FlasherInterface $flasher)
         {
             $post = Post::create($request->only(['title', 'body']));
             $flasher->addSuccess('Data has been saved successfully!');
             return back();
         }
     }
    ```
    or by using Flasher Façade:
    ```php
     namespace App\Http\Controllers;
    
     use App\Post;
     use App\Http\Requests\PostRequest;
     use Flasher\Laravel\Facade\Flasher;
    
     class PostController extends Controller
     {
         public function store(PostRequest $request)
         {
             $post = Post::create($request->only(['title', 'body']));
             Flasher::addSuccess('Data has been saved successfully!');
             return back();
         }
     }
    ```
    or by using flasher helper function:
    ```php
     namespace App\Http\Controllers;
    
     use App\Post;
     use App\Http\Requests\PostRequest;
     use Flasher\Laravel\Facade\Flasher;
    
     class PostController extends Controller
     {
         public function store(PostRequest $request)
         {
             $post = Post::create($request->only(['title', 'body']));
             flasher('Data has been saved successfully!', 'success');
             return back();
         }
     }
    ```
## Method 3: Adding Toastr.js adapter for PHP flasher

For more information about Toastr.js click  [here](https://github.com/CodeSeven/toastr).

### Installation

**For Laravel:**

`composer require php-flasher/flasher-toastr-laravel`

### Usage

Just grave an instance of  `ToastrFactory`  and start calling build methods

```php
namespace App\Controller;

use Flasher\Toastr\Prime\ToastrFactory;

class NotifyController
{
    public function flasher(ToastrFactory $flasher)
    {
        // ... 
        $flasher->closeButton()->newestOnTop()->addSuccess('Data has been saved successfully!');
        
        // ... redirect or render a view here
    }
}    

```

### Toastr specific method builders

All methods in the  **[Usage](https://php-flasher.github.io/docs/usage/)**  section are available also for  `ToastrFactory`

```php
$flasher->title(string $title)
$flasher->closeButton(bool $closeButton = true)
$flasher->closeClass(string $closeClass)
$flasher->closeDuration(int $closeDuration)
$flasher->closeEasing(string $closeEasing)
$flasher->closeHtml(string $closeHtml)
$flasher->closeMethod(string $closeMethod)
$flasher->closeOnHover(bool $closeOnHover = true)
$flasher->containerId(string $containerId)
$flasher->debug(bool $debug = true)
$flasher->escapeHtml(bool $escapeHtml = true)
$flasher->extendedTimeOut(int $extendedTimeOut)
$flasher->hideDuration(int $hideDuration)
$flasher->hideEasing(string $hideEasing)
$flasher->hideMethod(string $hideMethod)
$flasher->iconClass(string $iconClass)
$flasher->messageClass(string $messageClass)
$flasher->newestOnTop(bool $newestOnTop = true)
$flasher->onHidden(string $onHidden)
$flasher->onShown(string $onShown)
$flasher->positionClass(string $positionClass)
$flasher->preventDuplicates(bool $preventDuplicates = true)
$flasher->progressClass(string $progressClass)
$flasher->rtl(bool $rtl = true)
$flasher->showDuration(int $showDuration)
$flasher->showEasing(string $showEasing)
$flasher->showMethod(string $showMethod)
$flasher->tapToDismiss(bool $tapToDismiss = true)
$flasher->target(string $target)
$flasher->timeOut(int $timeOut, bool $extendedTimeOut = null)
$flasher->titleClass(string $titleClass)
$flasher->toastClass(string $toastClass)
$flasher->persistent()
```

## Method 4: Using Notification Builder
If you’re using a framework like **Laravel** or **Symfony**, just grab an instance of **FlasherInterface** from the container, and you’re ready to go.

There are only  **two**  main steps to render a notification :  **build**  and  **flash**
```php
public function update(..., FlasherInterface $flasher)

// Step 1: create your notification and add options
$builder = $flasher->type('success')
    ->message('your custom message')
    ->priority(2)
    ->handler('toastr')
    ->option('timer', 5000)
;

// Step2 : Store the notification in the session
$builder->flash();

```

## Contributing

Thank you for considering contributing to my tutorial.

## Security Vulnerabilities

If you discover a security vulnerability within this tutorial, please send an e-mail to Ashraf Hafiz via [ashraf.hafiz@yahoo.com](mailto:ashraf.hafiz@yahoo.com).

## License

This tutorial is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
