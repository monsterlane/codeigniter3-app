## codeigniter 3dev app shell

This project is meant as a starting point for modular high performance web and SAAS apps. If you use CSS sprite maps and the included asset caching, your site will meet every requirement of Yahoo's best practices for loading speed. See more here: http://developer.yahoo.com/performance/rules.html

## features

* HMVC like folder structure (controllers are in folders, views and assets are in controller folders, models are all in one folder for convenience)
* Automatic client side includes (controller/assets/js/script.js and controller/assets/css/style.css)
* Automatic client side module binding (with inheritance)
* Automatic css/js merging/minify/caching by group (system, controller level)
* Automatic favicon include (add favicon.ico to web root)
* Faux controller name-spacing (controllers are suffixed with _controller, models are not suffixed)
* Basic page templating (title, meta, css, js, page content)
* Basic email templating (email->template replaces email->message)
* Database logging of PHP errors (post controller construct)
* New methods for the output class (images with modified headers)
* Shorthand methods for the output class (string, json, appended output)
* Alternative html regex for the output class with better support for inline-block layouts
* Additional form validation methods (date)
* Additional array helpers
* Additional file helper
* Additional security helpers
* Upload helper
* Client side JS tools- modules, conduits, error checking
* Includes latest jQuery (1.10.2) http://jquery.com/
* Includes modified normalize.css (2.1.3) http://necolas.github.io/normalize.css/

## install

1. Download this package, extract and set your document root to the www folder.
2. Download CI3dev: https://github.com/EllisLab/CodeIgniter/
3. Put the system folder from CI in the folder containing www and docs
4. Download minify: http://code.google.com/p/minify/
5. Extract minify to application/third_part/minify
6. If you are using a database, fill in your credentials, import the schema file in the docs folder and enable hooks

## faq

* If you get an error about the Header command in the root htaccess file, ensure the apache module 'headers' is enabled

## license

(The MIT License) Copyright (c) 2013 Jonathan Down

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.